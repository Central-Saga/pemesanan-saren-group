<x-layouts::app :title="__('Dashboard')">
    <div class="flex flex-col gap-6 w-full">
        <div class="border-b border-zinc-200 pb-4">
            <h1 class="text-2xl font-bold text-zinc-900 font-heading">Halo, {{ auth()->user()->name }}!</h1>
            <p class="text-sm text-zinc-500 mt-1">Selamat datang di akun Saren Grup Anda. Kelola pesanan cetak dan pantau proses produksi dengan mudah.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            {{-- Buat Pesanan --}}
            <a href="{{ route('catalog') }}" class="group block p-5 bg-white rounded-xl border border-zinc-200 shadow-sm hover:border-[#FF6B00] hover:shadow-md transition">
                <div class="w-10 h-10 rounded-lg bg-orange-50 text-[#FF6B00] flex items-center justify-center mb-3 group-hover:scale-105 transition">
                    <flux:icon.shopping-cart class="size-5" />
                </div>
                <h3 class="font-semibold text-zinc-900 group-hover:text-[#FF6B00] transition">Buat Pesanan Baru</h3>
                <p class="text-xs text-zinc-500 mt-1">Pilih layanan percetakan, hitung dimensi ukuran, dan order langsung.</p>
            </a>

            {{-- Pesanan Saya --}}
            <a href="{{ route('orders.my') }}" class="group block p-5 bg-white rounded-xl border border-zinc-200 shadow-sm hover:border-[#FF6B00] hover:shadow-md transition">
                <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center mb-3 group-hover:scale-105 transition">
                    <flux:icon.clipboard-document-list class="size-5" />
                </div>
                <h3 class="font-semibold text-zinc-900 group-hover:text-blue-600 transition">Pesanan Saya</h3>
                <p class="text-xs text-zinc-500 mt-1">Lihat riwayat pembelian dan pantau status transaksi Anda.</p>
            </a>

            {{-- Lacak Invoice --}}
            <a href="{{ route('home') }}#track" class="group block p-5 bg-white rounded-xl border border-zinc-200 shadow-sm hover:border-[#FF6B00] hover:shadow-md transition">
                <div class="w-10 h-10 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center mb-3 group-hover:scale-105 transition">
                    <flux:icon.magnifying-glass class="size-5" />
                </div>
                <h3 class="font-semibold text-zinc-900 group-hover:text-emerald-600 transition">Lacak Invoice</h3>
                <p class="text-xs text-zinc-500 mt-1">Pantau timeline produksi dan pengiriman pesanan secara real-time.</p>
            </a>
        </div>

        @if(auth()->user()->hasRole('super_admin'))
            <div class="p-5 bg-zinc-900 text-white rounded-xl shadow-sm flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-orange-500/20 text-orange-400 mb-1 border border-orange-500/30">
                        Akses Super Admin
                    </div>
                    <h3 class="text-base font-bold text-white">Panel Manajemen Percetakan</h3>
                    <p class="text-xs text-zinc-400 mt-0.5">Kelola data master produk, kalkulator harga, transaksi, dan verifikasi file cetak.</p>
                </div>
                <flux:button href="{{ url('/admin') }}" variant="primary" size="sm" icon="cog-6-tooth" class="bg-[#FF6B00] hover:bg-[#E65100] text-white">
                    Buka Filament Panel
                </flux:button>
            </div>
        @endif
    </div>
</x-layouts::app>
