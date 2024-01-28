<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Orders extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'street',
        'city',
        'post',
        'email',
        'phone',
        'comments',
        'vat',
        'vatNumber',
        'vatName',
        'vatStreet',
        'vatCity',
        'vatPost',
        'status',
        'uuid',
    ];

    // w widoku dzięki getAdressAttribute pobieramy cały adres $order->adress
    public function getAdressAttribute()
    {
        $string = 'Adres: :street, :city, :post';

        $replaced = preg_replace_array('/:[a-z_]+/', [$this->street, $this->city, $this->post], $string);
        return $replaced;
        //return Storage::url($this->image);
    }

    // relacja one to many
    public function carts()
    {
        // orderUuid - klucz z klasy Orders, uuid - klucz z klasy Cart
        // czyli w klasie Cart do klucza uuid odnosi się klucz orderUuid z klasy Orders
        return $this->hasMany(Cart::class, 'orderUuid', 'uuid');
    }

    public function id()
    {
        return $this->id;
    }

    public function email()
    {
        return $this->email;
    }
}
