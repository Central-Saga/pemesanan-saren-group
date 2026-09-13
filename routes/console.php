<?php

use App\Enums\OrderStatus;
use App\Models\Order;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Storage;

Artisan::command('orders:cancel-stale', function () {
    $count = Order::where('status', OrderStatus::PENDING_PAYMENT)
        ->where('created_at', '<', now()->subHours(48))
        ->update(['status' => OrderStatus::CANCELLED]);

    $this->info("{$count} pesanan PENDING_PAYMENT dibatalkan otomatis (>48 jam).");
})->purpose('Batalkan pesanan PENDING_PAYMENT yang tidak dikonfirmasi lebih dari 48 jam');

Artisan::command('artworks:prune-tmp {--hours=168}', function () {
    $disk = Storage::disk('public');
    $cutoff = now()->subHours((int) $this->option('hours'))->getTimestamp();
    $pruned = 0;

    foreach ($disk->allFiles('artworks/tmp') as $path) {
        if ($disk->lastModified($path) < $cutoff) {
            $disk->delete($path);
            $pruned++;
        }
    }

    $this->info("{$pruned} file artwork tmp dibersihkan (>{$this->option('hours')} jam).");
})->purpose('Bersihkan file artwork sementara di artworks/tmp yang lebih tua dari batas jam');

Schedule::command('orders:cancel-stale')->hourly();
Schedule::command('artworks:prune-tmp')->daily();
