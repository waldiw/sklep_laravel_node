<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\contact;
use App\Models\statute;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Article;


class ShopController extends Controller
{

    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $articles = Article::where('active', 1)->get();
        // $articles = Article::orderBy('nazwa', 'desc')->get(); // pobieranie wszystkich artukułow posortowanyc wg nazwy , dokumentacja - Database: Query Builder
        return view('index', compact('articles'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
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

    public function statute(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $temp = statute::all();
        if($temp->count() > 0)
        {
            $statute = $temp[0]->contact;
        }
        else
        {
            $statute = "";
        }

        return view('statute', compact('statute'));
    }

    public function contact(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $temp = contact::all();
        if($temp->count() > 0)
        {
            $contact = $temp[0]->contact;
        }
        else
        {
            $contact = "";
        }

        return view('contact', compact('contact'));
    }
}
