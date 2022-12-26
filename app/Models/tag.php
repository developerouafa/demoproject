<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class tag extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = ['title'];
    public $translatable = ['title'];

    /*-------------------- Scope --------------------*/
    public function scopeSelectags(mixed $query)
    {
        return $query->select('id', 'title');
    }
    /*-------------------- Relations --------------------*/
    public function post_tags(){
        return $this->hasMany(Post_tag::class, 'tag_id', 'id');
    }
}
