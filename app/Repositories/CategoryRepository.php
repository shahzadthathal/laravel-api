<?php

namespace App\Repositories;

use App\Models\Category;
use App\Interfaces\ICategory;
use Illuminate\Support\Str;

class CategoryRepository implements ICategory
{
    public function index(){
        return Category::all();
    }

    public function getById(int $id){
       return Category::findOrFail($id);
    }

    public function store(array $data){
      $data['slug'] = Str::slug($data['name']);
      return Category::create($data);
    }

    public function update(array $data, int $id){
      $data['slug'] = Str::slug($data['name']);
      return Category::whereId($id)->update($data);
    }
    
    public function delete(int $id){
      Category::destroy($id);
    }

    public function exists(int $id){
      return Category::find($id);
    }
}