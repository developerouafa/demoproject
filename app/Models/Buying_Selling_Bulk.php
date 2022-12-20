<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buying_Selling_Bulk extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'total'
    ];

    /*-------------------- Relations --------------------*/
    // public function product()
    // {
    //     return $this->belongsTo(product::class);
    // }
}
