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
            
            'name' => $request->name,
            'email' => $request->email,
            'type' => $request->type,
            'password' => bcrypt('sirindu123'),
            'id_kec' => $request->id_kec,
            'id_kel' => $request->id_kel,
            'id_puskesmas' => $request->id_puskesmas,
            'id_posyandu' => $request->id_posyandu,
        ]);
    }
    public function updateUser($request,$id)
    {
        $user = User::find($id);
        $user->update([
            
            'name' => $request->name,
            'email' => $request->email,
            'type' => $request->type,
            'id_kec' => $request->id_kec,
            'id_kel' => $request->id_kel,
            'id_puskesmas' => $request->id_puskesmas,
            'id_posyandu' => $request->id_posyandu,
        ]);
    }
    public function destroyUser($id)
    {
        $user = User::find($id);
        $user->delete();
    }
}
