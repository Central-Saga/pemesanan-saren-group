<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-zinc-200 pb-4">
        <div>
            <h1 class="text-2xl font-bold text-zinc-900 font-heading">Pesanan Saya</h1>
            <p class="text-sm text-zinc-500 mt-1">Daftar semua riwayat transaksi dan progres produksi pesanan Anda.</p>
        </div>
        <flux:button href="{{ route('catalog') }}" variant="primary" size="sm" icon="shopping-cart" wire:navigate class="bg-[#FF6B00] hover:bg-[#E65100] text-white">
            Buat Pesanan Baru
        </flux:button>
    </div>

    @if($this->orders->isEmpty())
        <div class="text-center py-16 bg-zinc-50 rounded-xl border border-dashed border-zinc-300">
            <div class="mx-auto w-12 h-12 rounded-full bg-zinc-100 flex items-center justify-center text-zinc-400 mb-3">
                <flux:icon.clipboard-document-list class="size-6" />
            </div>
            <h3 class="text-base font-semibold text-zinc-800">Belum ada pesanan</h3>
            <p class="text-sm text-zinc-500 mt-1 max-w-sm mx-auto">Anda belum memiliki riwayat transaksi. Pilih produk dari katalog kami untuk memulai pemesanan.</p>
            <div class="mt-6">
                <flux:button href="{{ route('catalog') }}" variant="primary" size="sm" wire:navigate class="bg-[#FF6B00] hover:bg-[#E65100] text-white">
                    Lihat Katalog Produk
                </flux:button>
            </div>
        </div>
    @else
        <div class="space-y-4">
            @foreach($this->orders as $order)
                <div class="bg-white rounded-xl border border-zinc-200 shadow-sm p-4 sm:p-5 hover:border-zinc-300 transition">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-zinc-100">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="font-mono font-bold text-sm text-zinc-900">{{ $order->invoice_number }}</span>
                            <span class="text-xs text-zinc-400">•</span>
                            <span class="text-xs text-zinc-500">{{ $order->created_at->translatedFormat('d M Y, H:i') }} WITA</span>
                        </div>
                        <div>
                            @php
                                $badgeClasses = match($order->status->getColor()) {
                                    'warning' => 'bg-amber-50 text-amber-700 border-amber-200',
                                    'info' => 'bg-sky-50 text-sky-700 border-sky-200',
                                    'primary' => 'bg-blue-50 text-blue-700 border-blue-200',
                                    'success' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                    'danger' => 'bg-rose-50 text-rose-700 border-rose-200',
                                    default => 'bg-zinc-100 text-zinc-700 border-zinc-200',
                                };
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $badgeClasses }}">
                                {{ $order->status_label }}
                            </span>
                        </div>
                    </div>

                    <div class="py-3 space-y-2">
                        @foreach($order->items as $item)
                            <div class="flex items-start justify-between text-sm">
                                <div>
                                    <span class="font-medium text-zinc-800">{{ $item->product?->name ?? 'Produk' }}</span>
                                    @if($item->variant_name)
                                        <span class="text-zinc-500 text-xs">({{ $item->variant_name }})</span>
                                    @endif
                                    <div class="text-xs text-zinc-500">
                                        {{ $item->quantity }} pcs
                                        @if($item->width_cm && $item->height_cm)
                                            • {{ $item->width_cm }} x {{ $item->height_cm }} cm ({{ $item->calculated_area }} m²)
                                        @endif
                                    </div>
                                </div>
                                <span class="font-mono text-zinc-700 text-xs sm:text-sm">{{ $item->subtotal_formatted }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pt-3 border-t border-zinc-100 bg-zinc-50/50 -mx-4 -mb-4 sm:-mx-5 sm:-mb-5 p-4 sm:p-5 rounded-b-xl">
                        <div class="flex items-center gap-2">
                            <span class="text-xs text-zinc-500">Total Pembayaran:</span>
                            <span class="font-mono font-bold text-base text-zinc-900">{{ $order->total_amount_formatted }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <flux:button href="{{ route('order.track', $order->invoice_number) }}" variant="outline" size="sm" icon="magnifying-glass" wire:navigate>
                                Lacak Pesanan
                            </flux:button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
