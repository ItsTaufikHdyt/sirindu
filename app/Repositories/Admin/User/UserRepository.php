<?php

namespace App\Repositories\Admin\User;

use App\Repositories\Admin\Core\User\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    protected $user;
    
    public function __contruct(
        user $user
    ) {
        $this->user = $user;
    }

    public function storeUser($request)
    {
        $user = User::create([
            'nik' => $request->nik,
            'name' => $request->name,
            'email' => $request->email,
            'type' => $request->type,
            'password' => bcrypt('sirindu123'),
        ]);
    }
}
