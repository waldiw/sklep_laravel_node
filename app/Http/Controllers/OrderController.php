<?php

namespace App\Http\Controllers;

use App\Enums\ShippingType;
use App\Models\Cart;
use App\Models\Orders;
use App\Models\Shippings;
use App\Rules\Post;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{

    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $cart = cart(); // cart() funkcja z helpers.php
        $totalCart = totalCart(); // totalCart() - funkcja z helpers.php

        $shippings = Shippings::where('active', 1)->get();
        $shipCost = $shippings[0]->shipping;
        $toPay = $shipCost + $totalCart;
        return view('order', compact('cart', 'totalCart', 'shippings', 'toPay'));
    }

    public function order(Request $request): Application|Response|RedirectResponse|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        if ($request->hasCookie('shopping_uuid')) {

            $data = $this->validator($request->all());
            $uuid = stripslashes(Cookie::get('shopping_uuid'));
            $data['uuid'] = $uuid;

            Orders::create($data);

            $cart = cart(); // cart() funkcja z helpers.php
            foreach ($cart as $item) {
                $cartElement = [];
                $cartElement['name'] = $item['articleName'];
                $cartElement['quantity'] = $item['quantity'];
                $cartElement['price'] = $item['articlePrice'];
                $cartElement['orderUuid'] = $uuid;
                Cart::create($cartElement);
            }

            //$orders = Orders::where('uuid', $cookieData)->first()->carts; // pobiera pozycje koszyka do zamówienia
            //$order = Orders::where('uuid', $cookieData)->first(); // pobiera zamówienie numer uuid
            //$orderCart = $order->carts; // pobiera pozycje koszyka do tego zamówienia
            //$orderId = $order->id;
            //$orderAdress = $order->adress;


            Cookie::queue(Cookie::forget('shopping_cart'));

            // send confirm e-mail
            confirmMail($uuid); //funkcja z helpers.php

            return redirect()->route('summary');
        }
        return response('Strona wygasła.', 403);
    }

    public function summary(): View|Application|Factory|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        if (Cookie::has('shopping_uuid')) {
            $uuid = stripslashes(Cookie::get('shopping_uuid'));
            $summaryOrder = summaryOrder($uuid); // summaryOrder() - funkcja z helpers.php

            if(Orders::where('uuid', $uuid)->first()->shipping->type === ShippingType::PRZELEW)
                $summary = summaryAccount($uuid);
            else
            {
                $summary = summaryCash($uuid);
            }

            Cookie::queue(Cookie::forget('shopping_uuid'));

            return view('summary', compact('summaryOrder', 'summary'));
        }
        return redirect()->route('shop');
    }
    /**
     * Validate data to store or update.
     */
    private function validator($data): array
    {
        if(array_key_exists('vat',$data)) {
            $validated = Validator::make($data, [
                'name' => 'required|max:255',
                'street' => 'required',
                'city' => 'required|max:255',
                'post' => ['required', new Post],
                'email' => 'required|email:rfc,dns',
                'phone' => 'required|numeric',
                'comments' => 'nullable',
                'vat' => 'boolean',
                'vatNumber' => 'required|max:13',
                'vatName' => 'required|max:225',
                'vatStreet' => 'required',
                'vatCity' => 'required|max:255',
                //'vatPost' => ['required_if:vat,1', new Post],
                'vatPost' => ['required', new Post],
                'shipping_id' => 'required',
            ],
                [
                    'phone.numeric' => 'Numer telefonu powinien zawierać tylko cyfry',
                    'vatNumber.required' => 'Numer NIP przy fakturze jest wymagany',
                    'vatName.required' => 'Nazwa przy fakturze jest wymagana',
                    'vatCity.required' => 'Miasto przy fakturze jest wymagane',
                    'vatPost.required' => 'Poczta przy fakturze jest wymagana',
                ])->validate();
        }
        else{
            $validated = Validator::make($data, [
                'name' => 'required|max:255',
                'street' => 'required',
                'city' => 'required|max:255',
                'post' => ['required', new Post],
                'email' => 'required|email:rfc,dns',
                'phone' => 'required|numeric',
                'comments' => 'nullable',
                'vat' => 'boolean',
                'shipping_id' => 'required',
            ],
                [
                    'phone.numeric' => 'Numer telefonu powinien zawierać tylko cyfry',
                ])->validate();
        }
        $validated = Arr::add($validated, 'vat', 0);
        $validated = Arr::add($validated, 'delete', 0);

        return $validated;
    }

}
