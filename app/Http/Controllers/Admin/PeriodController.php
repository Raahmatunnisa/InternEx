<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInternshipPeriodRequest;
use App\Http\Requests\UpdateInternshipPeriodRequest;
use App\Models\InternshipPeriod;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PeriodController extends Controller
{
    public function index(): View
    {
        $this->authorize('viewAny', InternshipPeriod::class);

        $periods = InternshipPeriod::withCount('internships')->latest()->paginate(10);

        return view('admin.periods.index', ['periods' => $periods]);
    }

    public function create(): View
    {
        $this->authorize('create', InternshipPeriod::class);

        return view('admin.periods.create');
    }

    public function store(StoreInternshipPeriodRequest $request): RedirectResponse
    {
        InternshipPeriod::create($request->validated());

        return redirect()->route('admin.periods.index')->with('success', 'Periode magang berhasil dibuat.');
    }

    public function edit(InternshipPeriod $period): View
    {
        $this->authorize('update', $period);

        return view('admin.periods.edit', ['period' => $period]);
    }

    public function update(UpdateInternshipPeriodRequest $request, InternshipPeriod $period): RedirectResponse
    {
        $period->update($request->validated());

        return redirect()->route('admin.periods.index')->with('success', 'Periode magang berhasil diperbarui.');
    }

    public function destroy(InternshipPeriod $period): RedirectResponse
    {
        $this->authorize('delete', $period);

        $period->delete();

        return redirect()->route('admin.periods.index')->with('success', 'Periode magang berhasil dihapus.');
    }
}
