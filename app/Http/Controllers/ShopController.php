<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;


class ShopController extends Controller
{

    public function index()
    {
        $articles = Article::all();
        // $articles = Article::orderBy('nazwa', 'desc')->get(); // pobieranie wszystkich artukułow posortowanyc wg nazwy , dokumentacja - Database: Query Builder
        return view('index', compact('articles'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $article = Article::findOrFail($id);

        // if(isset($article['image'])) {
        //     $path = $request->file('image')->store('photos');
        //     $article['image'] = $path;
        // }
        $path = '/storage/' . $article['image'];
        $article['image'] = $path;
        
        return response()->json($article);
        //return $path;;
    }
}
