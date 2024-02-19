<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Orders;
use App\Models\Shippings;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:isAdministrator');
    }

    public function index()
    {
        $users = User::all();
        $orders = Orders::all();
        $shippings = Shippings::all();
        return view('sAdmin.index', compact('users', 'orders', 'shippings'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editPassword(string $id)
    {
        $user = User::findOrFail($id);
        //$user = $user->toArray();
        return view('sAdmin.editPassword', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function updatePassword(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        $validated = $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);
        $user->update($validated);

        return redirect()->route('sadmin')->with('message', 'Hasło zostało zmienione!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyUser(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect(route('sadmin'))->with('message', 'Operator został usunięty!');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createUser()
    {
        return view('sAdmin.createUser');
    }

    /**
     * Validate data to store or update.
     */
    private function validator($data)
    {
        $validated =  Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ])->validate();

        $validated = Arr::add($validated, 'role', 'operator');

        return $validated;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeUser(Request $request)
    {
        //dd($request);
        $data = $this->validator($request->all());
        //dd($data);
        $user = User::create($data);

        return redirect()->route('sadmin')->with('message', 'Operator został dodany!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyAllShippings()
    {
        //Shippings::where('delete', 1)->delete();
        $error = [];
        $shippings = Shippings::where('delete', 1)->get();
        $shippings->each(function ($shipping) {
            $order = Orders::where('shipping_id', $shipping->id);
            if($ode->count == 0) 
            {
            $x = 1;//$shipping->delete()
            }
        else
            {
            $error = $shipping->name;
            }
        });

        dd($error);
        return redirect(route('sadmin'))->with('message', 'Metody płatności zostały usunięte!');
    }

    /**
     * Display the specified resource.
     */
    public function showOrder(string $id)
    {
        $order = Orders::findOrFail($id);
        $totlOrder = totalOrder($order->carts);

        return view('sAdmin.order', compact('order', 'totlOrder'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyOrder(string $id)
    {
        $order = Orders::findOrFail($id);
        $order->delete();

        return redirect(route('sadmin'))->with('message', 'Zamówienie zostało usunięte!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyAllOrders()
    {
        $orders = Orders::where('delete', 1)->get();
//        foreach ($orders as $order){
//            $order->delete();
//        }
        // skrócony zapis powyższej pętli
        $orders->each->delete();

        return redirect(route('sadmin'))->with('message', 'Zamówienia zostały usunięte!');
    }
}
