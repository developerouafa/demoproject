<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product_color extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'color',
    ];

    // Scopes
        public function scopeSelectProductcolor($query){
            return $query->select('id', 'product_id', 'color');
        }

    /*-------------------- Relations --------------------*/
    public function product()
    {
        return $this->belongsTo(product::class);
    }

    public function color()
    {
        return $this->belongsTo(color::class);
    }
}
