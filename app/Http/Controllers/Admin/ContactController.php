<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\contact;
use App\Models\statute;
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
         $contacts = contact::all();

         if($contacts->count() > 0)
         {
             $contact = $contacts[0]->contact;
         }
         else
         {
             $contact = '';
         }
        return view('admin.contact', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $contacts = contact::all();
        $validated = $request->validate([
            'contact' => 'required',
        ]);
        if($contacts->count() == 0)
        {
            contact::create($validated);
        }
        else
        {
            $contacts[0]->update($validated);
        }

        return back()->with('message', 'Dane kontaktowe zostały zmienione!');
    }


}
