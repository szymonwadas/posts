<?php

namespace App\Services;
use Illuminate\Support\Facades\Redis;

class Posts
{
    private $posts;

    public function setPosts($posts)
    {
        $this->posts = $posts;
    }

    public function getPosts()
    {
        return $this->posts;
    }

    public function cachePosts()
    {
        //cache do redisa wszystkich postów
        Redis::set('posts.all', json_encode($this->posts));
        $categoriesPosts = [];
        //przypisanie postów do odpowiednich kategorii
        foreach($this->posts as $key => $post)
        {
            foreach($post->categories as $category)
            {
                $categoriesPosts[$category->id][] = $post;
            }
        }
        //cache do redisa postów w zależności od kategorii
        Redis::pipeline(function ($pipe) use($categoriesPosts){
            foreach($categoriesPosts as $key => $posts)
            {
                $pipe->set("posts.category:$key", json_encode($posts));
            }
        });
    }

    public function getCachedPosts($category)
    {
        //jeśli nie podano kategorii, to zwróci z redis wszystkie posty, jeśli podano, to posty dla odpowiedniej kategorii
        return is_null($category) ? Redis::get('posts.all') : Redis::get('posts.category:'.$category);
    }
}