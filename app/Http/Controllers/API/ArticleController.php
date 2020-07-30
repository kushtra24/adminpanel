<?php

namespace App\Http\Controllers\API;

use App\article;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ArticleController extends Controller
{

    /**
     * validation rules
     * @var string[]
     */
    private $rules = [
        'title' => 'required|string',
        'content' => 'required|string',
        'slug' => 'required|string',
    ];



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $article = article::orderBy('id', 'DESC')->paginate(8);

        return response()->json($article, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param $article
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->rules);

        $user = Auth::id();

        $slug = $request['slug'];
        $id = Article::count();

        if(Article::where('slug', '=', $slug)->exists()) {
            $request->merge(['slug' => ($slug . "-" . ($id + 1))]);
        }

        $requestedPhoto = $request['photo'];
        // check if requested photo is not an empty string and does not contain storage in it
        if ( $requestedPhoto != '' && !Str::contains($requestedPhoto, 'storage') ) {
            $this->updatePhoto($request, $requestedPhoto, 'article');
        }


        $request->merge(['user_id' => $user]);
        $request->merge(['public' => 1]);

        // create user
        $article = Article::create($request->all());

        $article->category()->attach($request['category']);

        // return json response with user
        return response()->json($article, 200);
    }


    /**
     * Display the specified resource.
     *
     * @param $slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($slug)
    {
        $article = Article::where('slug', $slug)->first();

        return response()->json($article, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(article $article)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, article $article)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(article $article)
    {
        //
    }
}
