<?php

namespace App\Repositories;

use App\Models\Post;
use App\Interfaces\IPost;
use Illuminate\Support\Str;

class PostRepository implements IPost
{
    public function index(){
      // Eager load the comments relationship with a limit of 5
      //Eager load Category
      return Post::with(['comments' => function ($query) {
        $query->limit(5);
        }, 'category'])->get();

    }

    public function getById(int $id){
       return Post::findOrFail($id);
    }

    public function store(array $data){
      $data['slug'] = Str::slug($data['title']);
      return Post::create($data);
    }

    public function update(array $data, int $id){
      $data['slug'] = Str::slug($data['title']);
      return Post::whereId($id)->update($data);
    }
    
    public function delete(int $id){
      Post::destroy($id);
    }

    public function exists(int $id){
      return Post::find($id);
    }
}