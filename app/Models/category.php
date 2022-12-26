<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class category extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'title',
        'status',
        'image',
        'parent_id',
    ];

    public $translatable = ['title'];

    /*-------------------- Scope --------------------*/

    public function scopeParent(mixed $query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeChild(mixed $query)
    {
        return $query->whereNotNull('parent_id');
    }

    public function scopeSelectcategories(mixed $query)
    {
        return $query->select('id', 'title', 'image', 'status','parent_id');
    }

    public function scopeSelectchildrens(mixed $query)
    {
        return $query->select('id', 'title', 'image', 'status','parent_id');
    }

    public function scopeWithchildrens(mixed $query)
    {
        return $query->with('subcategories');
    }

    public function scopeWithcategories(mixed $query)
    {
        return $query->with('category');
    }
    /*-------------------- Relations --------------------*/

    public function subcategories(): HasMany
    {
        return $this->hasMany(category::class, 'parent_id')->child();
    }

    public function category(): BelongsTo
    {
        return $this->BelongsTo(category::class, 'parent_id')->parent();
    }

}
