<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLogbookRequest;
use App\Http\Requests\UpdateLogbookRequest;
use App\Models\Logbook;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LogbookController extends Controller
{
    public function index(Request $request): View
    {
        $internship = $request->user()->internship;

        abort_if(! $internship, 403, 'Anda belum memiliki data magang aktif.');

        $logbooks = $internship->logbooks()
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')))
            ->when($request->filled('date_from'), fn ($q) => $q->whereDate('date', '>=', $request->date('date_from')))
            ->when($request->filled('date_to'), fn ($q) => $q->whereDate('date', '<=', $request->date('date_to')))
            ->when($request->filled('search'), fn ($q) => $q->where('activity', 'like', '%'.$request->string('search').'%'))
            ->latest('date')
            ->paginate(10)
            ->withQueryString();

        return view('logbooks.index', ['logbooks' => $logbooks]);
    }

    public function create(Request $request): View
    {

        return view('logbooks.create');
    }

    public function store(StoreLogbookRequest $request): RedirectResponse
    {
        $internship = $request->user()->internship;

        $data = $request->validated();

        $internship->logbooks()->create($data);

        return redirect()->route('logbooks.index')->with('success', 'Logbook berhasil ditambahkan.');
    }

    public function show(Logbook $logbook): View
    {
        $this->authorize('view', $logbook);

        $logbook->load(['feedbacks.mentor', 'internship']);

        return view('logbooks.show', ['logbook' => $logbook]);
    }

    public function edit(Logbook $logbook): View
    {
        $this->authorize('update', $logbook);

        return view('logbooks.edit', ['logbook' => $logbook]);
    }

    public function update(UpdateLogbookRequest $request, Logbook $logbook): RedirectResponse
    {
        $data = $request->validated();

        // Jika logbook sebelumnya ditolak dan diperbaiki, kembalikan status menjadi submitted.
        if ($logbook->status === 'rejected') {
            $data['status'] = 'submitted';
        }

        $logbook->update($data);

        return redirect()->route('logbooks.show', $logbook)->with('success', 'Logbook berhasil diperbarui.');
    }

    public function destroy(Logbook $logbook): RedirectResponse
    {
        $this->authorize('delete', $logbook);

        $logbook->delete();

        return redirect()->route('logbooks.index')->with('success', 'Logbook berhasil dihapus.');
    }
}
