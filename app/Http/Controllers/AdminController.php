<?php

namespace App\Http\Controllers;

use App\Repositories\Admin\User\UserRepository as UserInterface;
use App\Http\Requests\Admin\User\storeUserRequest;
use App\Models\User;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $userRepository;

    public function __construct(
        UserInterface $userRepository
    ) {
        $this->middleware('auth');
        $this->userRepository = $userRepository;
    }

    public function anak()
    {
        return view('admin.anak.index');
    }

    public function createAnak()
    {
        return view('admin.anak.create');
    }

    public function ibu()
    {
        return view('admin.ibu.index');
    }

    public function ibuHamil()
    {
        return view('admin.ibu_hamil.index');
    }
    /*------------------------------------------
--------------------------------------------
All Super Admin Controller
--------------------------------------------
--------------------------------------------*/
    public function superAdminHome()
    {
        return view('admin.dashboard.super_admin');
    }
    /*------------------------------------------
--------------------------------------------
All Admin Controller
--------------------------------------------
--------------------------------------------*/
    public function adminHome()
    {
        return view('admin.dashboard.admin');
    }
    /*------------------------------------------
--------------------------------------------
All User Controller
--------------------------------------------
--------------------------------------------*/
    public function user()
    {
        $user = User::all();
        return view('admin.user.index', compact('user'));
    }

    public function storeUser(storeUserRequest $request)
    {

        try {
            $user = $this->userRepository->storeUser($request);
            return redirect()->route('super.admin.home');
        } catch (Throwable $e) {
            return redirect()->route('super.admin.home');
        }
    }
}
