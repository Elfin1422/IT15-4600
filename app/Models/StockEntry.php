<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockEntry extends Model
{
    use HasFactory;

    protected $table = 'stock_entries';

    protected $fillable = [
        'product_id',
        'supplier_id',
        'quantity',
        'delivery_reference',
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

   
    protected static function boot(): void
    {
        parent::boot();

       
        static::created(function ($stockEntry) {
            $product = $stockEntry->product;
            if ($product) {
                $product->current_stock += $stockEntry->quantity;
                $product->save();
            }
        });

        
        static::deleted(function ($stockEntry) {
            $product = $stockEntry->product;
            if ($product) {
                $product->current_stock -= $stockEntry->quantity;
                $product->save();
            }
        });
    }
}
