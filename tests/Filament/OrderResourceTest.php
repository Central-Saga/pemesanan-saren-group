<?php

use App\Filament\Resources\Orders\Pages\ListOrders;
use App\Filament\Resources\Orders\Pages\ViewOrder;
use App\Models\Order;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function () {
    $this->actingAs(User::factory()->create());
});

it('lists orders as an admin', function () {
    $order = Order::factory()->create([
        'invoice_number' => 'SRN-20260830-0101',
        'customer_phone' => '081234567890',
    ]);

    Livewire::test(ListOrders::class)
        ->assertCanSeeTableRecords([$order]);
});

it('renders the order view page with infolist', function () {
    $order = Order::factory()->create([
        'invoice_number' => 'SRN-20260830-0102',
        'customer_name' => 'Dewa',
    ]);

    Livewire::test(ViewOrder::class, [
        'record' => $order->getKey(),
    ])->assertOk();
});
