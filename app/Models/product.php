<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

class product extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'title',
        'description',
        'category_id',
        'parent_id',
        'price',
        'status'
    ];

    public $translatable = ['title', 'description'];

    // Scopes
    public function scopeProductwith($query){
        return $query->with('category')->with('subcategories')->with('image')->with('product_color')->with('size')->with('promotion');
    }

    public function scopeProductselect($query){
        return $query->select('id', 'title', 'description', 'price', 'status', 'category_id', 'parent_id');
    }

    public function scopeParent(mixed $query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeChild(mixed $query): ?object
    {
        return $query->whereNotNull('parent_id');
    }

    /*-------------------- Relations --------------------*/
    public function subcategories(): BelongsTo
    {
        return $this->BelongsTo(category::class, 'parent_id')->child();
    }

    public function category(): BelongsTo
    {
        return $this->BelongsTo(category::class);
    }

    public function image()
    {
        return $this->hasMany(image::class);
    }

    public function product_color()
    {
        return $this->hasMany(product_color::class);
    }

    public function size()
    {
        return $this->hasMany(size::class);
    }

    public function promotion()
    {
        return $this->hasMany(promotion::class);
    }

    // public function Buying_Selling_Bulk()
    // {
    //     return $this->hasMany(Buying_Selling_Bulk::class);
    // }

}
