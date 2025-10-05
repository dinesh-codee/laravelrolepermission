<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
// For Middleware
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller // implements HasMiddleware
{
    // public static function middleware(): array
    // {
    //     return [
    //         new Middleware ('permission:view articles',  only: ['index']),
    //         new Middleware ('permission:edit articles',  only: ['edit']),
    //         new Middleware ('permission:create articles',  only: ['create']),
    //         new Middleware ('permission:delete articles',  only: ['destroy']),
    //     ];
    // }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(Gate::denies('read articles'), 403);
        $article = Article::latest()->paginate(8); // Order by created_at desc

        return view('articles.list', [
            'articles' => $article,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('create articles'), 403);

        return view('articles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3',
            'author' => 'required|min:3',
        ]);

        if ($validator->passes()) {
            $article = new Article;
            $article->title = $request->title;
            $article->text = $request->text;
            $article->author = $request->author;
            $article->save();

            // dd($article);
            return redirect()->route('articles.index')->with('success', 'Article Created Successfully');
        } else {
            return redirect()->route('articles.create')->withInput()->withErrors($validator);
        }
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
        $article = Article::findOrFail($id);

        return view('articles.edit', [
            'article' => $article,
        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $article = Article::findOrFail($id); // Check whether the [id] is in database or not

        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3',
            'author' => 'required|min:3',
        ]);

        if ($validator->passes()) {
            $article->title = $request->title;
            $article->text = $request->text;
            $article->author = $request->author;
            $article->save();

            // dd($article);
            return redirect()->route('articles.index')->with('success', 'Article Updated Successfully');
        } else {
            return redirect()->route('articles.edit', $id)->withInput()->withErrors($validator);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $article = Article::find($request->id);

        if ($article == null) {
            session()->flash('error', 'Article Not found');

            return response()->json([
                'status' => false,
            ]);
        } else {

            $article->delete();

            session()->flash('success', 'Article Deleted Successfully');

            return response()->json([
                'status' => true,
            ]);

        }
    }
}
