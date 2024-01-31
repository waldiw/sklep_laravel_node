<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shippings;
use App\Rules\Price;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ShippingController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
//        $this->middleware('can:isAdministrator');
    }

    /**
     * Validate data to store or update.
     */
    private function validator($data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'shipping' => ['required', new Price],
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('shipping.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $this->validator($request->all())->validate();
        $temp = preg_replace("~\D~", "", $data['shipping'] ); // usuwa ze stringa wszystko co nie jest cyrą - czyli precinek z ceny
        $data['shipping'] = $temp;

         //dd($data);
        $shipping = Shippings::create($data);

        session()->flash('message', 'Metoda płatności została dodana do bazy.');

        return redirect(route('admin'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $shipping = shippings::findOrFail($id);

        return view('shipping.edit', compact('shipping'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $shipping = Shippings::findOrFail($id);
        $data = $this->validator($request->all())->validate();

        $temp = preg_replace("~\D~", "", $data['shipping'] ); // usuwa ze stringa wszystko co nie jest cyrą - czyli precinek z ceny
        $data['shipping'] = $temp;

        $shipping->update($data);

        return back()->with('message', 'Metoda płatności została zmieniona!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $shipping = Shippings::findOrFail($id);
        $shipping->delete();

        return redirect(route('admin'))->with('message', 'Metoda płatności została usunięta!');
    }

}
