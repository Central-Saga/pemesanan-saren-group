<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
        @fluxScripts
    </head>
    <body class="min-h-screen flex flex-col bg-white text-zinc-900 antialiased">
        {{-- Nav --}}
        <header class="sticky top-0 z-40 border-b border-zinc-200 bg-white/95 backdrop-blur">
            <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-4 py-3">
                <a href="{{ route('home') }}" class="text-lg font-bold tracking-tight text-zinc-900" wire:navigate>
                    Saren Grup
                </a>

                <nav class="hidden items-center gap-5 text-sm sm:flex">
                    <a href="{{ route('catalog') }}" wire:navigate class="text-zinc-500 transition hover:text-zinc-900">Katalog</a>
                    <a href="{{ route('home') }}#track" wire:navigate class="text-zinc-500 transition hover:text-zinc-900">Tracking</a>
                </nav>

                <div class="flex items-center gap-2">
                    <livewire:frontend.cart-drawer />
                    <a href="{{ route('catalog') }}" wire:navigate
                       class="hidden rounded-md bg-[#FF6B00] px-4 py-2 text-xs font-bold text-white transition hover:bg-[#E65100] sm:inline-block">
                        Quick Order
                    </a>
                </div>
            </div>
        </header>

        {{-- Main --}}
        <main class="flex-1">
            <div class="mx-auto max-w-6xl px-4 py-6">
                {{ $slot }}
            </div>
        </main>

        {{-- Footer --}}
        <footer class="mt-auto border-t border-zinc-200 bg-zinc-50">
            <div class="mx-auto grid max-w-6xl gap-8 px-4 py-10 text-sm text-zinc-500 sm:grid-cols-2 lg:grid-cols-3">
                <div class="space-y-2">
                    <h3 class="text-base font-bold text-zinc-900">Saren Grup</h3>
                    <p>&copy; {{ date('Y') }} CV. Saren Grup. Sibang Kaja, Bali.</p>
                </div>
                <div class="space-y-2">
                    <a href="https://maps.google.com/?q=Jl+Raya+Rijasa+Sibang+Kaja" target="_blank" rel="noopener" class="block hover:text-zinc-900">Lokasi Workshop</a>
                    <p>Senin – Sabtu, 08.00 – 18.00 WITA</p>
                </div>
                <div class="space-y-2">
                    <a href="https://wa.me/6287860042888" target="_blank" rel="noopener" class="block hover:text-zinc-900">WhatsApp Support</a>
                    <a href="mailto:sarengrup@gmail.com" class="block hover:text-zinc-900">sarengrup@gmail.com</a>
                </div>
            </div>
        </footer>
    </body>
</html>