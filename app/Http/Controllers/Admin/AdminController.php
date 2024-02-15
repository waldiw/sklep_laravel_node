<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Orders;
use App\Models\Shippings;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        return view('admin.index', compact('users', 'orders', 'shippings'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editPassword(string $id)
    {
        $user = User::findOrFail($id);
        //$user = $user->toArray();
        return view('admin.editPassword', compact('user'));
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
        return view('admin.createUser');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeUser(Request $request)
    {

    }
}
