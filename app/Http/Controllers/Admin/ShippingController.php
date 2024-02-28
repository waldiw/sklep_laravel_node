<?php

namespace App\Http\Controllers\Admin;


use App\Enums\ShippingType;
use App\Http\Controllers\Controller;
use App\Models\Shippings;
use App\Rules\Price;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Arr;
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
    private function validator($data): array
    {
        $type = 'required|in:';
        $types = ShippingType::TYPES;
        foreach ($types as $TYPE) {
            $type .= $TYPE;
            if( next($types) ) {
                $type .= ',';
            }
        }
        //dd($type);
        $validated = Validator::make($data, [
            'name' => 'required|max:255',
            'shipping' => ['required', new Price],
            'type' => $type,
            'active' => 'boolean',
            'delete' => 'boolean'
            //'type' => 'required|in:text,photo',
        ])->validate();

        $validated = Arr::add($validated, 'active', 0);
        $validated = Arr::add($validated, 'delete', 0);
        return $validated;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('shipping.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $data = $this->validator($request->all());
        $temp = preg_replace("~\D~", "", $data['shipping'] ); // usuwa ze stringa wszystko co nie jest cyrą - czyli precinek z ceny
        $data['shipping'] = $temp;

         //dd($data);
        $shipping = Shippings::create($data);

        session()->flash('message', 'Metoda płatności została dodana do bazy.');

        return redirect(route('admin'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $shipping = shippings::findOrFail($id);

        return view('shipping.edit', compact('shipping'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        //dd($request);
        $shipping = Shippings::findOrFail($id);
        $oldPrice = $shipping['shipping'];
        $oldName = $shipping['name'];
        $oldType = $shipping['type'];
        $oldAcitve = $shipping['active'];

        $data = $this->validator($request->all());

        $temp = preg_replace("~\D~", "", $data['shipping'] ); // usuwa ze stringa wszystko co nie jest cyrą - czyli precinek z ceny
        $data['shipping'] = $temp;
        if($oldAcitve != $data['active'] && $oldType == $data['type'] && $oldName == $data['name'] && $oldPrice == $data['shipping'])
        {
            $shipping->update($data); // zmiana tylko aktywności metody płatności
        }
        else
        {
            // dodanie nowej metody płatności z poprawionymi parametrami
            Shippings::create($data);
            //zmiana bieżącej płatności na nieaktywną i usuniętą
            $data['shipping'] = $oldPrice;
            $data['delete'] = 1;
            $data['active'] = 0;
            $shipping->update($data);
        }

        return redirect(route('admin'))->with('message', 'Metoda płatności została zmieniona.');
        //return back()->with('message', 'Metoda płatności została zmieniona!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $shipping = Shippings::findOrFail($id);
//        $orders = Orders::where('shipping_id', $id)->get();
//        if($orders->count() > 0)
//        {
//            return redirect(route('admin'))->with('messageError', 'Metoda płatności nie może zostać usunięta, zamówienia mają ustawioną tą metodę płatności!');
//        }
        // przy kasowaniu płatności nie usuwamy jej z bazy, zmieniamy delete na 1 i active na 0
        // płatność nie jest widziana w składaniu zamówienia i panelu administratora
        // płatność jest dostępna w wyświetlaniu szczegółw zamówienia u admina
        $temp = $shipping->toArray();
        $temp['delete'] = 1;
        $temp['active'] = 0;
        $shipping->update($temp);

        return redirect(route('admin'))->with('message', 'Metoda płatności została usunięta!');
    }

}
