<?php

namespace App\Http\Controllers;

use App\Film;
use App\Actor;
use Illuminate\Http\Request;

class FilmController extends Controller
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
     * Display a listing of the resource.
     * orig return \Illuminate\Http\Response
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $films = Film::all()->load('actors');

        return view('film.index', compact('films'));
    }

    /**
     * Show the form for creating a new resource.
     * orig return \Illuminate\Http\Response
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('film.create');
    }

    /**
     * Store a newly created resource in storage.
     * orig return \Illuminate\Http\Response
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return Film::create($request->validate([
            'name' => 'required',
            'description' => 'required'
        ]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Film  $film
     * orig return \Illuminate\Http\Response
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Film $film)
    {
//         original
//        return view('film.show', compact('film'));
        $slug = $film['slug'];
        $actor =  Actor::query()
            ->WhereHas('film', function ($q) use ($slug){
                $q  ->where('slug', '=', "{$slug}");
            })
            ->with('film')
            ->get();
        // return actor as well as film
        return view('film.show', compact('film', 'actor' ) );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Film  $film
     * orig return \Illuminate\Http\Response
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Film $film)
    {
        // original not working
        //return view('film.edit', compact('film'));
        return view('film.edit')->with('film', $film);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Film  $film
     * orig return \Illuminate\Http\Response
     * @return bool
     */
    public function update(Request $request, Film $film)
    {
        return $film->update($request->validate([
            'name' => 'required',
            'description' => 'required'
        ]));
    }

    /**
     * Remove the specified resource from storage.
     * orig return \Illuminate\Http\Response
     * @param  \App\Film  $film
     * @return bool
     */
    public function destroy(Film $film)
    {
        return $film->delete();
    }


    /**
     * Display a listing of the resource.
     * orig return \Illuminate\Http\Response
     * @return Film[]|\Illuminate\Database\Eloquent\Collection
     */
    public function list()
    {
        return Film::all()->load('actors');
    }
}
