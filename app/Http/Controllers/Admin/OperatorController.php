<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use App\Models\Parameters;
use App\Models\Shippings;
use App\Rules\Account;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
    private function validator($data): \Illuminate\Validation\Validator
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
     * @return Renderable
     */
    public function index(): Renderable
    {
        $orders = Orders::where('delete', 0)->get();
        return view('admin.home', compact('orders'));
    }

    public function admin(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $parameters = Parameters::all();
        $param = $parameters[0];

        $shippings = Shippings::where('delete', 0)->get();

        return view('admin.admin', compact('param', 'shippings'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $param = Parameters::findOrFail($id);
        $data = $this->validator($request->all())->validate();
        $param->update($data);

        return back()->with('message', 'Parametry zostały zmienione!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editOrder(string $id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $order = Orders::findOrFail($id);
        $totlOrder = totalOrder($order->carts);

        return view('admin.order', compact('order', 'totlOrder'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateOrder(Request $request, string $id): RedirectResponse
    {
        //dd($request);
        $order = Orders::findOrFail($id);
        $validated = $request->validate([
//           'status' => 'required|in:nowe, w realizacji, zrealizowane',
            'status' => 'required',
        ]);

        $order->update($validated);

        return back()->with('message', 'Status zamówienia został zmieniony!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteOrder(string $id): RedirectResponse
    {
        $order = Orders::findOrFail($id);
        if($order->status != 'zrealizowane')
            return back()->with('messageError', 'Zamówienie nie może być usunięte! Nie ma statusu ZREALIZOWANE');
        $temp = $order->toArray();
        $temp['delete'] = 1;
        $order->update($temp);

        return redirect()->route('home')->with('message', 'Zamówienie zostało usunięte!');
    }

    public function statute(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.statute');
    }

}
