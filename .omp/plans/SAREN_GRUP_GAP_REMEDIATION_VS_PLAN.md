# Saren Grup — Gap Remediation vs Obsidian Spec (saren-gaps)

Audit repo `pemesanan-saren-group` terhadap kit spesifikasi (`docs/PRD.md`, `docs/WORKFLOWS.md`, `docs/AGENT_GUIDELINES.md`, `docs/SOUL.md`, `docs/DESIGN.md`, `docs/skills/*`) + daily notes Obsidian (2026-08-30, 2026-09-06, vault: `/mnt/c/Users/Wira Budhi/Obsidian Vault/`).

## Gap ditemukan (hasil audit)

1. **Pesan WA terstruktur tidak pernah dipakai.** `WhatsAppService::generateOrderSubmissionUrl()` + template `resources/views/whatsapp/order-submission.blade.php` (rincian item, ukuran, link file desain) hanya direferensi test. Halaman sukses memakai link hardcoded generik (`resources/views/livewire/frontend/order-success.blade.php:2`) — admin hanya terima "konfirmasi pesanan SRN-... Matur Suksma" tanpa rincian. Melanggar WORKFLOWS §1 langkah 35 ("kirim format pesan terstruktur beserta link file") dan PRD arsitektur (WhatsAppService = payload formatter).
2. **Auto-cancel PENDING_PAYMENT > 48 jam tidak ada.** WORKFLOWS §2 state machine: `PENDING_PAYMENT --> CANCELLED: Tidak ada konfirmasi > 48 Jam`. `routes/console.php` hanya `inspire`; tidak ada scheduler/command.
3. **Nomor resi tidak ada.** WORKFLOWS §2 status 6 (SHIPPED): "Resi diinput di Filament". Tidak ada kolom/field `tracking_number` di orders, OrderForm, OrderInfolist, maupun OrderTracker.
4. **Indikator progress upload artwork tidak ada.** AGENT_GUIDELINES §3.1.3: `wire:loading wire:target="designFile"` + progress. Tiga kalkulator (`banner-calculator`, `sticker-calculator`, `standard-custom-order` blade) tidak punya indikator saat upload 50MB.
5. **File tmp artwork tidak pernah dibersihkan.** `artworkFile->store('artworks/tmp/...')` saat add-to-cart; customer yang abandon meninggalkan file selamanya di disk public.
6. **Varian nonaktif tetap tampil/dipakai.** `is_active` ada di kolom+form admin tapi tidak difilter: `ProductDetail` load semua varian, `StandardCustomOrder::pricing()` pakai `firstWhere` tanpa cek `is_active`.
7. **robots.txt `Disallow: /`** — memblokir seluruh index site e-commerce (default starter tidak diganti).
8. **Warna panel admin tidak sesuai brand.** `AdminPanelProvider` pakai `Color::Indigo`; DESIGN.md/SOUL.md menetapkan Saren Orange `#FF6B00`.
9. **Duplikasi nomor CS.** `order-success.blade.php:2` dan `welcome.blade.php:196` hardcode `6287860042888`; konstanta `WhatsAppService::CS_NUMBER` ada tapi tak dipakai.

Sudah terimplementasi (tidak perlu dikerjakan): katalog 13 produk + varian (ProductSeeder), PricingCalculatorService (min 0.25 m²), InvoiceService SRN-YYYYMMDD-XXXX atomic, state machine OrderStatus 8 state + label/warna, OrderTracker + timeline CANCELLED, Filament OrderResource (WA button, update status, preflight checklist infolist, download file), Shield+RBAC, activity log, Fortify auth, validasi MIME upload `max:51200`, debounce 250ms, delivery PICKUP/COURIER, min order undangan 50/payung 12, bingkai varian 2R–A3, POS walk-in via CreateOrder.

## Approach

Urutan pengerjaan; tree harus tetap build dan test existing hijau setelah tiap langkah.

### Langkah 1 — Pesan WA terstruktur di halaman sukses
- Edit `resources/views/livewire/frontend/order-success.blade.php`: ganti blok `@php $waLink = 'https://wa.me/6287860042888?text=...' @endphp` (baris 2) menjadi `$waLink = app(App\Services\WhatsAppService::class)->generateOrderSubmissionUrl($order);` — full import namespace karena tidak ada `use` di blade.
- Edit `resources/views/welcome.blade.php:196`: ganti literal `'https://wa.me/6287860042888?text=' . urlencode('Halo Admin...')` menjadi `'https://wa.me/'.App\Services\WhatsAppService::CS_NUMBER.'?text='.rawurlencode('Halo Admin Percetakan CV. Saren Grup! ...')` — pertahankan teks kontak yang ada, hanya nomor yang dipakai dari konstanta.
- Update `tests/Feature/CheckoutTest.php`: tambah assertion di test "creates order, persists it, shows success page" — HTML halaman sukses mengandung `wa.me/6287860042888?text=` dan nomor invoice `$order->invoice_number` di dalam encoded text (assert pada `Livewire::test(OrderSuccess::class, ...)` existing, cek `->assertSee('wa.me/6287860042888')` dan `->assertSee(str_replace(['+','%'], ...)` TIDAK diperlukan — cukup assert invoice number muncul: `assertSee($order->invoice_number)` karena `rawurlencode` mengubah `-` tidak, dan invoice `SRN-YYYYMMDD-XXXX` aman tanpa escape).

