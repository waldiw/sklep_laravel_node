<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Rules\Price;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['show']);
//        $this->middleware('can:isAdministrator');
    }

    /**
     * Validate data to store or update.
     */
    private function validator($data): array
    {
        $validated =  Validator::make($data, [
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => ['required', new Price],
            'image' => 'nullable|image|max:1024',
            'active' => 'boolean',
        ])->validate();

        $validated = Arr::add($validated, 'active', 0);
        return $validated;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $articles = Article::all();
        // $articles = Article::orderBy('nazwa', 'desc')->get(); // pobieranie wszystkich artukułow posortowanyc wg nazwy , dokumentacja - Database: Query Builder
        return view('articles.articles', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('articles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $data = $this->validator($request->all());
        $temp = preg_replace("~\D~", "", $data['price']); // usuwa ze stringa wszystko co nie jest cyrą - czyli precinek z ceny
        $data['price'] = $temp;

        if (isset($data['image'])) {
            $path = $request->file('image')->store('photos');
            $data['image'] = $path;
        }
        $article = Article::create($data);

        session()->flash('message', 'Artykuł został dodany do bazy');

        return redirect(route('articles'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $article = Article::findOrFail($id);

        return view('articles.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $article = Article::findOrFail($id);
        $oldImage = $article->image; // zmienna przechowuje scieżkę od zdjecia edytowanego wpisu
        $data = $this->validator($request->all());

        $temp = preg_replace("~\D~", "", $data['price'] ); // usuwa ze stringa wszystko co nie jest cyrą - czyli precinek z ceny
        $data['price'] = $temp;

        if(isset($data['image'])) {
            $path = $request->file('image')->store('photos');
            $data['image'] = $path;
        }

        $article->update($data);

        // jeżeli w przesyłanych danych do zmiany jest zdjecie, to kasujemy stare
        if(isset($data['image'])) {
            Storage::delete(($oldImage));
        }
        return back()->with('message', 'Artykuł został zmieniony!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $article = Article::findOrFail($id);
        $article->delete();

        Storage::delete($article->image); // kasowanie zdjecia usuniętego artykułu z dysku
        return redirect(route('articles'))->with('message', 'Artykuł został usunięty!');
    }
}
