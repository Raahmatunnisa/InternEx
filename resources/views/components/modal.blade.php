@props(['id', 'title' => null])
<div id="{{ $id }}" class="hidden fixed inset-0 z-50 items-center justify-center bg-slate-900/50 backdrop-blur-sm px-4">
    <div class="card w-full max-w-md p-6" role="dialog" aria-modal="true" aria-labelledby="{{ $id }}-title">
        <div class="flex items-start justify-between mb-4">
            <h3 id="{{ $id }}-title" class="text-base font-semibold text-slate-900">{{ $title }}</h3>
            <button type="button" onclick="toggleModal('{{ $id }}')" aria-label="Tutup" class="text-slate-400 hover:text-slate-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded-lg">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        {{ $slot }}
    </div>
</div>
