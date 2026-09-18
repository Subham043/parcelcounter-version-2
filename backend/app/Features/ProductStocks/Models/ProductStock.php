<?php

namespace App\Features\ProductStocks\Models;

use App\Features\Products\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductStock extends Model
{
    use HasFactory;

    protected $table = 'product_stocks';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'purchase_stock',
        'quantity',
        'remaining_quantity',
        'purchased_at',
        'product_id',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'purchase_stock' => 'decimal:2',
            'quantity' => 'int',
            'remaining_quantity' => 'int',
            'purchased_at' => 'date'
        ];
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id')->withDefault();
    }
}
