<?php

use App\Livewire\Frontend\ProductDetail;
use App\Livewire\Frontend\StandardCustomOrder;
use App\Models\Product;
use App\Models\ProductVariant;
use Livewire\Livewire;

it('hides inactive variants from product detail', function () {
    $product = Product::factory()->create();
    $active = ProductVariant::factory()->create([
        'product_id' => $product->id,
        'name' => 'Bingkai Hitam',
        'is_active' => true,
    ]);
    $inactive = ProductVariant::factory()->create([
        'product_id' => $product->id,
        'name' => 'Bingkai Emas',
        'is_active' => false,
    ]);

    Livewire::test(ProductDetail::class, ['slug' => $product->slug])
        ->assertOk()
        ->assertSee($active->name)
        ->assertDontSee($inactive->name);
});

it('prices standard order with active variant only', function () {
    $product = Product::factory()->create([
        'slug' => 'kartu-undangan',
        'base_price' => 10000,
        'is_custom_dimension' => false,
        'requires_design_file' => false,
    ]);
    ProductVariant::factory()->create([
        'product_id' => $product->id,
        'name' => 'Varian Aktif',
        'price_diff' => 2000,
        'is_active' => true,
    ]);
    ProductVariant::factory()->create([
        'product_id' => $product->id,
        'name' => 'Varian Nonaktif',
        'price_diff' => 9999,
        'is_active' => false,
    ]);

    $component = Livewire::test(StandardCustomOrder::class, ['product' => $product]);

    expect($component->instance()->selectedVariant)->toBe('Varian Aktif')
        ->and($component->instance()->pricing['unit_price'])->toBe(12000);
});
