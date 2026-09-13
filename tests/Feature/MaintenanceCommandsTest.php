<?php

use App\Enums\OrderStatus;
use App\Models\Order;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake('public');
});

it('cancels pending payment orders older than 48 hours', function () {
    $stale = Order::factory()->create([
        'status' => OrderStatus::PENDING_PAYMENT->value,
        'created_at' => now()->subHours(49),
    ]);
    $fresh = Order::factory()->create([
        'status' => OrderStatus::PENDING_PAYMENT->value,
        'created_at' => now()->subHour(),
    ]);

    $this->artisan('orders:cancel-stale')->expectsOutputToContain('dibatalkan')->assertSuccessful();

    expect($stale->fresh()->status)->toBe(OrderStatus::CANCELLED)
        ->and($fresh->fresh()->status)->toBe(OrderStatus::PENDING_PAYMENT);
});

it('leaves non-pending orders untouched', function () {
    $verified = Order::factory()->create([
        'status' => OrderStatus::FILE_VERIFICATION->value,
        'created_at' => now()->subHours(72),
    ]);

    $this->artisan('orders:cancel-stale')->assertSuccessful();

    expect($verified->fresh()->status)->toBe(OrderStatus::FILE_VERIFICATION);
});

it('prunes stale tmp artwork files', function () {
    Storage::disk('public')->put('artworks/tmp/2026/09/old.pdf', 'old');
    Storage::disk('public')->put('artworks/tmp/2026/09/new.pdf', 'new');
    touch(Storage::disk('public')->path('artworks/tmp/2026/09/old.pdf'), now()->subDays(8)->getTimestamp());

    $this->artisan('artworks:prune-tmp')->assertSuccessful();

    expect(Storage::disk('public')->exists('artworks/tmp/2026/09/old.pdf'))->toBeFalse()
        ->and(Storage::disk('public')->exists('artworks/tmp/2026/09/new.pdf'))->toBeTrue();
});
