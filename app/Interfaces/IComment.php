<?php

namespace App\Interfaces;

interface IComment
{
    
    public function store(array $data);
    public function update(array $data, int $id);
    public function delete(int $id);
}
