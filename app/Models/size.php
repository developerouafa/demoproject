<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class size extends Model
{
    use HasFactory;

    protected $fillable = [
        'height',
        'width',
        'product_id',
    ];
    /*-------------------- Scope --------------------*/

    public function scopeSelectsize(mixed $query)
    {
        return $query->select('id', 'height', 'width');
    }

    /*-------------------- Relations --------------------*/
    public function product()
    {
        return $this->belongsTo(product::class);
    }
}
