@props(['title' => null, 'subtitle' => null])
<div {{ $attributes->merge(['class' => 'card p-5 sm:p-6']) }}>
    @if($title)
        <div class="mb-4">
            <h3 class="text-base font-semibold text-slate-900">{{ $title }}</h3>
            @if($subtitle)
                <p class="text-sm text-slate-500 mt-0.5">{{ $subtitle }}</p>
            @endif
        </div>
    @endif
    {{ $slot }}
</div>
