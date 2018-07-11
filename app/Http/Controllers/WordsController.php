<?php

namespace App\Http\Controllers;

use App\Word;
use Illuminate\Http\Request;

class WordsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $words = Word::all();

        return view('Words.index')->with('words', $words);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Words.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Get the word from the request
        $word = $request->input('word');

        $count = Word::where('word', $word)->count();

        // Word already exists
        if($count > 0) return redirect()->route('words.index');


        // Make the API request
        $response = \Unirest\Request::get("https://wordsapiv1.p.mashape.com/words/".$word,
            array(
                "X-Mashape-Key" => getenv('X-Mashape-Key'),
                "X-Mashape-Host" => "wordsapiv1.p.mashape.com"
            )
        );

        Word::create(array(
            'word' => $word,
            'api_result' => $response->raw_body
        ));

        return redirect()->route('words.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $word = Word::findOrFail($id);
        $results = json_decode($word->api_result, true);

        echo '<pre>';
        print_r($results);
        echo '</pre>';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
