<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - InternX</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js" defer></script>
</head>
<body class="min-h-screen bg-[#F8FAFC]">
    <div class="flex min-h-screen">
        {{-- Sidebar Desktop --}}
        <aside class="hidden lg:flex lg:flex-col lg:w-64 bg-[#0F172A] text-white flex-shrink-0">
            @include('partials.sidebar-content')
        </aside>

        {{-- Sidebar Mobile Drawer --}}
        <div id="mobile-sidebar-overlay" class="hidden fixed inset-0 bg-slate-900/60 z-40 lg:hidden" onclick="toggleMobileSidebar()"></div>
        <aside id="mobile-sidebar" class="fixed inset-y-0 left-0 w-72 bg-[#0F172A] text-white z-50 -translate-x-full transition-transform duration-300 lg:hidden">
            @include('partials.sidebar-content')
        </aside>

        {{-- Main content --}}
        <div class="flex-1 flex flex-col min-w-0">
            {{-- Mobile top bar --}}
            <header class="lg:hidden sticky top-0 z-30 bg-white border-b border-slate-200 px-4 py-3 flex items-center justify-between">
                <button type="button" onclick="toggleMobileSidebar()" aria-label="Buka menu" class="p-2 rounded-lg hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <i data-lucide="menu" class="w-6 h-6 text-slate-700"></i>
                </button>
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center">
                        <i data-lucide="clipboard-check" class="w-4 h-4 text-white"></i>
                    </div>
                    <span class="font-bold text-slate-900">InternX</span>
                </div>
                <div class="w-9"></div>
            </header>

            <main class="flex-1 p-4 sm:p-6 lg:p-8 max-w-7xl w-full mx-auto">
                @if(session('success'))
                    <div id="flash-message" class="mb-6">
                        <x-alert type="success">
                            <i data-lucide="check-circle-2" class="w-5 h-5 shrink-0"></i>
                            <span>{{ session('success') }}</span>
                        </x-alert>
                    </div>
                @endif

                @if(session('error'))
                    <div id="flash-message" class="mb-6">
                        <x-alert type="error">
                            <i data-lucide="circle-alert" class="w-5 h-5 shrink-0"></i>
                            <span>{{ session('error') }}</span>
                        </x-alert>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => lucide.createIcons());
        document.addEventListener('livewire:navigated', () => lucide.createIcons());
    </script>
</body>
</html>
