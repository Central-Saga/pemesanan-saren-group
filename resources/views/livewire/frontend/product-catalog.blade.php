<div class="space-y-6">
    <div>
        <flux:heading size="xl">Katalog Produk</flux:heading>
        <flux:text>Pesan cetak custom dan produk ATK dari CV. Saren Grup.</flux:text>
    </div>

    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <flux:radio.group wire:model.live="category" variant="segmented">
            <flux:radio value="">Semua</flux:radio>
            <flux:radio value="CUSTOM_SERVICE">Jasa Cetak Custom</flux:radio>
            <flux:radio value="PHYSICAL_PRODUCT">Produk Fisik</flux:radio>
        </flux:radio.group>

        <flux:input wire:model.live.debounce.300ms="search" placeholder="Cari produk..." icon="magnifying-glass" class="sm:w-64" />
    </div>

    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
        @forelse($this->products as $product)
            <flux:card class="flex flex-col">
                <div class="mb-3 flex items-center justify-between">
                    <flux:badge color="{{ $product->category === \App\Enums\ProductCategory::CUSTOM_SERVICE ? 'indigo' : 'zinc' }}">
                        {{ $product->category->getLabel() }}
                    </flux:badge>
                    <flux:text class="text-xs">{{ $product->unit_label }}</flux:text>
                </div>
                <flux:heading size="lg">{{ $product->name }}</flux:heading>
                <flux:text class="mt-1 line-clamp-2">{{ $product->description }}</flux:text>
                <div class="mt-4 flex items-end justify-between">
                    <div>
                        <flux:text class="text-xs text-zinc-500">Mulai dari</flux:text>
                        <flux:heading size="lg" class="font-bold text-indigo-600">{{ $product->base_price_formatted }}</flux:heading>
                    </div>
                    <flux:button variant="primary" :href="route('product.detail', $product->slug)" wire:navigate>
                        Pesan
                    </flux:button>
                </div>
            </flux:card>
        @empty
            <div class="col-span-full py-16 text-center">
                <flux:heading>Produk tidak ditemukan</flux:heading>
                <flux:text>Ubah kata kunci atau kategori pencarian.</flux:text>
            </div>
        @endforelse
    </div>
</div>
