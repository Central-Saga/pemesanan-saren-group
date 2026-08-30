@php
    $waNumber = '6287860042888';
    $waLink = 'https://wa.me/' . $waNumber;
@endphp

<div class="space-y-12">
    {{-- Hero --}}
    <section class="py-12 text-center">
        <flux:heading size="2xl" class="font-bold">Percetakan Digital CB. Saren Grup</flux:heading>
        <flux:text size="lg" class="mx-auto mt-3 max-w-2xl">
            Pusat digital printing & percetakan profesional di Sibang Kaja, Badung, Bali. Cetak spanduk, stiker, kartu nama, undangan, payung souvenir, jam dinding custom, dan produk ATK.
        </flux:text>
        <div class="mt-6 flex flex-wrap justify-center gap-3">
            <flux:button variant="primary" href="{{ route('catalog') }}" wire:navigate icon="shopping-bag">
                Pesan Sekarang
            </flux:button>
            <flux:button variant="subtle" href="{{ $waLink }}" target="_blank" icon="chat-bubble-bottom-center-text">
                Chat WhatsApp CS
            </flux:button>
        </div>
    </section>

    {{-- Layanan Unggulan --}}
    <section>
        <flux:heading size="xl" class="mb-4 text-center">Layanan Kami</flux:heading>
        <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
            <flux:card><flux:heading size="md">Banner & Spanduk</flux:heading><flux:text class="text-sm">Outdoor/indoor, Flex China & Korea.</flux:text></flux:card>
            <flux:card><flux:heading size="md">Stiker Custom</flux:heading><flux:text class="text-sm">Die cut, kiss cut, berbagai bahan.</flux:text></flux:card>
            <flux:card><flux:heading size="md">Kartu Nama & Undangan</flux:heading><flux:text class="text-sm">Art paper eksklusif, laminasi.</flux:text></flux:card>
            <flux:card><flux:heading size="md">Produk Fisik & ATK</flux:heading><flux:text class="text-sm">Kertas, tinta, materai, alat tulis.</flux:text></flux:card>
        </div>
    </section>

    {{-- Cara Pesan --}}
    <section>
        <flux:heading size="xl" class="mb-4 text-center">Cara Pemesanan</flux:heading>
        <ol class="mx-auto grid max-w-3xl grid-cols-1 gap-4 sm:grid-cols-3">
            <flux:card><span class="text-3xl font-bold text-indigo-600">1</span><flux:heading size="md" class="mt-2">Pilih & Hitung</flux:heading><flux:text class="text-sm">Pilih produk, hitung harga real-time di kalkulator.</flux:text></flux:card>
            <flux:card><span class="text-3xl font-bold text-indigo-600">2</span><flux:heading size="md" class="mt-2">Upload & Checkout</flux:heading><flux:text class="text-sm">Upload file desain, isi data, checkout via WhatsApp.</flux:text></flux:card>
            <flux:card><span class="text-3xl font-bold text-indigo-600">3</span><flux:heading size="md" class="mt-2">Lacak Pesanan</flux:heading><flux:text class="text-sm">Pantau status produksi hingga siap diambil.</flux:text></flux:card>
        </ol>
    </section>

    {{-- Track Pesanan --}}
    <section id="track">
        <flux:card class="mx-auto max-w-xl text-center">
            <flux:heading size="lg">Lacak Pesanan</flux:heading>
            <flux:text class="mt-1">Masukkan nomor invoice untuk melihat status produksi.</flux:text>
            <flux:input wire:model="trackInvoice" placeholder="Contoh: SRN-20260830-0001" class="mt-4" icon="magnifying-glass" />
            <flux:button variant="primary" class="mt-4" wire:click="goTrack">Lacak</flux:button>
            <flux:error name="trackInvoice" />
        </flux:card>
    </section>

    {{-- About / Company Profile --}}
    <section>
        <flux:card class="space-y-4">
            <flux:heading size="xl">Tentang CV. Saren Grup</flux:heading>
            <flux:text>
                Bermula tahun 2009 sebagai warung internet <strong>Saren Komputer</strong> di Sibang Kaja, Badung, Bali, hingga bertransformasi menjadi badan usaha berbadan hukum <strong>CV. Saren Grup</strong> pada 2015, berfokus pada industri digital printing & percetakan modern.
            </flux:text>
            <flux:text>
                Kami didukung lebih dari 3 armada mesin cetak digital modern dan 12+ tenaga kerja terampil, serta telah bermitra aktif dengan 10+ entitas korporat, perhotelan, instansi swasta, dan dinas pemerintahan di Bali.
            </flux:text>
        </flux:card>
    </section>

    {{-- Kontak --}}
    <section>
        <flux:card class="space-y-3">
            <flux:heading size="xl">Hubungi Kami</flux:heading>
            <flux:text><strong>Workshop:</strong> Jalan Raya Rijasa No. 6 Sibang Kaja, Abiansemal, Badung, Bali</flux:text>
            <flux:text><strong>WhatsApp:</strong> <a href="{{ $waLink }}" class="text-indigo-600 hover:underline" target="_blank">+62 878-6004-2888</a></flux:text>
            <flux:text><strong>Email:</strong> sarrengrup@gmail.com</flux:text>
            <flux:text><strong>Instagram:</strong> @cvsaren_grup</flux:text>
        </flux:card>
    </section>
</div>
