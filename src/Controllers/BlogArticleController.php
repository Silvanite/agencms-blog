<?php

namespace Silvanite\AgencmsBlog\Controllers;

use Illuminate\Http\Request;

use Silvanite\AgencmsBlog\BlogArticle;

class BlogArticleController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return BlogArticle::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $blogArticle = BlogArticle::make($request->all());

        $blogArticle->processRepeatersForSaving()->processImagesForSaving()->save();

        return 200;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return BlogArticle::findOrFail($id);
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
        $blogArticle = BlogArticle::findOrFail($id);

        $blogArticle
            ->fill($request->all())
            ->processRepeatersForSaving()
            ->processImagesForSaving()
            ->save();

            /**
         * Save categories
         */
        $blogArticle->attachedCategories()->sync($request->get('categories'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        BlogArticle::findOrFail($id)->delete();

        return 200;
    }
}
