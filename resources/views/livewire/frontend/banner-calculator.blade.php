<div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:gap-8">

    {{-- LEFT : Showcase + Specs --}}
    <section class="flex flex-1 flex-col gap-5">
        {{-- Product Hero --}}
        <div class="relative aspect-video w-full overflow-hidden rounded-xl border border-zinc-200 bg-zinc-100">
            @if($product->getFirstMediaUrl('images'))
                <img src="{{ $product->getFirstMediaUrl('images') }}" alt="{{ $product->name }}"
                     class="absolute inset-0 h-full w-full object-cover" />
            @else
                <div class="flex h-full w-full items-center justify-center">
                    <flux:icon.printer class="h-14 w-14 text-zinc-300" />
                </div>
            @endif
            <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black/50 via-black/10 to-transparent"></div>
            <div class="absolute bottom-5 left-5 right-5 text-white">
                <h1 class="text-2xl font-bold leading-snug sm:text-3xl">{{ $product->name }}</h1>
                <p class="mt-1 text-sm opacity-90">{{ \Illuminate\Support\Str::limit($product->description, 90) }}</p>
            </div>
        </div>

        {{-- File Guidelines --}}
        <div class="rounded-xl border border-zinc-200 bg-white p-6">
            <div class="mb-4 flex items-center gap-2.5">
                <span class="flex h-8 w-8 items-center justify-center rounded-md bg-[#FFF7ED] text-[#E65100]">
                    <flux:icon.paper-airplane class="h-4 w-4" />
                </span>
                <h3 class="text-base font-bold text-zinc-900">Spesifikasi File</h3>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div class="rounded-md border border-zinc-200 bg-zinc-50 p-4">
                    <span class="mb-1 block text-[10px] font-semibold uppercase tracking-widest text-zinc-400">Color Mode</span>
                    <span class="text-sm font-bold text-zinc-900">CMYK</span>
                </div>
                <div class="rounded-md border border-zinc-200 bg-zinc-50 p-4">
                    <span class="mb-1 block text-[10px] font-medium uppercase tracking-wider text-zinc-400">Resolusi</span>
                    <span class="text-sm font-bold text-zinc-900">150 DPI</span>
                </div>
                <div class="col-span-2 rounded-md border border-zinc-200 bg-zinc-50 p-4">
                    <span class="mb-2 block text-[10px] font-medium uppercase tracking-wider text-zinc-400">Format Diterima</span>
                    <div class="flex flex-wrap gap-1.5">
                        @foreach(['PDF', 'TIFF', 'CDR', 'PSD', 'AI', 'ZIP'] as $ext)
                            <span class="rounded-sm bg-zinc-200/70 px-2 py-1 font-mono text-xs font-medium text-zinc-700">{{ $ext }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Right : Calculator --}}
    <aside class="lg:w-[420px] lg:shrink-0">
        <div class="lg:sticky lg:top-24 overflow-hidden rounded-xl border border-zinc-200 bg-white shadow-[0_2px_12px_-2px_rgba(26,27,30,0.08)]">

            {{-- Header --}}
            <div class="flex items-center justify-between border-b border-zinc-100 px-6 py-5">
                <div>
                    <h2 class="text-base font-bold text-zinc-900">Kalkulator Pesanan</h2>
                    <p class="mt-0.5 text-xs text-zinc-400">Hitung harga m² real-time</p>
                </div>
                <span class="inline-flex items-center gap-1.5 rounded-full bg-[#FFF7ED] px-2.5 py-1 text-[11px] font-bold tracking-wide text-[#E65100]">
                    <flux:icon.bolt class="h-3 w-3" /> LIVE
                </span>
            </div>

            {{-- Body --}}
            <div class="space-y-6 px-6 py-5">
                {{-- Dimensi --}}
                <div>
                    <div class="mb-2 flex items-baseline justify-between">
                        <label class="text-sm font-bold text-zinc-900">Dimensi (cm)</label>
                        <span class="inline-flex items-center gap-1.5 rounded-sm bg-zinc-100 px-2 py-0.5 font-mono text-[11px] text-zinc-600">
                            <flux:icon.viewfinder-circle class="h-3 w-3 text-zinc-400" />
                            <span>{{ $this->pricing['billable_area_m2'] }} <span class="font-normal text-zinc-400">m²</span></span>
                            <span class="text-zinc-300">•</span>
                            <span class="font-medium text-zinc-500">min {{ $product->min_size_m2 }} m²</span>
                        </span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="relative flex-1">
                            <input type="number" min="1" wire:model.live.debounce.250ms="widthCm"
                                   class="w-full rounded-md border border-zinc-200 bg-zinc-50 py-2.5 pl-4 pr-10 font-mono text-sm font-medium text-zinc-900 outline-none transition placeholder:text-zinc-300 focus:border-[#FF6B00] focus:bg-white focus:ring-2 focus:ring-[#FF6B00]/15" />
                            <span class="pointer-events-none absolute right-3.5 top-1/2 -translate-y-1/2 font-mono text-[10px] font-medium text-zinc-300">W</span>
                        </div>
                        <span class="shrink-0 font-mono text-xs text-zinc-300">×</span>
                        <div class="relative flex-1">
                            <input type="number" min="1" wire:model.live.debounce.250ms="heightCm"
                                   class="w-full rounded-md border border-zinc-200 bg-zinc-50 py-2.5 pl-4 pr-10 font-mono text-sm font-medium text-zinc-900 outline-none transition placeholder:text-zinc-300 focus:border-[#FF6B00] focus:bg-white focus:ring-2 focus:ring-[#FF6B00]/15" />
                            <span class="pointer-events-none absolute right-3.5 top-1/2 -translate-y-1/2 font-mono text-[10px] font-medium text-zinc-300">L</span>
                        </div>
                    </div>
                </div>

                {{-- Bahan --}}
                @if($product->variants->isNotEmpty())
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-zinc-900">Pilih Bahan</label>
                        <div class="grid grid-cols-2 gap-2.5">
                            @foreach($product->variants as $variant)
                                <label class="cursor-pointer">
                                    <input type="radio" name="material" value="{{ $variant->name }}" wire:model.live="selectedVariant" class="peer sr-only" />
                                    <div class="rounded-md border p-3 transition-all duration-150
                                        {{ $variant->name === $selectedVariant
                                            ? 'border-[#FF6B00] bg-[#FFF7ED] ring-1 ring-[#FF6B00]/30'
                                            : 'border-zinc-200 bg-white hover:border-zinc-300' }}">
                                        <span class="block text-[13px] font-bold leading-tight text-zinc-900">{{ $variant->name }}</span>
                                        <span class="mt-1 block font-mono text-[11px] text-zinc-500">Rp {{ number_format($product->base_price + $variant->price_diff, 0, ',', '.') }}/m²</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Jumlah + Finishing side by side --}}
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-zinc-900">Jumlah</label>
                        <div class="flex h-[42px] items-center rounded-md border border-zinc-200 bg-zinc-50">
                            <button type="button" class="flex h-full w-9 items-center justify-center text-zinc-400 transition hover:text-[#E65100]" wire:click="$set('quantity', max(1, $quantity - 1))">&minus;</button>
                            <input type="number" min="1" wire:model.live="quantity" class="h-full w-full border-none bg-transparent text-center font-mono text-sm font-medium text-zinc-900 focus:outline-none" />
                            <button type="button" class="flex h-full w-9 items-center justify-center text-zinc-400 transition hover:text-[#E65100]" wire:click="$set('quantity', $quantity + 1)">+</button>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-zinc-900">Finishing</label>
                        <select wire:model.live="finishing"
                                class="h-[42px] w-full rounded-md border border-zinc-200 bg-zinc-50 px-3 text-sm font-medium text-zinc-900 outline-none transition focus:border-[#FF6B00] focus:bg-white focus:ring-2 focus:ring-[#FF6B00]/15">
                            <option value="Mata Ayam 4 Sudut">Mata Ayam</option>
                            <option value="Selongsong">Selongsong</option>
                            <option value="Lipat Pres">Lipat Pres</option>
                            <option value="Polos">Polos</option>
                        </select>
                    </div>
                </div>

                {{-- Artwork --}}
                @if($product->requires_design_file)
                    <div class="space-y-2 border-t border-zinc-100 pt-5">
                        <label class="text-sm font-bold text-zinc-900">File Desain</label>
                        <label class="flex cursor-pointer flex-col items-center justify-center rounded-md border-2 border-dashed border-zinc-200 bg-zinc-50 px-4 py-6 text-center transition hover:border-[#FF6B00] hover:bg-[#FFF7ED]/40">
                            <flux:icon.cloud-arrow-up class="mb-1.5 h-7 w-7 text-zinc-300" />
                            <span class="text-xs font-semibold text-zinc-700">Tarik & lepas file di sini</span>
                            <span class="mt-0.5 text-[11px] text-zinc-400">PDF, TIFF, CDR — maks 50 MB</span>
                            <input type="file" wire:model="artworkFile" class="hidden" accept=".pdf,.tiff,.tif,.cdr,.psd,.ai,.zip,.rar,.jpg,.jpeg,.png" />
                        </label>
                        <flux:error name="artworkFile" class="text-xs text-red-600" />
                    </div>
                @endif
            </div>

            {{-- Price Footer --}}
            <div class="rounded-b-xl border-t border-zinc-100 bg-[#FFF7ED]/60 px-6 py-4">
                <div class="flex items-end justify-between">
                    <span class="text-[13px] font-medium text-zinc-500">Total Estimasi</span>
                    <span class="font-mono text-xl font-bold tracking-tight text-[#FF6B00]">
                        Rp {{ number_format($this->pricing['subtotal'], 0, ',', '.') }}
                    </span>
                </div>
                <button wire:click="addToCart"
                        class="mt-3.5 flex w-full items-center justify-center gap-2 rounded-md bg-[#16A34A] py-3 text-sm font-bold text-white shadow-sm transition hover:bg-[#15803D]">
                    <flux:icon.shopping-cart class="h-4 w-4" />
                    Tambah ke Keranjang
                </button>
                <p class="mt-2 text-center text-[10px] text-zinc-400">Harga mengikat setelah verifikasi file &amp; konfirmasi admin.</p>
            </div>
        </div>
    </aside>
</div>