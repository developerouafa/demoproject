<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
// use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Post extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'title',
        'body',
        'category_id',
        'parent_id',
        'image',
        'name_en',
        'name_ar'
    ];

    public $translatable = ['title', 'body'];
    // protected $dates = ['deleted_at'];
    /*-------------------- Scope --------------------*/

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

        // public function category(): BelongsTo
        // {
        //     return $this->BelongsTo(category::class, 'parent_id')->parent();
        // }

        public function category(): BelongsTo
        {
            return $this->BelongsTo(category::class);
        }
}
