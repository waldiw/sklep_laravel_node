<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
    public function order(): BelongsTo
    {
        // do klucza orderUuid z klasy Orders odnosi się klucz uuid z tej klasy Cart
        return $this->belongsTo(Orders::class, 'uuid', 'orderUuid');
    }

}
