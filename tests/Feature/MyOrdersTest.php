<?php

use App\Livewire\Frontend\MyOrders;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Livewire\Livewire;

it('redirects guest to login when visiting pesanan page', function () {
    $this->get(route('orders.my'))
        ->assertRedirect(route('login'));
});

it('displays orders belonging to the authenticated user only', function () {
    $userA = User::factory()->create(['name' => 'User A', 'email' => 'user_a@example.com']);
    $userB = User::factory()->create(['name' => 'User B', 'email' => 'user_b@example.com']);

    $product = Product::factory()->create(['name' => 'Spanduk Outdoor']);

    $orderA = Order::create([
        'user_id' => $userA->id,
        'invoice_number' => 'SRN-20260903-0001',
        'customer_name' => 'User A',
        'customer_phone' => '081234567890',
        'customer_email' => 'user_a@example.com',
        'delivery_method' => 'PICKUP',
        'total_amount' => 50000,
        'status' => 'PENDING_PAYMENT',
    ]);

    OrderItem::create([
        'order_id' => $orderA->id,
        'product_id' => $product->id,
        'quantity' => 1,
        'unit_price' => 50000,
        'subtotal' => 50000,
    ]);

    $orderB = Order::create([
        'user_id' => $userB->id,
        'invoice_number' => 'SRN-20260903-0002',
        'customer_name' => 'User B',
        'customer_phone' => '081298765432',
        'customer_email' => 'user_b@example.com',
        'delivery_method' => 'PICKUP',
        'total_amount' => 75000,
        'status' => 'PENDING_PAYMENT',
    ]);

    $this->actingAs($userA);

    Livewire::test(MyOrders::class)
        ->assertSee('SRN-20260903-0001')
        ->assertSee('Spanduk Outdoor')
        ->assertDontSee('SRN-20260903-0002');
});
