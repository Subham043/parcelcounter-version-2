<?php

namespace App\Features\ProductImages\Models;

use App\Features\Products\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    protected $table = 'product_images';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'image_title',
        'image_alt',
        'image',
        'product_id',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [];
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id')->withDefault();
    }
}
