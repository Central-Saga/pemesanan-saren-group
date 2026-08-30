<?php

namespace App\Models;

use App\Enums\ProductCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name',
        'category',
        'description',
        'base_price',
        'min_size_m2',
        'unit_label',
        'is_custom_dimension',
        'requires_design_file',
        'image_path',
    ];

    protected function casts(): array
    {
        return [
            'category' => ProductCategory::class,
            'base_price' => 'integer',
            'min_size_m2' => 'decimal:2',
            'is_custom_dimension' => 'boolean',
            'requires_design_file' => 'boolean',
        ];
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function getBasePriceFormattedAttribute(): string
    {
        return 'Rp '.number_format($this->base_price, 0, ',', '.');
    }
}
