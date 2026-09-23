@props(['label' => null, 'name', 'type' => 'text', 'value' => null, 'required' => false, 'toggle' => false])
<div>
    @if($label)
        <label for="{{ $name }}" class="form-label">{{ $label }} @if($required)<span class="text-red-500">*</span>@endif</label>
    @endif
    @if($type === 'password' && $toggle)
        <div class="relative">
            <input
                type="password"
                name="{{ $name }}"
                id="{{ $name }}"
                value="{{ old($name, $value) }}"
                {{ $attributes->merge(['class' => 'form-input pr-11']) }}
                @if($required) required @endif
            >
            <button
                type="button"
                onclick="togglePasswordVisibility('{{ $name }}', this)"
                aria-label="Tampilkan/sembunyikan password"
                class="absolute inset-y-0 right-0 flex items-center px-3.5 text-slate-400 hover:text-slate-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded-lg"
            >
                <i data-lucide="eye" class="w-4 h-4"></i>
            </button>
        </div>
    @else
        <input
            type="{{ $type }}"
            name="{{ $name }}"
            id="{{ $name }}"
            value="{{ old($name, $value) }}"
            {{ $attributes->merge(['class' => 'form-input']) }}
            @if($required) required @endif
        >
    @endif
    @error($name)
        <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
