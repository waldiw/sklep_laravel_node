<?php

namespace App\Http\Controllers;

use App\Models\contact;
use Illuminate\Http\Request;

class ContactController extends Controller
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
     * Display the specified resource.
     */
    public function show()
    {
        //dd($statute);
        // $statutes = statute::all();

        // if($statutes->count() > 0)
        // {
        //     $statute = $statutes[0]->statute;
        // }
        // else
        // {
        //     $statute = '';
        // }
        return view('admin.contact');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, contact $contact)
    {
        //
    }

 
}
