<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'orderUuid',
        'quantity',
        'price',

    ];

    //relacja jeden do wielu
    public function order()
    {
        // do klucza orderUuid z klasy Orders odnosi się klucz uuid z tej klasy Cart
        return $this->belongsTo(Orders::class, 'uuid', 'orderUuid');
    }

}
