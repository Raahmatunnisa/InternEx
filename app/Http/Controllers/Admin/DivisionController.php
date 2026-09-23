<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DivisionRequest;
use App\Models\Division;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DivisionController extends Controller
{
    public function index(): View
    {
        $divisions = Division::withCount('internships')->orderBy('name')->paginate(10);

        return view('admin.divisions.index', ['divisions' => $divisions]);
    }

    public function store(DivisionRequest $request): RedirectResponse
    {
        Division::create($request->validated());

        return back()->with('success', 'Bagian/divisi berhasil ditambahkan.');
    }

    public function update(DivisionRequest $request, Division $division): RedirectResponse
    {
        $division->update($request->validated());

        return back()->with('success', 'Bagian/divisi berhasil diperbarui.');
    }

    public function destroy(Division $division): RedirectResponse
    {
        if ($division->internships()->exists()) {
            return back()->with('error', 'Bagian tidak dapat dihapus karena masih digunakan oleh mahasiswa.');
        }

        $division->delete();

        return back()->with('success', 'Bagian/divisi berhasil dihapus.');
    }
}
