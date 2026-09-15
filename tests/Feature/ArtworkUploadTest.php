<?php

use App\Livewire\Frontend\BannerCalculator;
use App\Livewire\Frontend\CheckoutPage;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

beforeEach(function () {
    Storage::fake('public');
});

function fakeArtwork(string $name, string $content): UploadedFile
{
    return UploadedFile::fake()->createWithContent($name, $content);
}

it('rejects a non-PDF payload renamed to .pdf', function () {
    $product = Product::factory()->create([
        'base_price' => 25000,
        'is_custom_dimension' => true,
    ]);

    $component = Livewire::test(BannerCalculator::class, ['product' => $product])
        ->set('artworkFile', fakeArtwork('evil.pdf', "<?php echo 'evil'; ?>"))
        ->call('addToCart');

    $component->assertHasErrors('artworkFile');

    expect(implode(' ', $component->errors()->get('artworkFile')))->toContain('MIME')
        ->and(session('cart'))->toBeNull();
});

it('accepts a real PDF and stores its path in the cart', function () {
    $product = Product::factory()->create([
        'base_price' => 25000,
        'is_custom_dimension' => true,
    ]);

    Livewire::test(BannerCalculator::class, ['product' => $product])
        ->set('artworkFile', fakeArtwork('design.pdf', '%PDF-1.4 fake body'))
        ->call('addToCart')
        ->assertHasNoErrors();

    $path = session('cart')[0]['design_file_path'];

    expect($path)->not->toBeNull()
        ->and($path)->toStartWith('artworks/tmp/')
        ->and(Storage::disk('public')->exists($path))->toBeTrue();
});

it('moves artwork out of tmp into the order folder on checkout', function () {
    Storage::disk('public')->put('artworks/tmp/2026/09/design.pdf', '%PDF-1.4 fake body');

    $product = Product::factory()->create();

    session(['cart' => [[
        'product_id' => $product->id,
        'product_name' => $product->name,
        'variant_name' => null,
        'quantity' => 1,
        'unit_price' => 10000,
        'subtotal' => 10000,
        'design_file_path' => 'artworks/tmp/2026/09/design.pdf',
    ]]]);

    Livewire::test(CheckoutPage::class)
        ->set('customerName', 'Wayan')
        ->set('customerPhone', '081234567890')
        ->set('deliveryMethod', 'PICKUP')
        ->call('submitOrder')
        ->assertHasNoErrors();

    $order = Order::firstOrFail();
    $expected = 'artworks/orders/'.$order->id.'/design.pdf';

    expect($order->items->first()->design_file_path)->toBe($expected)
        ->and(Storage::disk('public')->exists($expected))->toBeTrue()
        ->and(Storage::disk('public')->exists('artworks/tmp/2026/09/design.pdf'))->toBeFalse();
});
