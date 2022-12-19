<?php

namespace App\Http\Controllers;

use App\Repositories\Admin\User\UserRepository as UserInterface;
use App\Repositories\Admin\Anak\AnakRepository as AnakInterface;
use App\Http\Requests\Admin\User\storeUserRequest;
use App\Http\Requests\Admin\Anak\storeAnakRequest;
use App\Models\Anak;
use App\Models\DataAnak;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\User;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use App\Services\PayUService\Exception;

use function PHPUnit\Framework\isEmpty;

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

    public function getAnak()
    {
        $data = Anak::select('id', 'no_kk', 'nik', 'nama', 'nik_ortu', 'nama_ibu', 'nama_ayah', 'jk', 'tempat_lahir', 'tgl_lahir');
        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('edit', function ($data) {
                //$btn = '<a class="btn btn-warning" href="#" target="_blank">edit</a>';
                $btn = '
                <div class="dropdown">
                <button class="btn btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                   Edit
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="' . route('admin.editAnak', $data->id) . '">Edit Data Anak</a>
                    <a class="dropdown-item" href="' . route('admin.chartAnak', $data->id) . '">Grafik Data Anak</a>
                    <a class="dropdown-item" href="' . route('admin.showAnak', $data->id) . '">Show Data Anak</a>
                    <a class="dropdown-item" href="' . route('admin.dataAnak', $data->id) . '">Tambah Data Berkala Anak</a>
                    <a class="dropdown-item" href="' . route('admin.editDataAnak', $data->id) . '">Edit Berat/Tinggi Badan Anak</a>
                </div>
                </div>
                ';
                return $btn;
            })
            ->editColumn('delete', function ($data) {
                $btn = ' <button onclick="deleteItemAnak(this)" class="btn btn-danger" data-id=' . $data->id . '>Delete</button>';
                return $btn;
            })
            ->rawColumns(['edit'])
            ->rawColumns(['delete'])
            ->escapeColumns([])
            ->make(true);
    }


    public function createAnak()
    {
        $kec = Kecamatan::all();
        //$kel = Kelurahan::all();
        return view('admin.anak.create', compact('kec'));
    }

    public function getKelAnak($id)
    {
        $kel = Kelurahan::where('id_kecamatan', $id)->pluck('name', 'id');
        return response()->json($kel);
    }

    public function editAnak($id)
    {
        $anak = Anak::find($id);
        $kec = Kecamatan::all();
        $kel = Kelurahan::all();
        return view('admin.anak.edit', compact('anak', 'kec', 'kel'));
    }

    public function updateAnak(storeAnakRequest $request, $id)
    {
        try {
            $anak = $this->anakRepository->updateAnak($request, $id);
            Alert::success('Anak', 'Berhasil Mengubah Data');
            return redirect()->route('admin.anak');
        } catch (Throwable $e) {
            Alert::error('Anak', 'Gagal Mengubah Data');
            return redirect()->route('admin.anak');
        }
    }

    public function storeAnak(storeAnakRequest $request)
    {
        try {
            $anak = $this->anakRepository->storeAnak($request);
            Alert::success('Anak', 'Berhasil Menambahkan Data');
            return redirect()->route('admin.anak');
        } catch (Throwable $e) {
            Alert::error('Anak', 'Gagal Menambahkan Data');
            return redirect()->route('admin.anak');
        }
    }

    public function showAnak($id)
    {
        $anak = Anak::find($id);
        $dataAnak = DB::table('anak')
            ->join('data_anak', 'anak.id', '=', 'data_anak.id_anak')
            ->select('jk', 'bln', 'posisi', 'tb', 'bb')
            ->where('data_anak.id_anak', $id)
            ->get();
        $no = 0;
        foreach ($dataAnak as $key => $data) {
            $no++;
            $tinggi = $data->tb;
            $berat = $data->bb;
            $umur = $data->bln;
            $posisi = $data->posisi;
            if ($umur < 24 && $posisi == "H") {
                $tinggi += 0.7;
            } elseif ($umur >= 24 && $posisi == "L") {
                $tinggi -= 0.7;
            }
            $tinggi = round($tinggi);
            $var = $umur <= 24 ? 1 : 2;
            $jk = $data->jk;
            $bmi = round(10000 * $berat / pow($tinggi, 2), 2);

            $err = NULL;
            if ($bmi < 10.2 || $bmi > 21.1) {
                $err = "Nilai BMI tidak normal";
            } elseif ($tinggi < 44.2 || $tinggi > 123.9) {
                $err = "Nilai Tinggi Badan tidak normal";
            } elseif ($berat < 1.9 || $berat > 31.2) {
                $err = "Nilai Berat Badan tidak normal";
            }
            $imt_u = DB::table('z_score')
                ->select('id', 'm3sd as a1', 'm2sd as b1', '1sd as c1', '2sd as d1', '3sd as e1')
                ->where([
                    'var' => $var,
                    'acuan' => $umur,
                    'jk' => $jk,
                    'jenis_tbl' => 1,
                ])->get();
            $bb_u = DB::table('z_score')
                ->select('id', 'm3sd as a2', 'm2sd as b2', '1sd as c2')
                ->where([
                    'acuan' => $umur,
                    'jk' => $jk,
                    'jenis_tbl' => 2,
                ])->get();
            $tb_u = DB::table('z_score')
                ->select('id', 'm3sd as a3', 'm2sd as b3', '1sd as c3', '2sd as d3', '3sd as e3')
                ->where([
                    'var' => $var,
                    'acuan' => $umur,
                    'jk' => $jk,
                    'jenis_tbl' => 3,
                ])->get();
            $bt_tb = DB::table('z_score')
                ->select('id', 'm3sd as a4', 'm2sd as b4', '1sd as c4', '2sd as d4', '3sd as e4')
                ->where([
                    'var' => $var,
                    'acuan' => $tinggi,
                    'jk' => $jk,
                    'jenis_tbl' => 4,
                ])->get();
            $imt_u2 = DB::table('z_score')
                ->select('id', 'm3sd as a5', 'm2sd as b5', '1sd as c5', '2sd as d5')
                ->where([
                    'var' => $var,
                    'acuan' => $tinggi,
                    'jk' => $jk,
                    'jenis_tbl' => 5,
                ])->get();

            if ($umur<=60) {
                if ($bmi < $imt_u[0]->a1) {
                    $s1 = "Gizi buruk (severely wasted)";
                } elseif ($bmi >= $imt_u[0]->a1 && $bmi < $imt_u[0]->b1) {
                    $s1 = "Gizi kurang (wasted)";
                } elseif ($bmi >= $imt_u[0]->b1 && $bmi <= $imt_u[0]->c1) {
                    $s1 = "Gizi baik (normal)";
                }elseif ($bmi > $imt_u[0]->c1 && $bmi <= $imt_u[0]->d1) {
                    $s1 = "Berisiko gizi lebih (possible risk of overweight)";
                }elseif ($bmi > $imt_u[0]->d1 && $bmi <= $imt_u[0]->e1) {
                    $s1 = "Gizi lebih (overweight)";
                } else {
                    $s1 = "Obesitas (obese)";
                }
            }
            elseif ($umur>60) {
                if ($bmi < $imt_u[0]->a1) {
                    $s1 = "Gizi buruk (severely thinness)";
                } elseif ($bmi >= $imt_u[0]->a1 && $bmi < $imt_u[0]->b1) {
                    $s1 = "Gizi kurang (thinness)";
                } elseif ($bmi >= $imt_u[0]->b1 && $bmi <= $imt_u[0]->c1) {
                    $s1 = "Gizi baik (normal)";
                }elseif ($bmi > $imt_u[0]->c1 && $bmi <= $imt_u[0]->d1) {
                    $s1 = "Gizi lebih (overweight)";
                } else {
                    $s1 = "Obesitas (obese)";
                }
            }


            if ($berat < $bb_u[0]->a2) {
                $s2 = "Berat badan sangat kurang (severely underweight)";
            } elseif ($berat >= $bb_u[0]->a2 && $berat < $bb_u[0]->b2) {
                $s2 = "Berat badan kurang (underweight)";
            } elseif ($berat >= $bb_u[0]->b2 && $berat <= $bb_u[0]->c2) {
                $s2 = "Berat badan normal";
            } else {
                $s2 = "Risiko Berat badan lebih";
            }

            if ($tinggi < $tb_u[0]->a3) {
                $s3 = "Sangat pendek (severely stunted)";
            } elseif ($tinggi >= $tb_u[0]->a3 && $tinggi < $tb_u[0]->b3) {
                $s3 = "Pendek (stunted)";
            } elseif ($tinggi >= $tb_u[0]->b3 && $tinggi <= $tb_u[0]->e3) {
                $s3 = "Normal";
            } else {
                $s3 = "Tinggi";
            }

            if ($tinggi < $tb_u[0]->a3) {
                $s3 = "Sangat pendek (severely stunted)";
            } elseif ($tinggi >= $tb_u[0]->a3 && $tinggi < $tb_u[0]->b3) {
                $s3 = "Pendek (stunted)";
            } elseif ($tinggi >= $tb_u[0]->b3 && $tinggi <= $tb_u[0]->e3) {
                $s3 = "Normal";
            } else {
                $s3 = "Tinggi";
            }
            try {
                if ($berat < $bt_tb[0]->a4) {
                    $s4 = "Gizi buruk (severely wasted";
                } elseif ($berat >= $bt_tb[0]->a4 && $berat < $bt_tb[0]->b4) {
                    $s4 = "Gizi kurang (wasted)";
                } elseif ($berat >= $bt_tb[0]->b4 && $berat <= $bt_tb[0]->c4) {
                    $s4 = "Gizi baik (normal)";
                } elseif ($berat > $bt_tb[0]->c4 && $berat <= $bt_tb[0]->d4) {
                    $s4 = "Berisiko gizi lebih (possible risk of overweight)";
                } elseif ($berat > $bt_tb[0]->d4 && $berat <= $bt_tb[0]->e4) {
                    $s4 = "Gizi lebih (overweight)";
                } else {
                    $s4 = "Obesitas (obese)";
                }
            } catch (\Exception $e) {
                // dump('culprit : '.$key.', Error : '.$e->getMessage());
                $s4 = $key;
                continue;
            }
            // if ($berat < $bt_tb[0]->a4) {
            //     $s4 = "Sangat Kurus";
            // } elseif ($berat >= $bt_tb[0]->a4 && $berat < $bt_tb[0]->b4) {
            //     $s4 = "Kurus";
            // } elseif ($berat >= $bt_tb[0]->b4 && $berat <= $bt_tb[0]->c4) {
            //     $s4 = "Normal";
            // } else {
            //     $s4 = "Gemuk";
            // }

            $hasilx[$key] = array(
                "bln" => $umur,
                "tinggi" => $tinggi,
                "berat" => $berat,
                "imt" => $s1,
                "bb" => $s2,
                "tb" => $s3,
                "bt" => $s4
            );
        }
        return view('admin.anak.show', compact('anak'))->with('hasilx', $hasilx);
    }


    public function chartAnak($id)
    {
        $anak = Anak::find($id);
        return view('admin.anak.chart', compact('anak'));
    }

    public function getChartAnak($id)
    {
        $tbAnak = DB::table('anak')
            ->join('data_anak', 'anak.id', '=', 'data_anak.id_anak')
            ->select('tb')
            ->where('data_anak.id_anak', $id)
            ->get();

        $blnAnak = DB::table('anak')
            ->join('data_anak', 'anak.id', '=', 'data_anak.id_anak')
            ->select('bln')
            ->where('data_anak.id_anak', $id)
            ->get();

        $bbAnak = DB::table('anak')
            ->join('data_anak', 'anak.id', '=', 'data_anak.id_anak')
            ->select('bb')
            ->where('data_anak.id_anak', $id)
            ->get();

        return response()->json([
            'tb' => $tbAnak,
            'bln' => $blnAnak,
            'bb' => $bbAnak,

        ]);
    }

    public function destroyAnak($id)
    {
        $this->anakRepository->destroyAnak($id);
        return response()->json([
            'success' => true
        ]);
    }

    public function dataAnak($id)
    {
        $anak = Anak::find($id);
        $query = DB::table('data_anak')->where('id_anak', $id)->max('bln');
        // $query === NULL ? $bulanSekarang = 0 : $bulanSekarang = $query + 1;
        $bulanSekarang = $query + 1;
        return view('admin.anak.data-anak', compact('anak', 'bulanSekarang'));
    }

    public function storeDataAnak(Request $request)
    {
        try {
            $this->anakRepository->storeDataAnak($request);
            return redirect()->route('admin.anak');
            Alert::success('Data Anak', 'Berhasil Menambahkan Data');
        } catch (Throwable $e) {
            return redirect()->route('admin.anak');
            Alert::error('Data Anak', 'Berhasil Menambahkan Data');
        }
    }

    public function editDataAnak($id)
    {
        $anak = Anak::find($id);
        $dataAnak = DataAnak::where('id_anak',$id)->get();
        return view('admin.anak.edit-data-anak', compact('anak','dataAnak'));
    }

    public function updateDataAnak(Request $request,$id)
    {
        try {
            $this->anakRepository->updateDataAnak($request, $id);
            Alert::success('Anak', 'Berhasil Mengubah Data Berkala Anak');
            return redirect()->route('admin.anak');
        } catch (Throwable $e) {
            Alert::error('Anak', 'Gagal Menagubah Data Berkala Anak');
            return redirect()->route('admin.anak');
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
            return redirect()->route('super.admin.user');
        } catch (Throwable $e) {
            return redirect()->route('super.admin.user');
        }
    }
    public function updateUser(storeUserRequest $request, $id)
    {
        try {
            $user = $this->userRepository->updateUser($request, $id);
            return redirect()->route('super.admin.user');
        } catch (Throwable $e) {
            return redirect()->route('super.admin.user');
        }
    }
    public function destroyUser($id)
    {
        try {
            $user = $this->userRepository->destroyUser($id);
            return redirect()->route('super.admin.user');
        } catch (Throwable $e) {
            return redirect()->route('super.admin.user');
        }
    }
}
