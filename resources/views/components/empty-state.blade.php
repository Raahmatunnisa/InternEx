@props(['title' => 'Belum ada data', 'description' => null, 'icon' => 'inbox'])
<div class="flex flex-col items-center justify-center text-center py-14 px-4">
    <div class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center mb-4">
        <i data-lucide="{{ $icon }}" class="w-8 h-8 text-slate-400"></i>
    </div>
    <h3 class="text-sm font-semibold text-slate-700">{{ $title }}</h3>
    @if($description)
        <p class="text-sm text-slate-500 mt-1 max-w-sm">{{ $description }}</p>
    @endif
    @isset($action)
        <div class="mt-4">{{ $action }}</div>
    @endisset
</div>
