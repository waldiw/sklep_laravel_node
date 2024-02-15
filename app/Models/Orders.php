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
        'shipping_id',
        'delete',
    ];

    // w widoku dzięki getAdressAttribute pobieramy cały adres $order->adress
    public function getAdressAttribute()
    {
        $string = ':street, :city, :post';

        $replaced = preg_replace_array('/:[a-z_]+/', [$this->street, $this->city, $this->post], $string);
        return $replaced;
        //return Storage::url($this->image);
    }

    // w widoku dzięki getAdressVatAttribute pobieramy cały adres $order->adressVat
    public function getvatAdressAttribute()
    {
        $string = ':street, :city, :post';

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

    // relacja one to one
    public function shipping()
    {
        return $this->belongsTo(Shippings::class);
    }

    // this is the recommended way for declaring event handlers
    public static function boot() {
        parent::boot();
        self::deleting(function($orders) { // before delete() method call this
            $orders->carts()->each(function($cart) {
                $cart->delete(); // <-- direct deletion
            });
         });
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
