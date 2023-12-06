<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:isAdministrator');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::all();
        // $articles = Article::orderBy('nazwa', 'desc')->get(); // pobieranie wszystkich artukułow posortowanyc wg nazwy , dokumentacja - Database: Query Builder   
        return view('articles', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('articles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $data = $request->validate([
             'name' => 'required|max:255',
             'description' => 'required',
             'price' => 'required',   
             'image' => 'nullable|image|max:1024'
        ]);
        //$data['price'] = '1111';
        $temp = preg_replace("~\D~", "", $data['price'] ); // usuwa ze stringa wszystko co nie jest cyrą - czyli precinek z ceny
        $data['price'] = $temp;

        if(isset($data['image'])) {
            $path = $request->file('image')->store('photos');
            $data['image'] = $path;
        }
        //dd($data);
        $article = Article::create($data);

        session()->flash('message', 'Artykuł został dodany do bazy');

        return redirect(route('articles'));
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
