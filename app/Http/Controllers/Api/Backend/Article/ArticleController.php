<?php

namespace App\Http\Controllers\Api\Backend\Article;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Download;
use App\Article;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $query = Article::query();

        if ($request->search['text']) {
            $query->where('title', 'LIKE', '%' . $request->search['text'] . '%');
        }

       $items = $query->orderBy($request->input('orderBy.column'), $request->input('orderBy.direction'))
            ->paginate($request->input('pagination.per_page'));

        return $items;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validData = $this->validate($request, [
            'title' => 'required',
            'description' => 'nullable|string',
            'preview' => 'required',
            'background' => 'required',
            'text' => 'required|string',
            'published' => 'boolean'
        ]);

        $article = Article::make($validData);
        $article->user_id = auth()->id();
        $article->preview()->associate(Download::find($validData['preview']['id']));
        $article->background()->associate(Download::find($validData['background']['id']));
        $article->save();
        foreach ($request['tags'] as $key => $tag) {
            $article->tag($tag['name']);
        }
        $article->save();
        return $article;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        return $article->load([
            'tags:name',
            'preview',
            'background'
        ]);
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
    public function update(Request $request, Article $article)
    {
        $validData = $this->validate($request, [
            'title' => 'required',
            'description' => 'nullable|string',
            'preview' => 'required',
            'background' => 'required',
            'text' => 'required|string',
            'published' => 'boolean'
        ]);

        $article->fill($validData);
        $article->user_id = auth()->id();
        $article->preview()->associate(Download::find($validData['preview']['id']));
        $article->background()->associate(Download::find($validData['background']['id']));
        $article->save();
        $article->detag();
        foreach ($request['tags'] as $key => $tag) {
            $article->tag($tag['name']);
        }
        $article->save();
        return $article;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        return Article::destroy($article->id);
    }
}
