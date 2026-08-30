<div class="text-zinc-900">

    @if(empty($this->cartItems))
        {{-- Empty cart --}}
        <div class="mx-auto max-w-md rounded-xl border border-zinc-200 bg-white p-12 text-center">
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-zinc-100">
                <flux:icon.shopping-cart class="h-7 w-7 text-zinc-300" />
            </div>
            <h1 class="mt-4 text-lg font-bold text-zinc-900">Keranjang masih kosong</h1>
            <p class="mt-1 text-sm text-zinc-500">Pilih produk dari katalog untuk mulai memesan.</p>
            <a href="{{ route('catalog') }}" wire:navigate
               class="mt-5 inline-flex items-center gap-2 rounded-md bg-[#FF6B00] px-5 py-2.5 text-sm font-bold text-white transition hover:bg-[#E65100]">
                Lihat Katalog
                <flux:icon.arrow-right class="h-4 w-4" />
            </a>
        </div>
    @else
        {{-- Header --}}
        <div class="mb-6">
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900 sm:text-[32px] sm:leading-[42px]">Checkout</h1>
            <p class="mt-1 text-sm text-zinc-500">Lengkapi data untuk finalisasi pesanan.</p>
        </div>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-12 md:gap-8">

            {{-- LEFT : Form --}}
            <div class="flex flex-col gap-5 md:col-span-7">

                {{-- Data Pemesan --}}
                <section class="rounded-lg border border-zinc-200 bg-white p-6">
                    <h2 class="mb-4 text-base font-bold text-zinc-900">Data Pemesan</h2>
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="mb-1.5 block text-xs font-medium text-zinc-500" for="customerName">Nama Lengkap</label>
                            <input id="customerName" type="text" wire:model="customerName" placeholder="Nama sesuai KTP / WA"
                                   class="w-full rounded-md border border-zinc-200 bg-zinc-50 px-4 py-2.5 text-sm text-zinc-900 placeholder-zinc-300 outline-none transition focus:border-[#FF6B00] focus:bg-white focus:ring-2 focus:ring-[#FF6B00]/15" />
                            <flux:error name="customerName" class="mt-1 text-xs text-red-500" />
                        </div>
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <label class="mb-1.5 block text-xs font-medium text-zinc-500" for="customerPhone">No. WhatsApp</label>
                                <div class="flex">
                                    <span class="inline-flex items-center rounded-l-md border border-r-0 border-zinc-200 bg-zinc-100 px-3 font-mono text-sm text-zinc-400">+62</span>
                                    <input id="customerPhone" type="tel" wire:model="customerPhone" placeholder="8123456789 0"
                                           class="w-full flex-1 rounded-r-md border border-zinc-200 bg-zinc-50 px-3 py-2.5 font-mono text-sm text-zinc-900 placeholder-zinc-300 outline-none transition focus:border-[#FF6B00] focus:bg-white focus:ring-2 focus:ring-[#FF6B00]/15" />
                                </div>
                                <flux:error name="customerPhone" class="mt-1 text-xs text-red-500" />
                            </div>
                            <div>
                                <label class="mb-1.5 block text-xs font-medium text-zinc-500" for="customerEmail">Email <span class="text-zinc-300">(opsional)</span></label>
                                <input id="customerEmail" type="email" wire:model="customerEmail" placeholder="nama@email.com"
                                       class="w-full rounded-md border border-zinc-200 bg-zinc-50 px-3 py-2.5 text-sm text-zinc-900 placeholder-zinc-300 outline-none transition focus:border-[#FF6B00] focus:bg-white focus:ring-2 focus:ring-[#FF6B00]/15" />
                                <flux:error name="customerEmail" class="mt-1 text-xs text-red-500" />
                            </div>
                        </div>
                    </div>
                </section>

                {{-- Metode Pengiriman --}}
                <section class="rounded-lg border border-zinc-200 bg-white p-6">
                    <h2 class="mb-4 text-base font-bold text-zinc-900">Metode Pengambilan</h2>
                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                        <label class="cursor-pointer">
                            <input type="radio" value="PICKUP" wire:model.live="deliveryMethod" class="peer sr-only" />
                            <div class="flex h-full flex-col gap-1 rounded-md border bg-zinc-50 p-4 transition-all
                                peer-checked:border-[#FF6B00] peer-checked:bg-[#FFF7ED] peer-checked:ring-2 peer-checked:ring-[#FF6B00]/25">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-bold text-zinc-900">Ambil di Workshop</span>
                                    <flux:icon.building-storefront class="h-4 w-4 {{ $deliveryMethod === 'PICKUP' ? 'text-[#E65100]' : 'text-zinc-400' }}" />
                                </div>
                                <p class="text-xs text-zinc-500">Sibang Kaja, Bali</p>
                                <span class="mt-auto pt-1 font-mono text-xs font-medium text-emerald-600">Gratis</span>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" value="COURIER" wire:model.live="deliveryMethod" class="peer sr-only" />
                            <div class="flex h-full flex-col gap-1 rounded-md border bg-zinc-50 p-4 transition-all
                                peer-checked:border-[#FF6B00] peer-checked:bg-[#FFF7ED] peer-checked:ring-2 peer-checked:ring-[#FF6B00]/25">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-bold text-zinc-900">Kirim via Kurir</span>
                                    <flux:icon.truck class="h-4 w-4 {{ $deliveryMethod === 'COURIER' ? 'text-[#E65100]' : 'text-zinc-400' }}" />
                                </div>
                                <p class="text-xs text-zinc-500">Area Bali &amp; sekitarnya</p>
                                <span class="mt-auto pt-1 font-mono text-xs text-zinc-400">Ongkir via WA</span>
                            </div>
                        </label>
                    </div>

                    @if($deliveryMethod === 'COURIER')
                        <div class="mt-4">
                            <label class="mb-1.5 block text-xs font-medium text-zinc-500" for="deliveryAddress">Alamat Pengiriman</label>
                            <textarea id="deliveryAddress" wire:model="deliveryAddress" rows="3" placeholder="Nama jalan, no. rumah, kecamatan, kabupaten"
                                      class="w-full rounded-md border border-zinc-200 bg-zinc-50 px-4 py-3 text-sm text-zinc-900 placeholder-zinc-300 outline-none transition focus:border-[#FF6B00] focus:bg-white focus:ring-2 focus:ring-[#FF6B00]/15"></textarea>
                            <flux:error name="deliveryAddress" class="mt-1 text-xs text-red-500" />
                        </div>
                    @endif
                </section>

                {{-- Catatan --}}
                <section class="rounded-lg border border-zinc-200 bg-white p-6">
                    <label class="mb-1.5 block text-xs font-medium text-zinc-500" for="notes">Catatan <span class="text-zinc-300">(opsional)</span></label>
                    <textarea id="notes" wire:model="notes" rows="2" placeholder="Catatan tambahan untuk tim produksi..."
                              class="w-full rounded-md border border-zinc-200 bg-zinc-50 px-3 py-2.5 text-sm text-zinc-900 placeholder-zinc-300 outline-none transition focus:border-[#FF6B00] focus:bg-white focus:ring-2 focus:ring-[#FF6B00]/15"></textarea>
                    <flux:error name="notes" class="mt-1 text-xs text-red-500" />
                </section>
            </div>

            {{-- RIGHT : Summary --}}
            <div class="md:col-span-5">
                <div class="rounded-lg border border-zinc-200 bg-white p-6 md:sticky md:top-24">
                    <h2 class="mb-5 border-b border-zinc-100 pb-3 text-base font-bold text-zinc-900">Ringkasan Pesanan</h2>

                    {{-- Item list --}}
                    <div class="mb-5 flex flex-col gap-4">
                        @foreach($this->cartItems as $item)
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex min-w-0 gap-3">
                                    <div class="flex h-16 w-16 shrink-0 items-center justify-center overflow-hidden rounded-md border border-zinc-200 bg-zinc-100">
                                        @if($img = \App\Models\Product::find($item['product_id'])?->getFirstMediaUrl('images', 'thumb'))
                                            <img src="{{ $img }}" alt="" class="h-full w-full object-cover" loading="lazy" />
                                        @else
                                            <flux:icon.document-text class="h-5 w-5 text-zinc-300" />
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <h3 class="truncate text-sm font-bold text-zinc-900">{{ $item['product_name'] }}</h3>
                                        @if($item['variant_name'] ?? null)
                                            <p class="mt-0.5 text-xs text-zinc-500">{{ $item['variant_name'] }}</p>
                                        @endif
                                        @if(($item['width_cm'] ?? null))
                                            <div class="mt-0.5 flex items-center gap-1 text-zinc-400">
                                                <flux:icon.viewfinder-circle class="h-3 w-3" />
                                                <span class="font-mono text-xs">{{ $item['width_cm'] }} × {{ $item['height_cm'] }} cm</span>
                                            </div>
                                        @endif
                                        <p class="mt-0.5 font-mono text-xs text-zinc-500">Qty {{ $item['quantity'] }}</p>
                                    </div>
                                </div>
                                <span class="whitespace-nowrap font-mono text-sm font-medium text-zinc-900">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>

                    {{-- Totals --}}
                    <div class="mb-5 flex flex-col gap-2">
                        <div class="flex justify-between text-sm text-zinc-500">
                            <span>Subtotal</span>
                            <span class="font-mono">Rp {{ number_format($this->cartTotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm text-zinc-500">
                            <span>Ongkos Kirim</span>
                            <span class="font-mono">{{ $deliveryMethod === 'COURIER' ? 'via WhatsApp' : 'Gratis' }}</span>
                        </div>
                    </div>

                    <div class="mb-5 flex items-end justify-between border-t border-zinc-200 pt-3">
                        <span class="text-base font-bold text-zinc-900">Total</span>
                        <span class="font-mono text-[26px] font-bold text-zinc-900">
                            Rp {{ number_format($this->cartTotal, 0, ',', '.') }}
                        </span>
                    </div>

                    @if(session('error'))
                        <div class="mb-4 rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                            {{ session('error') }}
                        </div>
                    @endif

                    <button wire:click="submitOrder"
                            class="flex w-full items-center justify-center gap-2 rounded-md bg-[#16A34A] px-6 py-3.5 text-sm font-bold text-white shadow-[0_4px_10px_rgba(22,163,74,0.25)] transition hover:bg-[#15803D]">
                        <flux:icon.chat-bubble-oval-left-ellipsis class="h-4 w-4" />
                        Pesan Sekarang via WhatsApp
                    </button>
                    <p class="mt-2.5 text-center text-xs text-zinc-400">
                        Anda akan diarahkan ke WhatsApp untuk konfirmasi pesanan.
                    </p>
                </div>
            </div>
        </div>
    @endif
</div>