### Langkah 2 — Kolom tracking_number (resi)
- `php artisan make:migration add_tracking_number_to_orders_table --table=orders --no-interaction` → `$table->string('tracking_number', 50)->nullable()->after('notes');` di up, `dropColumn` di down.
- `app/Models/Order.php`: tambah `'tracking_number'` ke `$fillable` (array line 17–27).
- `database/factories/OrderFactory.php`: tambah optional `'tracking_number' => null` state; default null.
- `app/Filament/Resources/Orders/Schemas/OrderForm.php`: tambah `TextInput::make('tracking_number')->label('Nomor Resi')->maxLength(50)` di Section 'Ringkasan' (blok line 133–147).
- `app/Filament/Resources/Orders/Schemas/OrderInfolist.php`: tambah `TextEntry::make('tracking_number')->label('Nomor Resi')->placeholder('-')` di Section data pengiriman/pemesan.
- `resources/views/livewire/frontend/order-tracker.blade.php`: tampilkan blok resi bila `$order->status === App\Enums\OrderStatus::SHIPPED && $order->tracking_number` — teks "Nomor Resi: {value}" (font mono, ikon truck `heroicon-o-truck`).
- Test baru `tests/Feature/OrderTrackingNumberTest.php` (Pest, `php artisan make:test OrderTrackingNumberTest --pest --no-interaction`): order status SHIPPED + tracking_number → `Livewire::test(OrderTracker::class, ['invoice' => ...])` `->assertSee('Nomor Resi')->assertSee($resi)`; order tanpa resi → `->assertDontSee('Nomor Resi')`.

### Langkah 3 — Scheduler: auto-cancel 48 jam + bersihkan artwork tmp
- `routes/console.php`: ganti isi starter (hapus blok `inspire`) dengan:
  - `Artisan::command('orders:cancel-stale', ...)`: `Order::where('status', 'PENDING_PAYMENT')->where('created_at', '<', now()->subHours(48))->update(['status' => 'CANCELLED'])` — cast enum menangani string value; return jumlah baris sebagai output info.
  - `Artisan::command('artworks:prune-tmp {--hours=168}', ...)`: iterate `Storage::disk('public')->allFiles('artworks/tmp')`, `->lastModified($path) < now()->subHours((int)$this->option('hours'))->getTimestamp()` → delete. `use Illuminate\Support\Facades\{Artisan, Storage};` di atas.
  - Jadwal: `Schedule::command('orders:cancel-stale')->hourly();` dan `Schedule::command('artworks:prune-tmp')->daily();` — Laravel 13 scheduling facade `Schedule` langsung di `routes/console.php`.
- Test `tests/Feature/MaintenanceCommandsTest.php`: (a) order PENDING_PAYMENT `created_at` 49 jam lalu → `$this->artisan('orders:cancel-stale')` → status CANCELLED di DB; order PENDING_PAYMENT 1 jam → tetap; (b) `Storage::fake('public')`, buat file `artworks/tmp/2026/09/x.pdf` (mtime manual via `touch` timestamp — gunakan `Storage::put` lalu set mtime dengan `touch(Storage::disk('public')->path($path), strtotime('-8 days'))`) → `$this->artisan('artworks:prune-tmp')` → file hilang; file baru (1 hari) → tetap. Command harus resolve `Storage::disk('public')` runtime agar fake berlaku.

### Langkah 4 — Indikator progress upload
- Tambah di tiga blade `resources/views/livewire/frontend/{banner,sticker}-calculator.blade.php` dan `standard-custom-order.blade.php`, tepat setelah `<input type="file" wire:model="artworkFile" ...>`:
  ```blade
  <div wire:loading wire:target="artworkFile" class="mt-2 flex items-center gap-2 text-xs text-zinc-500">
      <flux:icon.arrow-path class="h-4 w-4 animate-spin" /> Mengunggah file...
  </div>
  ```
  dan pada tombol submit/add-to-cart masing-masing blade tambah atribut `wire:loading.attr="disabled" wire:target="artworkFile"`.
- Tidak ada test baru (perubahan murni presentasi; suite existing harus tetap hijau).

