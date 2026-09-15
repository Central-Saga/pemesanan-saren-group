@php
    $waLink = 'https://wa.me/'.\App\Services\WhatsAppService::CS_NUMBER;
    $featured = \App\Models\Product::query()
        ->with('media')
        ->where('category', \App\Enums\ProductCategory::CUSTOM_SERVICE)
        ->orderBy('name')
        ->take(3)
        ->get()
        ->merge(
            \App\Models\Product::query()
                ->with('media')
                ->where('category', \App\Enums\ProductCategory::PHYSICAL_PRODUCT)
                ->orderBy('base_price')
                ->take(3)
                ->get()
        )
        ->take(6);

    $quickCategories = [
        ['slug' => 'banner-spanduk', 'name' => 'Banner & Spanduk', 'icon' => 'printer', 'price' => 'Rp 20.000 / m²'],
        ['slug' => 'stiker-custom', 'name' => 'Stiker & Label', 'icon' => 'photo', 'price' => 'Rp 15.000 / lbr'],
        ['slug' => 'kartu-nama', 'name' => 'Kartu Nama', 'icon' => 'clipboard-document-list', 'price' => 'Rp 35.000 / box'],
        ['slug' => 'kartu-undangan', 'name' => 'Undangan Acara', 'icon' => 'sparkles', 'price' => 'Rp 2.500 / pcs'],
        ['slug' => 'payung-sablon', 'name' => 'Merchandise & Sablon', 'icon' => 'shopping-bag', 'price' => 'Rp 45.000 / pcs'],
        ['slug' => 'jam-dinding-custom', 'name' => 'Jam Dinding Custom', 'icon' => 'clock', 'price' => 'Rp 65.000 / pcs'],
    ];
@endphp

