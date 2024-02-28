<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Shippings extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'shipping',
        'type',
        'active',
        'delete',
    ];

    // relacja one to one - shipping_id w klasie Orders
    public function order(): HasOne
    {
        return $this->hasOne(Orders::class);
    }
}
