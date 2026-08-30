<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white text-zinc-900 antialiased">
        <header class="sticky top-0 z-40 border-b border-zinc-200 bg-white/95 backdrop-blur">
            <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-4 py-3">
                <a href="{{ route('home') }}" class="flex items-center gap-2 font-semibold" wire:navigate>
                    <x-app-logo class="h-8 w-8" />
                    <span class="text-sm font-bold tracking-tight">CV. Saren Grup</span>
                </a>

                <nav class="flex items-center gap-1 sm:gap-2">
                    <flux:button variant="ghost" href="{{ route('catalog') }}" wire:navigate>
                        Katalog
                    </flux:button>
                    <flux:button variant="ghost" href="{{ route('home') }}#track" wire:navigate>
                        Lacak Pesanan
                    </flux:button>
                    <livewire:frontend.cart-drawer />
                </nav>
            </div>
        </header>

        <main class="mx-auto max-w-6xl px-4 py-6">
            {{ $slot }}
        </main>

        <footer class="border-t border-zinc-200 bg-zinc-50 py-8 mt-12">
            <div class="mx-auto max-w-6xl px-4 space-y-2 text-sm text-zinc-600">
                <p class="font-semibold text-zinc-900">CV. Saren Grup — Percetakan Digital</p>
                <p>Jalan Raya Rijasa No. 6 Sibang Kaja, Abiansemal, Badung, Bali</p>
                <p>WhatsApp: <a href="https://wa.me/6287860042888" class="text-indigo-600 hover:underline">62878-6004-2888</a> &middot; Email: sarengrup@gmail.com &middot; Instagram: @cvsaren_grup</p>
            </div>
        </footer>
    </body>
</html>
