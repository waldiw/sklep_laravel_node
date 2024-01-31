<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shippings extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'shipping',
    ];

    // relacja one to one - shipping_id w klasie Orders
    public function order()
    {
        return $this->hasOne(Orders::class);
    }
}
