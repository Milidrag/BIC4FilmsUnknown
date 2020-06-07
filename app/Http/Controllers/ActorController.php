<?php

namespace App\Http\Controllers;

use App\Actor;
use App\Film;
use Illuminate\Http\Request;

class ActorController extends Controller
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
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $actor = Actor::all()->load('film');

        return view('actor.index', compact('actor'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('actor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        return Actor::create($request->validate([
            'name' => 'required',
            'description' => 'required',
            'film_id' => 'required|exists:App\Film,id'
        ]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Actor  $actor
     * @return \Illuminate\Http\Response
     */
    public function show(Actor $actor)
    {
        // original
//        return view('actor.show', compact('actor'));
        // get the film where the actors plays in
        $slug = $actor['slug'];
        $film =  Film::query()
            ->WhereHas('actors', function ($q) use ($slug){
                $q  ->where('slug', '=', "{$slug}");
            })
            ->with('actors')
            ->get();
        // return actor as well as film
        return view('actor.show', compact('film', 'actor' ) );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Actor  $actor
     * @return \Illuminate\Http\Response
     */
    public function edit(Actor $actor)
    {
        // default
//        return view('actor.edit', compact($actor));
        return view('actor.edit')->with('actor', $actor);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Actor  $actor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Actor $actor)
    {
        return $actor->update($request->validate([
            'name' => 'required',
            'description' => 'required',
            'film_id' => 'required|exists:App\Film,id'
        ]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Actor  $actor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Actor $actor)
    {
        return $actor->delete();
    }


    /**
     * Show form for searching.
     *
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
        /*return view('actor.search');*/
        $actor = Actor::all()->load('film');

        return view('actor.search', compact('actor'));
    }


    /**
     * Return search result.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function query(Request $request)
    {
        $search = $request->validate([
            'q' => 'required'
        ])['q'];

        return Actor::query()
            ->where('name', 'LIKE', "%{$search}%")
            ->orWhere('description', 'LIKE', "%{$search}%")
            ->orWhereHas('film', function ($q) use ($search){
                $q  ->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%");
            })
            ->with('film')
            ->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        return Actor::all()->load('film');
    }
}