<div class="flex flex-col gap-12 sm:gap-16 py-4">

    {{-- Hero Section --}}
    <section class="grid grid-cols-1 lg:grid-cols-[1.1fr_1fr] items-center gap-8 lg:gap-12 pt-4 pb-4">
        <div class="space-y-6">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-orange-50 text-[#FF6B00] border border-orange-200">
                <span class="w-2 h-2 rounded-full bg-[#FF6B00] animate-pulse"></span>
                Digital Printing • Sibang Kaja, Bali
            </div>

            <h1 class="text-3xl sm:text-4xl lg:text-[42px] font-extrabold leading-tight tracking-tight text-zinc-900 font-heading">
                Percetakan Digital Cepat, Presisi & Terpercaya di Bali
            </h1>

            <p class="text-base sm:text-lg leading-relaxed text-zinc-600 max-w-xl">
                Cetak spanduk outdoor, label kemasan, undangan, hingga merchandise usaha. Hitung kalkulator harga instan, upload desain, dan pantau produksi secara real-time.
            </p>

            <div class="flex flex-wrap items-center gap-3 pt-2">
                <a href="{{ route('catalog') }}" wire:navigate
                   class="inline-flex items-center gap-2 rounded-md bg-[#FF6B00] px-6 py-3.5 text-sm font-bold text-white shadow-sm transition hover:bg-[#E65100]">
                    Hitung & Pesan Sekarang
                    <flux:icon.arrow-right class="h-4 w-4" />
                </a>
                <a href="{{ route('catalog') }}" wire:navigate
                   class="inline-flex items-center gap-2 rounded-md border border-zinc-300 bg-white px-5 py-3.5 text-sm font-semibold text-zinc-700 transition hover:bg-zinc-50 hover:border-zinc-400">
                    <flux:icon.shopping-cart class="h-4 w-4 text-zinc-500" />
                    Lihat Katalog Lengkap
                </a>
            </div>

            <div class="pt-2 flex items-center gap-6 text-xs font-medium text-zinc-500">
                <span class="flex items-center gap-1.5"><flux:icon.check class="h-4 w-4 text-emerald-600" /> Hasil Tajam High-Res</span>
                <span class="flex items-center gap-1.5"><flux:icon.check class="h-4 w-4 text-emerald-600" /> Bisa Ambil di Tempat</span>
                <span class="flex items-center gap-1.5"><flux:icon.check class="h-4 w-4 text-emerald-600" /> Kirim Se-Bali</span>
            </div>
        </div>

        <div class="relative">
            <div class="relative aspect-[4/3] w-full overflow-hidden rounded-2xl border border-zinc-200 bg-zinc-100 shadow-md">
                {{-- Hero image: Workshop CV. Saren Grup, fallback to featured product --}}
                @if(file_exists(public_path('images/hero-workshop.jpg')))
                    <img src="{{ asset('images/hero-workshop.jpg') }}"
                         alt="Workshop Percetakan Modern CV. Saren Grup Bali"
                         class="absolute inset-0 h-full w-full object-cover" />
                @else
                    @php $heroProduct = $featured->first(fn ($p) => $p->getFirstMediaUrl('images')); @endphp
                    @if($heroProduct)
                        <img src="{{ $heroProduct->getFirstMediaUrl('images') }}"
                             alt="Percetakan Digital CV. Saren Grup"
                             class="absolute inset-0 h-full w-full object-cover" />
                    @else
                        <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-zinc-100 to-zinc-200">
                            <div class="text-center text-zinc-400 p-6">
                                <flux:icon.printer class="mx-auto h-16 w-16 text-zinc-400 mb-2" />
                                <p class="font-semibold text-sm text-zinc-700">CV. Saren Grup Digital Printing</p>
                                <p class="text-xs text-zinc-500 mt-0.5">Sentra Produksi & Percetakan Modern Sibang Kaja</p>
                            </div>
                        </div>
                    @endif
                @endif
                <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent p-4 text-white">
                    <div class="flex items-center justify-between text-xs">
                        <span class="font-medium">Workshop & Percetakan CV. Saren Grup</span>
                        <span class="font-mono text-zinc-300">Sibang Kaja, Badung</span>
                    </div>
                </div>
            </div>

            {{-- Floating Stat Pill --}}
            <div class="absolute -bottom-4 -left-4 hidden sm:flex items-center gap-3 bg-white border border-zinc-200 shadow-lg rounded-xl px-4 py-2.5">
                <div class="w-8 h-8 rounded-lg bg-orange-100 text-[#FF6B00] flex items-center justify-center font-bold">
                    <flux:icon.printer class="h-4 w-4" />
                </div>
                <div>
                    <div class="text-xs font-bold text-zinc-900 font-mono">3+ Mesin Cetak</div>
                    <div class="text-[10px] text-zinc-500">Outdoor & Indoor UV</div>
                </div>
            </div>
        </div>
    </section>

    {{-- Kategori Cepat --}}
    <section class="space-y-4">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-zinc-900 font-heading">Kategori Percetakan Cepat</h2>
                <p class="text-xs sm:text-sm text-zinc-500">Pilih jenis cetakan untuk hitung kalkulator harga instan.</p>
            </div>
            <a href="{{ route('catalog') }}" wire:navigate class="text-xs sm:text-sm font-semibold text-[#FF6B00] hover:text-[#E65100]">
                Semua Produk &rarr;
            </a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4">
            @foreach($quickCategories as $cat)
                <a href="{{ route('catalog') }}" wire:navigate
                   class="group flex flex-col p-3.5 sm:p-4 bg-white rounded-xl border border-zinc-200 hover:border-[#FF6B00] hover:shadow-md transition">
                    <div class="w-9 h-9 rounded-lg bg-zinc-100 group-hover:bg-orange-50 text-zinc-700 group-hover:text-[#FF6B00] flex items-center justify-center mb-3 transition">
                        @if($cat['icon'] === 'printer')
                            <flux:icon.printer class="size-5" />
                        @elseif($cat['icon'] === 'photo')
                            <flux:icon.photo class="size-5" />
                        @elseif($cat['icon'] === 'clipboard-document-list')
                            <flux:icon.clipboard-document-list class="size-5" />
                        @elseif($cat['icon'] === 'sparkles')
                            <flux:icon.sparkles class="size-5" />
                        @elseif($cat['icon'] === 'shopping-bag')
                            <flux:icon.shopping-bag class="size-5" />
                        @else
                            <flux:icon.clock class="size-5" />
                        @endif
                    </div>
                    <h3 class="font-bold text-xs sm:text-sm text-zinc-900 group-hover:text-[#FF6B00] transition line-clamp-1">{{ $cat['name'] }}</h3>
                    <p class="font-mono text-[11px] text-zinc-500 mt-1">{{ $cat['price'] }}</p>
                </a>
            @endforeach
        </div>
    </section>

    {{-- Produk Unggulan --}}
    <section class="space-y-6">
        <div class="flex items-end justify-between border-b border-zinc-200 pb-3">
            <div>
                <h2 class="text-2xl font-bold text-zinc-900 font-heading">Produk Unggulan</h2>
                <p class="mt-1 text-sm text-zinc-500">Layanan cetak paling sering dipesan oleh pelanggan bisnis dan instansi.</p>
            </div>
            <a href="{{ route('catalog') }}" wire:navigate class="text-sm font-semibold text-[#FF6B00] hover:text-[#E65100]">
                Lihat Katalog &rarr;
            </a>
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @forelse($featured as $product)
                <a href="{{ route('product.detail', $product->slug) }}" wire:navigate
                   class="group flex flex-col overflow-hidden rounded-xl border border-zinc-200 bg-white transition hover:-translate-y-0.5 hover:shadow-lg hover:border-zinc-300">
                    <div class="aspect-[4/3] w-full overflow-hidden bg-zinc-100 relative">
                        @if($product->getFirstMediaUrl('images', 'thumb'))
                            <img src="{{ $product->getFirstMediaUrl('images', 'thumb') }}" alt="{{ $product->name }}"
                                 class="h-full w-full object-cover transition duration-300 group-hover:scale-105" loading="lazy" />
                        @else
                            <div class="flex h-full w-full items-center justify-center">
                                <flux:icon.photo class="h-10 w-10 text-zinc-300" />
                            </div>
                        @endif
                        <span class="absolute top-3 left-3 rounded-full px-2.5 py-0.5 text-xs font-semibold backdrop-blur-md shadow-sm
                            {{ $product->category === \App\Enums\ProductCategory::CUSTOM_SERVICE
                                ? 'bg-orange-500/90 text-white'
                                : 'bg-zinc-800/90 text-white' }}">
                            {{ $product->category->getLabel() }}
                        </span>
                    </div>
                    <div class="flex flex-1 flex-col p-4 sm:p-5">
                        <h3 class="font-bold text-base text-zinc-900 group-hover:text-[#FF6B00] transition">{{ $product->name }}</h3>
                        <p class="mt-1.5 line-clamp-2 text-xs sm:text-sm text-zinc-500">{{ $product->description }}</p>
                        <div class="mt-auto flex items-end justify-between pt-4 border-t border-zinc-100 mt-4">
                            <div>
                                <p class="text-[11px] text-zinc-400">Mulai dari</p>
                                <p class="text-base font-bold text-zinc-900 font-mono">{{ $product->base_price_formatted }}</p>
                            </div>
                            <span class="rounded-md bg-[#FF6B00] px-3.5 py-1.5 text-xs font-bold text-white transition group-hover:bg-[#E65100]">
                                Hitung & Pesan
                            </span>
                        </div>
                    </div>
                </a>
            @empty
                <p class="col-span-full text-sm text-zinc-500 py-8 text-center bg-zinc-50 rounded-xl">Katalog segera hadir.</p>
            @endforelse
        </div>
    </section>

    {{-- Cara Pemesanan --}}
    <section class="space-y-6 bg-zinc-50 rounded-2xl border border-zinc-200 p-6 sm:p-8">
        <div class="text-center max-w-xl mx-auto">
            <h2 class="text-2xl font-bold text-zinc-900 font-heading">Cara Pemesanan Praktis</h2>
            <p class="mt-1 text-sm text-zinc-500">4 langkah mudah dari kalkulasi spesifikasi hingga pesanan siap diambil.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach([
                ['step' => '1', 'icon' => 'calculator', 'title' => 'Pilih & Hitung', 'desc' => 'Tentukan ukuran (P x L) dan varian bahan, harga terhitung otomatis.'],
                ['step' => '2', 'icon' => 'photo', 'title' => 'Upload Desain', 'desc' => 'Unggah file siap cetak (PDF, TIFF, CDR, PNG, JPG high-res).'],
                ['step' => '3', 'icon' => 'shopping-cart', 'title' => 'Checkout & Bayar', 'desc' => 'Konfirmasi detail pesanan dan koordinasi via WhatsApp CS.'],
                ['step' => '4', 'icon' => 'truck', 'title' => 'Lacak Produksi', 'desc' => 'Pantau status pengerjaan real-time hingga pesanan selesai.'],
            ] as $step)
                <div class="flex flex-col bg-white rounded-xl border border-zinc-200 p-5 shadow-sm">
                    <div class="flex items-center justify-between mb-3">
                        <span class="flex h-7 w-7 items-center justify-center rounded-full bg-[#FF6B00] text-xs font-bold text-white font-mono">
                            {{ $step['step'] }}
                        </span>
                        @if($step['icon'] === 'calculator')
                            <flux:icon.calculator class="size-5 text-zinc-400" />
                        @elseif($step['icon'] === 'photo')
                            <flux:icon.photo class="size-5 text-zinc-400" />
                        @elseif($step['icon'] === 'shopping-cart')
                            <flux:icon.shopping-cart class="size-5 text-zinc-400" />
                        @else
                            <flux:icon.truck class="size-5 text-zinc-400" />
                        @endif
                    </div>
                    <h3 class="font-bold text-sm text-zinc-900">{{ $step['title'] }}</h3>
                    <p class="mt-1 text-xs text-zinc-500 leading-relaxed">{{ $step['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Trust Strip --}}
    <section class="rounded-xl border border-zinc-200 bg-white p-6 sm:p-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
            <div class="space-y-1">
                <p class="font-mono text-2xl sm:text-3xl font-bold text-[#FF6B00]">2009</p>
                <p class="text-xs sm:text-sm font-semibold text-zinc-800">Berpengalaman</p>
                <p class="text-[11px] text-zinc-500">Lebih dari 15 tahun melayani</p>
            </div>
            <div class="space-y-1">
                <p class="font-mono text-2xl sm:text-3xl font-bold text-zinc-900">3+ Unit</p>
                <p class="text-xs sm:text-sm font-semibold text-zinc-800">Mesin Cetak Modern</p>
                <p class="text-[11px] text-zinc-500">Outdoor & Indoor Hi-Res</p>
            </div>
            <div class="space-y-1">
                <p class="font-mono text-2xl sm:text-3xl font-bold text-zinc-900">12+ Tim</p>
                <p class="text-xs sm:text-sm font-semibold text-zinc-800">Tenaga Operator Ahli</p>
                <p class="text-[11px] text-zinc-500">Quality check setiap cetakan</p>
            </div>
            <div class="space-y-1">
                <p class="font-mono text-2xl sm:text-3xl font-bold text-emerald-600">100%</p>
                <p class="text-xs sm:text-sm font-semibold text-zinc-800">Garansi Kepuasan</p>
                <p class="text-[11px] text-zinc-500">Komitmen hasil terbaik</p>
            </div>
        </div>
    </section>

    {{-- Track Pesanan Card --}}
    <section id="track" class="scroll-mt-24">
        <div class="mx-auto max-w-2xl rounded-2xl border border-zinc-200 bg-white p-6 sm:p-8 text-center shadow-sm">
            <div class="w-12 h-12 rounded-full bg-orange-50 text-[#FF6B00] flex items-center justify-center mx-auto mb-3">
                <flux:icon.magnifying-glass class="size-6" />
            </div>
            <h2 class="text-2xl font-bold text-zinc-900 font-heading">Lacak Progres Pesanan</h2>
            <p class="mt-1 text-sm text-zinc-500">Masukkan nomor invoice untuk memantau tahapan verifikasi file, cetak, hingga siap diambil.</p>

            <div class="mt-6 max-w-md mx-auto space-y-3">
                <flux:input wire:model="trackInvoice" wire:keydown.enter="goTrack" placeholder="Contoh: SRN-20260830-0101" icon="magnifying-glass" />
                <flux:error name="trackInvoice" />
                <flux:button wire:click="goTrack" variant="primary" class="w-full bg-[#FF6B00] hover:bg-[#E65100] text-white font-bold py-2.5">
                    Lacak Invoice Sekarang
                </flux:button>
            </div>
        </div>
    </section>

    {{-- CTA Band --}}
    <section class="rounded-2xl bg-[#1A1B1E] text-white p-6 sm:p-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-6 shadow-md">
        <div class="space-y-2 max-w-xl">
            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">
                Konsultasi & Custom Order
            </span>
            <h3 class="text-xl sm:text-2xl font-bold text-white font-heading">Punya Kebutuhan Cetak Spesifik atau File Siap Cetak?</h3>
            <p class="text-xs sm:text-sm text-zinc-400">Tim kami siap membantu pengecekan resolusi file, rekomendasi bahan, dan penawaran harga terbaik.</p>
        </div>
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full md:w-auto">
            <a href="{{ $waLink }}" target="_blank"
               class="inline-flex items-center justify-center gap-2 rounded-md bg-[#16A34A] hover:bg-[#15803D] px-6 py-3 text-sm font-bold text-white transition shadow-sm">
                <flux:icon.chat-bubble-oval-left-ellipsis class="h-4 w-4" />
                Chat WhatsApp CS
            </a>
        </div>
    </section>

    {{-- Profil & Kontak Singkat --}}
    <section class="grid gap-6 md:grid-cols-3">
        <div class="rounded-xl border border-zinc-200 bg-white p-5 space-y-2">
            <div class="flex items-center gap-2 text-zinc-900 font-bold text-sm">
                <flux:icon.map-pin class="size-4 text-[#FF6B00]" />
                Alamat Workshop
            </div>
            <p class="text-xs text-zinc-600 leading-relaxed">
                Jalan Raya Rijasa No. 6, Sibang Kaja, Kec. Abiansemal, Kab. Badung, Bali 80352
            </p>
        </div>

        <div class="rounded-xl border border-zinc-200 bg-white p-5 space-y-2">
            <div class="flex items-center gap-2 text-zinc-900 font-bold text-sm">
                <flux:icon.chat-bubble-oval-left-ellipsis class="size-4 text-[#16A34A]" />
                Kontak & CS
            </div>
            <div class="text-xs text-zinc-600 space-y-1">
                <p>WA: <a href="{{ $waLink }}" target="_blank" class="text-[#FF6B00] font-mono font-medium hover:underline">+62 878-6004-2888</a></p>
                <p>Email: <a href="mailto:sarengrup@gmail.com" class="text-zinc-700 hover:underline">sarengrup@gmail.com</a></p>
            </div>
        </div>

        <div class="rounded-xl border border-zinc-200 bg-white p-5 space-y-2">
            <div class="flex items-center gap-2 text-zinc-900 font-bold text-sm">
                <flux:icon.clock class="size-4 text-zinc-700" />
                Jam Operasional
            </div>
            <p class="text-xs text-zinc-600 leading-relaxed">
                Senin – Sabtu: 08.00 – 18.00 WITA<br />
                <span class="text-zinc-400">Minggu & Hari Libur Nasional: Tutup</span>
            </p>
        </div>
    </section>

</div>
