<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Orders;
use App\Models\Parameters;
use App\Models\Shippings;
use App\Rules\Account;
use App\Rules\Price;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class OperatorController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Validate data to store or update.
     */
    private function validator($data)
    {
        return Validator::make($data, [
            'account' => ['required', new Account],
            //'shipping' => ['required', new Price],
            'email' => 'required|email:rfc,dns',
        ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $orders = Orders::where('delete', 0)->get();
        return view('admin.home', compact('orders'));
    }

    public function admin()
    {
        $parameters = Parameters::all();
        $param = $parameters[0];

        $shippings = Shippings::where('delete', 0)->get();

        return view('admin.admin', compact('param', 'shippings'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $param = Parameters::findOrFail($id);
        $data = $this->validator($request->all())->validate();

        //$temp = preg_replace("~\D~", "", $data['shipping'] ); // usuwa ze stringa wszystko co nie jest cyrą - czyli precinek z ceny
        //$data['shipping'] = $temp;


        $param->update($data);

        return back()->with('message', 'Parametry zostały zmienione!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editOrder(string $id)
    {
        $order = Orders::findOrFail($id);
        $totlOrder = totalOrder($order->carts);

        return view('admin.order', compact('order', 'totlOrder'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateOrder(Request $request, string $id)
    {
        //dd($request);
        $order = Orders::findOrFail($id);
        $validated = $request->validate([
           'status' => 'required|in:nowe, w realizacji, zrealizowane',
        ]);

        $order->update($validated);

        return back()->with('message', 'Status zamówienia został zmieniony!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteOrder(string $id)
    {
        $order = Orders::findOrFail($id);
        if($order->status != 'zrealizowane')
            return back()->with('messageError', 'Zamówienie nie może być usunięte! Nie ma statusu ZREALIZOWANE');
        $temp = $order->toArray();
        $temp['delete'] = 1;
        $order->update($temp);

        return redirect()->route('home')->with('message', 'Zamówienie zostało usunięte!');
    }

    public function statute()
    {
        return view('admin.statute');
    }

}
