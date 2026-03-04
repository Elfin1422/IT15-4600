<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_code',
        'supplier_name',
        'contact_email',
        'contact_number',
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'stock_entries')
            ->withPivot('quantity', 'delivery_reference', 'created_at')
            ->withTimestamps();
    }

    public function stockEntries()
    {
        return $this->hasMany(StockEntry::class);
    }

    public function getQuantityDeliveredForProduct(int $productId): int
    {
        return $this->stockEntries()
            ->where('product_id', $productId)
            ->sum('quantity');
    }
}
