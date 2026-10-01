<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePermitRequest;
use App\Models\Permit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PermitController extends Controller
{
    public function index(Request $request): View
    {
        $internship = $request->user()->internship;

        abort_if(! $internship, 403, 'Anda belum memiliki data magang aktif.');

        $permits = $internship->permits()->latest('start_date')->paginate(10);

        return view('permits.index', ['permits' => $permits]);
    }

    public function create(Request $request): View
    {
        $this->authorize('create', Permit::class);

        return view('permits.create');
    }

    public function store(StorePermitRequest $request): RedirectResponse
    {
        $internship = $request->user()->internship;

        $data = $request->validated();

        if ($request->hasFile('attachment')) {
            $data['attachment_path'] = $request->file('attachment')->store('permits', 'local');
        }

        $internship->permits()->create($data);

        return redirect()->route('permits.index')->with('success', 'Pengajuan izin berhasil dikirim dan menunggu persetujuan mentor.');
    }

    public function show(Permit $permit): View
    {
        $this->authorize('view', $permit);

        $permit->load(['internship.student', 'reviewer']);

        return view('permits.show', ['permit' => $permit]);
    }

    /**
     * Tampilkan dokumen pendukung (surat sakit/keterangan) di tab baru
     * tanpa memaksa download, hanya untuk pemilik izin atau mentor
     * pembimbingnya.
     */
    public function attachment(Permit $permit)
    {
        $this->authorize('view', $permit);

        abort_if(! $permit->attachment_path, 404);
        abort_unless(Storage::disk('local')->exists($permit->attachment_path), 404);

        return Storage::disk('local')->response($permit->attachment_path);
    }
}
