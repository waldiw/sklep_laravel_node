<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\statute;
use Illuminate\Http\Request;

class StatuteController extends Controller
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
        $statutes = statute::all();

        if($statutes->count() > 0)
        {
            $statute = $statutes[0]->statute;
        }
        else
        {
            $statute = '';
        }
        return view('admin.statute', compact('statute'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $statutes = statute::all();
        $validated = $request->validate([
            'statute' => 'required',
        ]);
//dd($validated);
        if($statutes->count() == 0)
        {
            statute::create($validated);
        }
        else
        {
            $statutes[0]->update($validated);
        }
        //$statute = statute::firstOrCreate($validated);

        return back()->with('message', 'Statut został zmieniony!');
    }


}
