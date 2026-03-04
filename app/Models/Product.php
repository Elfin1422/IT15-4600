<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'product_code',
        'product_name',
        'price',
        'current_stock',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'current_stock' => 'integer',
    ];

    /**
     * Define a many-to-many relationship with Supplier model.
     *
     * @return BelongsToMany
     */
    public function suppliers(): BelongsToMany
    {
        return $this->belongsToMany(Supplier::class, 'stock_entries')
            ->withPivot('quantity', 'delivery_reference', 'created_at')
            ->withTimestamps();
    }

    /**
     * Get all stock entries for this product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stockEntries()
    {
        return $this->hasMany(StockEntry::class);
    }

    /**
     * Get total stock delivered for this product.
     *
     * @return int
     */
    public function getTotalStockDeliveredAttribute(): int
    {
        return $this->stockEntries()->sum('quantity');
    }
}
