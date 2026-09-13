<?php

use App\Enums\OrderStatus;
use App\Livewire\Frontend\OrderTracker;
use App\Models\Order;
use Livewire\Livewire;

it('shows tracking number for shipped orders with resi', function () {
    $order = Order::factory()->create([
        'status' => OrderStatus::SHIPPED->value,
        'tracking_number' => 'JX-2026-0913-88',
    ]);

    Livewire::test(OrderTracker::class, ['invoice' => $order->invoice_number])
        ->assertSee('Nomor Resi')
        ->assertSee('JX-2026-0913-88');
});

it('hides tracking number block without resi', function () {
    $order = Order::factory()->create([
        'status' => OrderStatus::SHIPPED->value,
        'tracking_number' => null,
    ]);

    Livewire::test(OrderTracker::class, ['invoice' => $order->invoice_number])
        ->assertOk()
        ->assertDontSee('Nomor Resi');
});

it('hides tracking number block for non-shipped status', function () {
    $order = Order::factory()->create([
        'status' => OrderStatus::IN_PRODUCTION->value,
        'tracking_number' => 'JX-2026-0913-88',
    ]);

    Livewire::test(OrderTracker::class, ['invoice' => $order->invoice_number])
        ->assertOk()
        ->assertDontSee('Nomor Resi');
});
