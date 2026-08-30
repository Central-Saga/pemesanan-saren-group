<div>
    <flux:dropdown position="bottom" align="end">
        <flux:button variant="ghost" icon="shopping-cart">
            Keranjang
            @if($this->cartCount > 0)
                <flux:badge color="orange" inset="top right">{{ $this->cartCount }}</flux:badge>
            @endif
        </flux:button>

        <flux:menu class="w-96 max-w-[calc(100vw-2rem)]">
            <div class="flex items-center justify-between border-b border-zinc-100 px-4 py-3">
                <span class="text-sm font-bold text-zinc-900">Keranjang</span>
                <span class="font-mono text-xs text-zinc-400">{{ $this->cartCount }} item</span>
            </div>

            <div class="max-h-80 overflow-y-auto">
                @forelse($this->cartItems as $i => $item)
                    <div class="flex items-start gap-3 border-b border-zinc-50 px-4 py-3">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center overflow-hidden rounded-md border border-zinc-200 bg-zinc-100">
                            @if($img = \App\Models\Product::find($item['product_id'])?->getFirstMediaUrl('images', 'thumb'))
                                <img src="{{ $img }}" alt="" class="h-full w-full object-cover" loading="lazy" />
                            @else
                                <flux:icon.document-text class="h-4 w-4 text-zinc-300" />
                            @endif
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="truncate text-sm font-semibold text-zinc-900">{{ $item['product_name'] }}</div>
                            <div class="mt-0.5 text-xs text-zinc-500">
                                @if(($item['variant_name'] ?? null)){{ $item['variant_name'] }} · @endif
                                <span class="font-mono">x{{ $item['quantity'] }}</span>
                            </div>
                            @if(($item['width_cm'] ?? null))
                                <div class="mt-0.5 font-mono text-[11px] text-zinc-400">{{ $item['width_cm'] }} × {{ $item['height_cm'] }} cm</div>
                            @endif
                        </div>
                        <div class="flex shrink-0 flex-col items-end gap-1">
                            <span class="whitespace-nowrap font-mono text-sm font-medium text-zinc-900">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</span>
                            <button type="button" wire:click="removeFromCart({{ $i }})"
                                    class="text-zinc-300 transition hover:text-red-500" aria-label="Hapus">
                                <flux:icon.x-mark class="h-3.5 w-3.5" />
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="flex flex-col items-center px-4 py-8 text-center">
                        <flux:icon.shopping-cart class="h-8 w-8 text-zinc-200" />
                        <p class="mt-2 text-sm font-medium text-zinc-500">Keranjang kosong</p>
                        <p class="text-xs text-zinc-400">Tambahkan produk dari katalog</p>
                    </div>
                @endforelse
            </div>

            @if($this->cartCount > 0)
                <div class="space-y-3 border-t border-zinc-100 bg-zinc-50/60 px-4 py-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-zinc-500">Total</span>
                        <span class="font-mono text-base font-bold text-zinc-900">Rp {{ number_format($this->cartTotal, 0, ',', '.') }}</span>
                    </div>
                    <a href="{{ route('checkout') }}" wire:navigate
                       class="flex w-full items-center justify-center gap-2 rounded-md bg-[#16A34A] px-4 py-2.5 text-sm font-bold text-white shadow-[0_4px_10px_rgba(22,163,74,0.25)] transition hover:bg-[#15803D]">
                        <flux:icon.chat-bubble-oval-left-ellipsis class="h-4 w-4" />
                        Checkout
                    </a>
                </div>
            @endif
        </flux:menu>
    </flux:dropdown>
</div>