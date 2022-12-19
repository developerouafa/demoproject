<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class tag extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = ['title', 'name_en', 'name_ar'];
    public $translatable = ['title'];

    public function post_tags(){
        return $this->hasMany(Post_tag::class, 'tag_id', 'id');
    }
}
