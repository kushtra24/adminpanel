<?php

namespace App\Http\Controllers\API;

use App\article;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
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
    public function index() {
        // get Articles order them by Id and descending also paginate them by 8
        $articles = article::orderBy('id', 'DESC')->paginate(8);

        return response()->json($articles, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param $article
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request) {

        // check if is admin or author
        if (!Gate::allows('isAdmin') || !Gate::allows('isAuthor')) {
            // return access denied
            throw new \InvalidArgumentException('You do not have enough privileges to save an article', 400);
        }

        // validate the request
        $this->validate($request, $this->rules);

        // get authenticated user my Id
        $AuthenticatedUser = Auth::id();

        // get the slug from the request
        $slug = $request['slug'];
        // get how many articles are posted
        $numberOfArticles = Article::count();

        // check if slug already exists if so add and Id to the slug
        if(Article::where('slug', '=', $slug)->exists()) {
            // merge the number of articles +1 to the slug
            $request->merge(['slug' => ($slug . "-" . ($numberOfArticles + 1))]);
        }

        // get the photo from the request
        $requestedPhoto = $request['photo'];

        // check if requested photo is not an empty string and does not contain storage in it
        if ( $requestedPhoto != '' && !Str::contains($requestedPhoto, 'storage') ) {
            $this->updatePhoto($request, $requestedPhoto, 'article');
        }
        // merge the Auth in user on the request
        $request->merge(['user_id' => $AuthenticatedUser]);

        // create user
        $article = Article::create($request->all());
        // attach categories of article
        $article->category()->attach($request['cat']);

        // return json response with user
        return response()->json($article, 200);
    }


    /**
     * Display the specified resource.
     *
     * @param $slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($slug) {

        // check if slug is set
        if (!isset($slug)) {
            throw new \InvalidArgumentException('Bad argument: Important credential \'slug\' is in bad format.', 400);
        }

        // get article from slug
        $article = Article::where('slug', $slug)->first();

        // get the category of the post and add it to the article query
        if (isset($article->category)) {
            $here = $article->category->pluck('id');
            $article['cat'] = $here;
        }

        return response()->json($article, 200);
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
        // check if is admin or author
        if (!Gate::allows('isAdmin') || !Gate::allows('isAuthor')) {
            // return access denied
            throw new \InvalidArgumentException('You do not have enough privileges to delete an article', 400);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($slug)
    {
        // check if is admin or author
        if (!Gate::allows('isAdmin') || !Gate::allows('isAuthor')) {
            // return access denied
            throw new \InvalidArgumentException('You do not have enough privileges to delete an article', 400);
        }

        // get the user
        $article = Article::where('slug', $slug)->firstOrFail();

        // gelete user
        $article->delete();

        return response()->json('Deleted', 200);
    }
}
