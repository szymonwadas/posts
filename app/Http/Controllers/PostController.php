<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\UpsertPostRequest;
use Illuminate\Support\Facades\Auth;
use App\Services\PostRedis;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        return view('posts.index',[
            'posts' => Post::where('user_id', Auth::id())->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        return view('posts.create',[
            'categories' => Category::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UpsertPostRequest  $request
     * @return Redirect
     */
    public function store(UpsertPostRequest $request)
    {
        $post = new Post($request->validated());
        $post->user_id = Auth::id();
        $post->save();

        //połączenie postów z kategoriami
        $post->categories()->attach($request->validated()['categories']);

         //cache do redisa wszystkich postów
        $this->cachePosts();
        return redirect(route('posts.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return View
     */
    public function edit(Post $post)
    {
        $categories = $this->setCategoriesIds($post->categories);
        return view('posts.edit',[
            'post' => $post,
            'post_categories' => $categories, 
            'categories' => Category::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpsertPostRequest  $request
     * @param  \App\Models\Post  $post
     * @return Redirect
     */
    public function update(UpsertPostRequest $request, Post $post)
    {
        $post->fill($request->validated());
        $post->save();

        // usunięcie powiązania kategorii z postami
        $post->categories()->detach();

        //połączenie postów z kategoriami
        $post->categories()->attach($request->validated()['categories']);

         //cache do redisa wszystkich postów
        $this->cachePosts();
        return redirect(route('posts.index'));
    }

    /**
     * Set categories ids
     *
     * @param  Array  $categories
     * @return Array
     */

    public function setCategoriesIds($categories)
    {
        $categoriesIds = [];
        foreach($categories as $category){
            $categoriesIds[] = $category->id;
        }
        return $categoriesIds;
    }

     /**
     * Get posts
     *
     * @param  Int  $category
     * @return Json
     */

    public function getPosts($category = null)
    {
        $cachedPosts = new PostRedis();
        return $cachedPosts->getCachedPosts($category);
    }

     /**
     * Cache posts to redis
     *
     */

    public function cachePosts()
    {
        $cachePosts = new PostRedis();
        $cachePosts->setPosts(Post::all());
        $cachePosts->cachePosts();
    }
}
