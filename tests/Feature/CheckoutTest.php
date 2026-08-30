<?php

use App\Livewire\Frontend\CheckoutPage;
use App\Livewire\Frontend\OrderSuccess;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

function seedCart(Product $product, array $overrides = []): void
{
    session(['cart' => [array_merge([
        'product_id' => $product->id,
        'product_name' => $product->name,
        'variant_name' => null,
        'quantity' => 1,
        'unit_price' => 25000,
        'subtotal' => 25000,
    ], $overrides)]]);
}

beforeEach(function () {
    Storage::fake('public');
});

it('creates order, persists it, and shows success page', function () {
    $product = Product::factory()->create([
        'base_price' => 25000,
        'is_custom_dimension' => false,
    ]);

    seedCart($product);

    Livewire::test(CheckoutPage::class)
        ->set('customerName', 'Wayan Suardana')
        ->set('customerPhone', '081234567890')
        ->set('deliveryMethod', 'PICKUP')
        ->call('submitOrder')
        ->assertHasNoErrors()
        ->assertRedirectContains('/pesanan-sukses/');

    $order = Order::first();
    expect($order)->not->toBeNull()
        ->and($order->customer_name)->toBe('Wayan Suardana')
        ->and($order->total_amount)->toBe(25000)
        ->and($order->status->value)->toBe('PENDING_PAYMENT')
        ->and($order->items)->toHaveCount(1)
        ->and(session('cart'))->toBeNull();

    Livewire::test(OrderSuccess::class, ['invoice' => $order->invoice_number])
        ->assertOk();
});

it('requires delivery address for courier delivery', function () {
    $product = Product::factory()->create();

    seedCart($product, ['quantity' => 1, 'unit_price' => 10000, 'subtotal' => 10000]);

    Livewire::test(CheckoutPage::class)
        ->set('customerName', 'Wayan')
        ->set('customerPhone', '081234567890')
        ->set('deliveryMethod', 'COURIER')
        ->call('submitOrder')
        ->assertHasErrors('deliveryAddress');

    expect(Order::count())->toBe(0);
});

it('persists uploaded artwork path from cart to order item', function () {
    $product = Product::factory()->create();

    seedCart($product, [
        'quantity' => 1,
        'unit_price' => 10000,
        'subtotal' => 10000,
        'design_file_path' => 'artworks/tmp/test.pdf',
    ]);

    Livewire::test(CheckoutPage::class)
        ->set('customerName', 'Wayan')
        ->set('customerPhone', '081234567890')
        ->set('deliveryMethod', 'PICKUP')
        ->call('submitOrder')
        ->assertHasNoErrors();

    expect(Order::first()->items->first()->design_file_path)->toBe('artworks/tmp/test.pdf');
});

it('validates malformed phone number', function () {
    $product = Product::factory()->create();

    seedCart($product, ['quantity' => 1, 'unit_price' => 10000, 'subtotal' => 10000]);

    Livewire::test(CheckoutPage::class)
        ->set('customerName', 'Wayan')
        ->set('customerPhone', '12345')
        ->call('submitOrder')
        ->assertHasErrors('customerPhone');

    expect(Order::count())->toBe(0);
});
