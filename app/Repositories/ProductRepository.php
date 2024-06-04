<?php

namespace App\Repositories;

use App\Models\Product;
use App\Interfaces\IProduct;
use Illuminate\Support\Str;

class ProductRepository implements IProduct
{
    public function index(){
        return Product::all();
    }

    public function getById(int $id){
       return Product::findOrFail($id);
    }

    public function store(array $data){
        $data['slug'] = Str::slug($data['title']);
        return Product::create($data);
    }

    public function update(array $data, int $id){
        $data['slug'] = Str::slug($data['title']);
        return Product::whereId($id)->update($data);
    }
    
    public function delete(int $id){
       Product::destroy($id);
    }

    public function exists(int $id){
        return Product::find($id);
    }
}