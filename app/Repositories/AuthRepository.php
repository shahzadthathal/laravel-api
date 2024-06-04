<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Interfaces\IAuth;


class AuthRepository implements IAuth
{
    
    public function register(array $data)
    {
        return User::create([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'password'  => Hash::make($data['password'])
        ]); 
    }

    public function findByEmail(string $email)
    {
        return User::where('email', $email)->firstOrFail();
    }

}