### Langkah 5 — Filter varian aktif
- `app/Livewire/Frontend/ProductDetail.php:17`: `Product::with('variants')` → `Product::with(['variants' => fn ($q) => $q->where('is_active', true)])`.
- `app/Livewire/Frontend/StandardCustomOrder.php`: di `pricing()` (line ~40) ganti `$this->product->variants->firstWhere('name', $this->selectedVariant)?->price_diff ?? 0` tetap, tapi `mount()` (line 34) `$product->variants->first()?->name` → `$product->variants->firstWhere('is_active', true)?->name ?? ''` (karena relasi sudah terfilter via ProductDetail, guard ini untuk pemakaian standalone).
- `app/Livewire/Frontend/BannerCalculator.php` dan `StickerCalculator.php`: cek pemakaian varian — samakan guard `firstWhere('is_active', true)` di pemilihan default jika pola `first()` ada.
- Test `tests/Feature/ProductVariantVisibilityTest.php`: product dengan 2 varian (satu `is_active=false`), `Livewire::test(ProductDetail::class, ['slug' => ...])` → `->assertSee($activeName)->assertDontSee($inactiveName)`.

### Langkah 6 — Branding & robots
- `app/Providers/Filament/AdminPanelProvider.php:38`: `'primary' => Color::Indigo` → `'primary' => '#FF6B00'` (panel colors menerima hex string; hapus import `Filament\Support\Colors\Color` bila jadi unused).
- `public/robots.txt` isi:
  ```
  User-agent: *
  Disallow: /admin
  Disallow: /checkout
  Disallow: /cart
  ```
- Boot-check setelah Pint (gotchas skill): `php artisan tinker --execute 'echo 1;'`.

### Langkah 7 — Format & verifikasi penuh
- `vendor/bin/pint --dirty --format agent`
- `php artisan test --compact tests/Feature/MaintenanceCommandsTest.php tests/Feature/OrderTrackingNumberTest.php tests/Feature/ProductVariantVisibilityTest.php tests/Feature/CheckoutTest.php tests/Feature/OrderTrackerTest.php tests/Filament/OrderResourceTest.php`
- Minta user jalankan `php artisan test --compact` penuh.

## Critical files & anchors
- `resources/views/livewire/frontend/order-success.blade.php:2` — hardcoded WA link; diganti service call.
- `routes/console.php` — starter inspire; diganti 2 command + jadwal.
- `app/Models/Order.php:17` — `$fillable`; tambah `tracking_number`.
- `app/Livewire/Frontend/ProductDetail.php:17` — eager load varian; tambah filter `is_active`.
- `app/Providers/Filament/AdminPanelProvider.php:38` — panel color Indigo → `#FF6B00`.

## Verification (end-to-end)
Prasyarat (environment saat ini kosong: tidak ada `.env`, tidak ada `vendor/`):
1. `composer install`
2. `cp .env.example .env && php artisan key:generate`
3. Override lokal (docker/redis tidak ada): `DB_CONNECTION=sqlite SESSION_DRIVER=file QUEUE_CONNECTION=sync CACHE_STORE=file`
4. `touch database/database.sqlite && php artisan migrate --seed --force` dan `php artisan storage:link`
5. `npm run build`

Bukti perilaku baru:
- Smoke: `php artisan dev`, buka `/` → tambah banner ke cart → checkout isi nama+HP → submit → halaman sukses menampilkan tombol WA; copy link-nya → URL mengandung `wa.me/6287860042888?text=` dan teks terstruktur berisi `No. Invoice`, `Rincian Pesanan`, link file desain.
- `php artisan orders:cancel-stale` → output jumlah order dibatalkan; cek `php artisan tinker --execute 'App\Models\Order::where("status","PENDING_PAYMENT")->count();'` sesuai ekspektasi.
- Upload file di kalkulator → spinner "Mengunggah file..." muncul saat proses.
- `/admin` → Orders → edit order status SHIPPED + isi Nomor Resi → `/track/{invoice}` menampilkan resi.
- `cat public/robots.txt` → admin/checkout/cart disallow, sisanya boleh.

## Assumptions & contingencies
- **PO number B2B tidak ditambahkan**: PRD persona B2B menyebut "input PO/catatan khusus" — field `notes` sudah mencakup catatan; PO terstruktur ditunda. Jika diinginkan, tambah kolom `po_number` mirip langkah 2.
- **Re-upload file saat reject** tetap via WhatsApp manual (admin set status `PENDING_PAYMENT` + note WA minta file baru; file datang via WA). WORKFLOWS §2 transition tercukupi tanpa UI upload publik baru.
- **Upload 50MB di produksi** butuh `php.ini` `upload_max_filesize`/`post_max_size` ≥ 52M + `client_max_body_size` nginx — deployment note, bukan kode.
- Local run memakai sqlite/file/sync karena docker compose & redis tidak tersedia di workstation; `.env.example` (mysql/redis) tidak diubah untuk production.