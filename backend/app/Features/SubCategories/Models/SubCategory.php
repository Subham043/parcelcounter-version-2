<?php

namespace App\Features\SubCategories\Models;

use App\Features\Categories\Models\Category;
use App\Features\Users\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

    protected $table = 'sub_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'heading',
        'slug',
        'description',
        'description_unfiltered',
        'image',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'is_active',
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
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_of_sub_categories', 'sub_category_id', 'category_id');
    }
}
