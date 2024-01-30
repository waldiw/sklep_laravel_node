<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Parameters;
use App\Rules\Account;
use App\Rules\Price;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
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
        return view('admin.home');
    }

    public function admin()
    {
        $parameters = Parameters::all();

        $param = $parameters[0];

        return view('admin.admin', compact('param'));
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
}
