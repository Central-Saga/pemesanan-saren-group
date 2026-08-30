@php
    $waLink = 'https://wa.me/6287860042888?text=' . urlencode('Halo Admin Percetakan CV. Saren Grup! Saya mau konfirmasi pesanan ' . $order->invoice_number . ' a/n ' . $order->customer_name . '. Matur Suksma!');
@endphp

<div class="mx-auto max-w-2xl">
    <div class="rounded-xl border border-zinc-200 bg-white p-8 text-center sm:p-10">
        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-emerald-50">
            <flux:icon.check-circle class="h-9 w-9 text-emerald-500" />
        </div>

        <h1 class="mt-5 text-2xl font-bold text-zinc-900 sm:text-[28px]">Pesanan Diterima!</h1>
        <p class="mt-2 text-sm leading-relaxed text-zinc-500">
            Terima kasih, <strong class="text-zinc-700">{{ $order->customer_name }}</strong>.
            Pesanan Anda sudah tersimpan di sistem kami.
        </p>

        <div class="mx-auto mt-6 max-w-xs rounded-md border border-zinc-200 bg-zinc-50 p-4">
            <span class="block text-[10px] font-semibold uppercase tracking-widest text-zinc-400">Nomor Invoice</span>
            <span class="mt-1 block font-mono text-lg font-bold text-zinc-900">{{ $order->invoice_number }}</span>
            <span class="mt-1 block text-xs text-zinc-500">{{ $order->status->getLabel() }}</span>
        </div>

        <div class="mx-auto mt-6 max-w-md rounded-lg border border-zinc-200 bg-zinc-50 p-4 text-left">
            <div class="mb-3 text-xs font-bold uppercase tracking-wider text-zinc-400">Rincian</div>
            <ul class="space-y-2">
                @foreach($order->items as $item)
                    <li class="flex items-start justify-between gap-3 text-sm">
                        <div class="min-w-0">
                            <span class="font-medium text-zinc-800">{{ $item->product->name }}</span>
                            @if($item->variant_name)
                                <span class="text-zinc-400">· {{ $item->variant_name }}</span>
                            @endif
                            @if($item->width_cm)
                                <span class="ml-1 font-mono text-xs text-zinc-400">{{ $item->width_cm }}×{{ $item->height_cm }}cm</span>
                            @endif
                            <span class="block font-mono text-[11px] text-zinc-400">x{{ $item->quantity }}</span>
                        </div>
                        <span class="whitespace-nowrap font-mono text-sm font-medium text-zinc-800">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                    </li>
                @endforeach
            </ul>
            <div class="mt-3 flex items-center justify-between border-t border-zinc-100 pt-3">
                <span class="text-sm font-bold text-zinc-900">Total</span>
                <span class="font-mono text-lg font-bold text-zinc-900">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="mt-6 flex flex-col justify-center gap-3 sm:flex-row">
            <a href="{{ $waLink }}" target="_blank" rel="noopener"
               class="inline-flex items-center justify-center gap-2 rounded-md bg-[#16A34A] px-5 py-2.5 text-sm font-bold text-white shadow-[0_4px_10px_rgba(22,163,74,0.25)] transition hover:bg-[#15803D]">
                <flux:icon.chat-bubble-oval-left-ellipsis class="h-4 w-4" />
                Konfirmasi via WhatsApp
            </a>
            <a href="{{ route('order.track', ['invoice' => $order->invoice_number]) }}"
               class="inline-flex items-center justify-center gap-2 rounded-md border border-zinc-200 px-5 py-2.5 text-sm font-medium text-zinc-600 transition hover:bg-zinc-50">
                <flux:icon.magnifying-glass class="h-4 w-4" />
                Lacak Pesanan
            </a>
        </div>
        <p class="mt-3 text-xs text-zinc-400">Simpan nomor invoice untuk melacak status produksi kapan saja.</p>
    </div>
</div>