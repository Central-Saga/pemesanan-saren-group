<div class="grid grid-cols-1 gap-8 lg:grid-cols-12">

    {{-- Left : Showcase + Specs --}}
    <section class="flex flex-col gap-6 md:col-span-7">
        {{-- Product Hero --}}
        <div class="relative w-full overflow-hidden rounded-lg border border-zinc-200 bg-zinc-100">
            <div class="aspect-video w-full">
                @if($product->getFirstMediaUrl('images'))
                    <img src="{{ $product->getFirstMediaUrl('images') }}" alt="{{ $product->name }}"
                         class="absolute inset-0 h-full w-full object-cover" />
                @else
                    <div class="flex h-full w-full items-center justify-center">
                        <flux:icon.printer class="h-14 w-14 text-zinc-300" />
                    </div>
                @endif
                <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                <div class="absolute bottom-4 left-4 text-white">
                    <h1 class="text-2xl font-bold sm:text-3xl">{{ $product->name }}</h1>
                    <p class="text-sm opacity-90">{{ \Illuminate\Support\Str::limit($product->description, 80) }}</p>
                </div>
            </div>
        </div>

        {{-- File Guidelines --}}
        <div class="rounded-lg border border-zinc-200 bg-white p-6">
            <div class="mb-3 flex items-center gap-2 text-zinc-500">
                <flux:icon.paper-airplane class="h-5 w-5" />
                <h3 class="font-bold">Spesifikasi File</h3>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div class="rounded border border-zinc-200 bg-zinc-50 p-3">
                    <span class="mb-1 block text-[10px] font-medium uppercase tracking-wider text-zinc-400">Color Mode</span>
                    <span class="font-bold text-zinc-900">CMYK</span>
                </div>
                <div class="rounded border border-zinc-200 bg-zinc-50 p-3">
                    <span class="mb-1 block text-[10px] font-medium uppercase tracking-wider text-zinc-400">Resolusi</span>
                    <span class="font-bold text-zinc-900">150 DPI</span>
                </div>
                <div class="col-span-2 rounded border border-zinc-200 bg-zinc-50 p-3">
                    <span class="mb-1 block text-[10px] font-medium uppercase tracking-wider text-zinc-400">Format</span>
                    <div class="flex flex-wrap gap-2">
                        @foreach(['.PDF', '.TIFF', '.CDR', '.PSD', '.AI', '.ZIP'] as $ext)
                            <span class="rounded bg-zinc-200 px-2 py-0.5 font-mono text-xs font-medium text-zinc-700">{{ $ext }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Right : Calculator card --}}
    <aside class="md:col-span-5">
        <div class="sticky top-24 rounded-lg border border-zinc-200 bg-white shadow-sm">
            <div class="flex items-start justify-between border-b border-zinc-200 p-6 pb-4">
                <div>
                    <h2 class="text-lg font-bold text-zinc-900">Kalkulator Pesanan</h2>
                    <p class="text-xs text-zinc-500">Hitung harga m² real-time</p>
                </div>
                <span class="inline-flex items-center gap-1 rounded-full border border-orange-200 bg-[#FFF7ED] px-3 py-1 font-mono text-xs font-bold text-[#E65100]">
                    <flux:icon.bolt class="h-3 w-3" /> LIVE
                </span>
            </div>

            <div class="space-y-5 p-6">
                {{-- Dimensi --}}
                <div class="space-y-2">
                    <label class="text-sm font-bold text-zinc-900">Dimensi (cm)</label>
                    <div class="flex items-center gap-3">
                        <div class="relative flex-1">
                            <input type="number" min="1" wire:model.live.debounce.250ms="widthCm"
                                   class="w-full rounded-sm border border-zinc-200 bg-zinc-50 p-3 pr-8 font-mono text-sm text-zinc-900 outline-none transition focus:border-[#FF6B00] focus:ring-1 focus:ring-[#FF6B00]/20" />
                            <span class="absolute right-3 top-1/2 -translate-y-1/2 font-mono text-xs text-zinc-400">W</span>
                        </div>
                        <span class="text-sm text-zinc-400">×</span>
                        <div class="relative flex-1">
                            <input type="number" min="1" wire:model.live.debounce.250ms="heightCm"
                                   class="w-full rounded-sm border border-zinc-200 bg-zinc-50 p-3 pr-8 font-mono text-sm text-zinc-900 outline-none transition focus:border-[#FF6B00] focus:ring-1 focus:ring-[#FF6B00]/20" />
                            <span class="absolute right-3 top-1/2 -translate-y-1/2 font-mono text-xs text-zinc-400">H</span>
                        </div>
                    </div>
                    <div class="mt-1 inline-flex items-center gap-2 self-start rounded border border-zinc-200 bg-zinc-50 px-2 py-1 font-mono text-xs text-zinc-500">
                        <flux:icon.viewfinder-circle class="h-3.5 w-3.5" />
                        <span>Luas: <strong class="text-zinc-900">{{ $this->pricing['billable_area_m2'] }}</strong> m²</span>
                    </div>
                </div>

                {{-- Material radio cards --}}
                @if($product->variants->isNotEmpty())
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-zinc-900">Bahan</label>
                        <div class="grid grid-cols-2 gap-3">
                            @foreach($product->variants as $variant)
                                <label class="cursor-pointer">
                                    <input type="radio" name="material" value="{{ $variant->name }}" wire:model.live="selectedVariant" class="peer sr-only" />
                                    <div class="rounded-sm border p-3 transition-all
                                        {{ $variant->name === $selectedVariant
                                            ? 'border-[#FF6B00] bg-[#FFF7ED]'
                                            : 'border-zinc-200 hover:border-zinc-300' }}">
                                        <span class="block text-sm font-semibold text-zinc-900">{{ $variant->name }}</span>
                                        <span class="mt-0.5 block font-mono text-xs text-zinc-500">Rp {{ number_format($product->base_price + $variant->price_diff, 0, ',', '.') }}/m²</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Quantity --}}
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-zinc-900">Jumlah</label>
                    <div class="flex w-32 items-center rounded-sm border border-zinc-200 bg-zinc-50">
                        <button type="button" class="px-2 py-1.5 text-zinc-500 transition hover:text-zinc-900" wire:click="$set('quantity', max(1, $quantity - 1))">−</button>
                        <input type="number" min="1" wire:model.live="quantity" class="w-full border-none bg-transparent text-center font-mono text-sm text-zinc-900 focus:outline-none" />
                        <button type="button" wire:click="$set('quantity', $quantity + 1)" class="px-2 py-1 text-zinc-500 transition hover:text-zinc-900">+</button>
                    </div>
                </div>

                {{-- Artwork --}}
                @if($product->requires_design_file)
                    <div class="space-y-2 border-t border-zinc-100 pt-5">
                        <label class="block text-sm font-semibold text-zinc-900">Artwork Upload</label>
                        <label class="flex cursor-pointer flex-col items-center justify-center rounded-lg border-2 border-dashed border-zinc-200 bg-zinc-50 p-6 text-center transition hover:border-[#FF6B00] hover:bg-[#FFFBF7]">
                            <flux:icon.cloud-arrow-up class="mb-2 h-8 w-8 text-zinc-400" />
                            <span class="text-sm font-semibold text-zinc-900">Drag & drop file desain</span>
                            <span class="mt-1 text-xs text-zinc-500">atau klik untuk pilih (.PDF, .TIFF maks 50MB)</span>
                            <input type="file" wire:model="artworkFile" class="hidden" accept=".pdf,.tiff,.tif,.cdr,.psd,.ai,.zip,.rar,.jpg,.jpeg,.png" />
                        </label>
                        <flux:error name="artworkFile" class="text-xs text-red-600" />
                    </div>
                @endif
            </div>

            {{-- Finishing --}}
            <div class="border-t border-zinc-100 px-6 py-4">
                <flux:field label="Opsi Finishing">
                    <flux:select wire:model.live="finishing">
                        <option value="Mata Ayam 4 Sudut">Mata Ayam 4 Sudut</option>
                        <option value="Selongsong">Selongsong</option>
                        <option value="Lipat Pres">Lipat Pres</option>
                        <option value="Polos">Polos</option>
                    </flux:select>
                </flux:field>
            </div>

            {{-- Price Footer --}}
            <div class="rounded-b-lg border-t border-zinc-200 bg-zinc-50 px-6 py-4">
                <div class="flex items-end justify-between">
                    <div>
                        <span class="block font-mono text-[10px] uppercase tracking-wider text-zinc-400">Area × Harga × Qty</span>
                        <span class="text-sm font-bold text-zinc-900">Total Estimasi</span>
                    </div>
                    <span class="font-mono text-2xl font-bold text-[#FF6B00]">
                        Rp {{ number_format($this->pricing['subtotal'], 0, ',', '.') }}
                    </span>
                </div>
                <button wire:click="addToCart"
                        class="mt-4 flex w-full items-center justify-center gap-2 rounded-md bg-[#FF6B00] py-3 text-sm font-bold text-white transition hover:bg-[#E65100]">
                    <flux:icon.shopping-cart class="h-4 w-4" />
                    Tambah ke Keranjang
                </button>
                <p class="mt-2 text-center text-[10px] text-zinc-400">Harga mengikat setelah verifikasi file.</p>
            </div>
        </div>
    </aside>
</div>