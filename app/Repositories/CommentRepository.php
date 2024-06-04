<?php

namespace App\Repositories;


use App\Models\Post;
use App\Models\Product;
use App\Models\Comment;
use App\Interfaces\IComment;

class CommentRepository implements IComment
{

    public function store(array $data){
      return Comment::create($data);
    }

    public function update(array $data, int $id){
      return Comment::whereId($id)->update($data);
    }
    
    public function delete(int $id){
      Comment::destroy($id);
    }

}