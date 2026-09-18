<?php

namespace App\Features\Products\Models;

use App\Features\Categories\Models\Category;
use App\Features\Users\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'hsn',
        'description',
        'description_unfiltered',
        'brief_description',
        'image',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'is_active',
        'is_new',
        'is_on_sale',
        'is_featured',
        'min_cart_quantity',
        'cart_quantity_interval',
        'cart_quantity_specification',
        'user_id',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'is_new' => 'boolean',
            'is_on_sale' => 'boolean',
            'is_featured' => 'boolean',
            'min_cart_quantity' => 'int',
            'cart_quantity_interval' => 'int',
        ];
    }

    protected function slug(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => str()->slug($value),
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_of_products', 'product_id', 'category_id');
    }
}
