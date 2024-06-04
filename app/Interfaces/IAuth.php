<?php

namespace App\Interfaces;

interface IAuth
{
    public function register(array $data);

    public function findByEmail(string $email);
}
