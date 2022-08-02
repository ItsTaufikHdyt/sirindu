<?php

namespace App\Http\Controllers;

use App\Repositories\Admin\User\UserRepository as UserInterface;
use App\Repositories\Admin\Anak\AnakRepository as AnakInterface;
use App\Http\Requests\Admin\User\storeUserRequest;
use App\Http\Requests\Admin\Anak\storeAnakRequest;
use App\Models\Anak;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\User;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $userRepository;
    protected $anakRepository;

    public function __construct(
        UserInterface $userRepository,
        AnakInterface $anakRepository
    ) {
        $this->middleware('auth');
        $this->userRepository = $userRepository;
        $this->anakRepository = $anakRepository;
    }

    /*------------------------------------------
--------------------------------------------
ANAK
--------------------------------------------
--------------------------------------------*/

    public function anak()
    {
        return view('admin.anak.index');
    }

    public function createAnak()
    {
        $kec = Kecamatan::all();
        $kel = Kelurahan::all();
        return view('admin.anak.create', compact('kec', 'kel'));
    }

    public function storeAnak(storeAnakRequest $request)
    {
        try {
            $anak = $this->anakRepository->storeAnak($request);
            return view('admin.anak.index');
        } catch (Throwable $e) {
            return view('admin.anak.index');
        }
    }

    /*------------------------------------------
--------------------------------------------
IBU
--------------------------------------------
--------------------------------------------*/
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
