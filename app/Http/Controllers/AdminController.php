<?php

namespace App\Http\Controllers;

use App\Exports\AllExport;
use App\Repositories\Admin\User\UserRepository as UserInterface;
use App\Repositories\Admin\Anak\AnakRepository as AnakInterface;
use App\Http\Requests\Admin\User\storeUserRequest;
use App\Http\Requests\Admin\Anak\storeAnakRequest;
use App\Http\Requests\Admin\Anak\updateAnakRequest;
use App\Models\Anak;
use App\Models\DataAnak;
use App\Models\Imunisasi;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Posyandu;
use App\Models\Puskesmas;
use App\Models\Rt;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Exports\AnakExport;
use App\Models\AllData;
use Maatwebsite\Excel\Facades\Excel;
use Rap2hpoutre\FastExcel\FastExcel;


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
                    <a class="dropdown-item" href="' . route('admin.dataImunisasi', $data->id) . '">Data Imunisasi Anak</a>
                </div>
                </div>
                ';
                return $btn;
            })
            ->setRowId('id')
            ->editColumn('delete', function ($data) {
                $btn = ' <button onclick="deleteItemAnak(this)" class="btn btn-danger" data-id=' . $data->id . '>Delete</button>';
                return $btn;
            })
            ->rawColumns(['edit'])
            ->rawColumns(['delete'])
            ->escapeColumns([])
            ->make(true);
    }

    public function getAnakAdmin()
    {
        $data = Anak::select('id', 'no_kk', 'nik', 'nama', 'nik_ortu', 'nama_ibu', 'nama_ayah', 'jk', 'tempat_lahir', 'tgl_lahir')
        ->where('id_puskesmas',Auth::user()->id_puskesmas);
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
                    <a class="dropdown-item" href="' . route('admin.dataImunisasi', $data->id) . '">Data Imunisasi Anak</a>
                </div>
                </div>
                ';
                return $btn;
            })
            ->setRowId('id')
            ->editColumn('delete', function ($data) {
                $btn = ' <button onclick="deleteItemAnak(this)" class="btn btn-danger" data-id=' . $data->id . '>Delete</button>';
                return $btn;
            })
            ->rawColumns(['edit'])
            ->rawColumns(['delete'])
            ->escapeColumns([])
            ->make(true);
    }

    public function getAnakPosyandu()
    {
        $data = Anak::select('id', 'no_kk', 'nik', 'nama', 'nik_ortu', 'nama_ibu', 'nama_ayah', 'jk', 'tempat_lahir', 'tgl_lahir')
        ->where('id_posyandu',Auth::user()->id_posyandu);
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
                    <a class="dropdown-item" href="' . route('admin.dataImunisasi', $data->id) . '">Data Imunisasi Anak</a>
                </div>
                </div>
                ';
                return $btn;
            })
            ->setRowId('id')
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

    public function getPuskesmasAnak($id)
    {
        $puskesmas = Puskesmas::where('id_kecamatan', $id)->pluck('name', 'id');
        return response()->json($puskesmas);
    }

    public function getKelAnak($id)
    {
        $kel = Kelurahan::where('id_kecamatan', $id)->pluck('name', 'id');
        return response()->json($kel);
    }

    public function getRtAnak($id)
    {
        $rt = Rt::where('id_kelurahan', $id)->pluck('name', 'id', 'id_posyandu');
        return response()->json($rt);
    }
    public function getRtAnakPosyandu($id)
    {
        $rt = Rt::where('id', $id)->pluck('id_posyandu');
        return response()->json($rt);
    }

    // public function getRtAnak($id)
    // {
    //     $rt = Rt::where('id_posyandu', $id)->pluck('name', 'id');
    //     return response()->json($rt);
    // }
    
    public function getPosyanduAnak($id)
    {
        $posyandu = Posyandu::where('id', $id)->pluck('name', 'id');
        return response()->json($posyandu);
    }
    // public function getPosyanduAnak($id)
    // {
    //     $posyandu = Posyandu::where('id_puskesmas', $id)->pluck('name', 'id');
    //     return response()->json($posyandu);
    // }

    public function editAnak($id)
    {
        $anak = Anak::find($id);
        $kec = Kecamatan::all();
        $kel = Kelurahan::all();
        $dt = DataAnak::where('id_anak', $id)->first();
        $dataAnak = DataAnak::where('id_anak', $id)->get();
        return view('admin.anak.edit', compact('anak', 'kec', 'kel', 'dt', 'dataAnak'));
    }

    public function updateAnak(Request $request, $id)
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
            ->select('jk','tgl_kunjungan', 'bln', 'posisi', 'tb', 'bb')
            ->where('data_anak.id_anak', $id)
            ->get();
        dd($dataAnak);
        $hasilx = getZscore($dataAnak);
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

    public function updateDataAnak(Request $request, $id)
    {
        try {
            $this->anakRepository->updateDataAnak($request, $id);
            Alert::success('Anak', 'Berhasil Mengubah Data Berkala Anak');
            return redirect()->route('admin.anak');
        } catch (Throwable $e) {
            Alert::error('Anak', 'Gagal Mengubah Data Berkala Anak');
            return redirect()->route('admin.anak');
        }
    }

    public function dataImunisasi($id)
    {
        $data = Anak::find($id);
        return view('admin.anak.data-imunisasi', compact('data'));
    }

    public function updateImunisasi(Request $request, $id)
    {
        try {
            $this->anakRepository->updateImunisasi($request, $id);
            Alert::success('Anak', 'Berhasil Menambahkan Data Imunisasi');
            return redirect()->route('admin.anak');
        } catch (Throwable $e) {
            Alert::error('Anak', 'Berhasil Menambahkan Data Imunisasi');
            return redirect()->route('admin.anak');
        }
    }

    public function exportView()
    {
        $kec = Kecamatan::all();
        return view('admin.anak.export', compact('kec'));
    }

    public function formViewExport(Request $request)
    {
        return Excel::download(new AnakExport($request), 'data-anak.xlsx');
        // $from_date = $request->from_date;
        // $to_date = $request->to_date;
        // $kec = $request->id_kec;
        // $kel = $request->id_kel;
        // $rt = $request->id_rt;
        // $puskesmas = $request->id_puskesmas;
        // $posyandu = $request->id_posyandu;
        // if ($request->from_date != '' && $request->to_date != '') {
        //     if ($request->id_kec !== "0" && $request->id_kec !== null) {

        //         if ($request->id_puskesmas !== "0" && $request->id_puskesmas !== null) {
        //             $export = DB::table('alldata')->whereBetween('tgl_kunjungan', array($request->from_date, $request->to_date))
        //                 ->where('idKec', $kec)->where('idPuskes', $puskesmas)
        //                 ->get();
        //             return view('admin.anak.export.view', compact('export'));
        //             if ($request->id_posyandu !== "0" && $request->id_posyandu !== null) {
        //                 $export = DB::table('alldata')->whereBetween('tgl_kunjungan', array($request->from_date, $request->to_date))
        //                     ->where('idKec', $kec)->where('idPuskes', $puskesmas)->where('idPos', $posyandu)
        //                     ->get();
        //                 return view('admin.anak.export.view', compact('export'));
        //             }
        //         } elseif ($request->id_kelurahan !== "0" && $request->id_kelurahan !== null) {
        //             $export = DB::table('alldata')->whereBetween('tgl_kunjungan', array($request->from_date, $request->to_date))
        //                 ->where('idKec', $kec)->where('idKel', $kel)
        //                 ->get();
        //             return view('admin.anak.export.view', compact('export'));
        //             if ($request->id_rt !== "0" && $request->id_rt !== null) {
        //                 $export = DB::table('alldata')->whereBetween('tgl_kunjungan', array($request->from_date, $request->to_date))
        //                     ->where('idKec', $kec)->where('idKel', $kel)->where('idRt', $rt)
        //                     ->get();
        //                 return view('admin.anak.export.view', compact('export'));
        //             }
        //         } else {
        //             $export = DB::table('alldata')->whereBetween('tgl_kunjungan', array($request->from_date, $request->to_date))->where('idKec', $kec)->get();
        //             return view('admin.anak.export.view', compact('export'));
        //         }
        //     }
        // } else {
        //     $export = DB::table('alldata')->whereBetween('tgl_kunjungan', array($request->from_date, $request->to_date))->get();
        //     return view('admin.anak.export.view', compact('export'));
        // }
    }

    public function formViewExportExcel()
    {
        //return Excel::download(new AnakExport(), 'data-anak.xlsx');
    }

    public function exportExcel(Request $request)
    {
        //return Excel::download(new AnakExport($request), 'data-anak.xlsx');
        // if ($request->id_kec !== "0" && $request->id_kec !== null) {
        //     if ($request->id_puskesmas !== "0" && $request->id_puskesmas !== null) {
        //         return (new FastExcel(AllData::where('idKec', $request->id_kec)
        //             ->where('idPuskes', $request->id_puskesmas)
        //             ->get()))->download(
        //             'all-data-anak.xlsx',
        //             function ($data) {
        //                 return [
        //                     'No KK' => $data->no_kk,
        //                     'NIK' => $data->nik,
        //                     'Nama' => $data->nama,
        //                     'Nik Orang Tua' => $data->nik_ortu,
        //                     'Nama Ibu' => $data->nama_ibu,
        //                     'Nama Ayah' => $data->nama_ayah,
        //                     'Jenis Kelamin' => $data->jk,
        //                     'Tempat Lahir' => $data->tempat_lahir,
        //                     'Tanggal Lahir' => $data->tgl_lahir,
        //                     'Golongan Darah' => $data->golda,
        //                     'Anak Ke-' => $data->anak,
        //                     'Catatan' => $data->catatan,
        //                     'hbo' => $data->hbo,
        //                     'bcg' => $data->bcg,
        //                     'polio1' => $data->polio1,
        //                     'dpthb_hib1' => $data->dpthb_hib1,
        //                     'polio2' => $data->polio2,
        //                     'dpthb_hib2' => $data->dpthb_hib2,
        //                     'polio3' => $data->polio3,
        //                     'dpthb_hib3' => $data->dpthb_hib3,
        //                     'polio4' => $data->polio4,
        //                     'campak' => $data->campak,
        //                     'Kecamatan' => $data->nameKec,
        //                     'Kelurahan' => $data->nameKel,
        //                     'Puskesmas' => $data->namePuskes,
        //                     'Posyandu' => $data->namePos,
        //                     'RT' => $data->nameRt,
        //                     'Bulan' => $data->bln,
        //                     'Posisi' => $data->posisi,
        //                     'Tinggi Badan' => $data->tb,
        //                     'Berat Badan' => $data->bb,
        //                     'BMI' => round(10000 * $data->bb / pow($data->tb, 2), 2),
        //                     'Lingkar Lengan Atas' => $data->lla,
        //                     'Lingkar Kepala' => $data->lk,
        //                     'NTOB' => $data->ntob,
        //                     'ASI' => $data->asi,
        //                     'Vitamin A' => $data->vit_a,
        //                     'Nama Petugas' => $data->namaPetugas,
        //                 ];
        //             },
        //         );

        //         if ($request->id_posyandu !== "0" && $request->id_posyandu !== null) {
        //             return (new FastExcel(
        //                 AllData::where('idKec', $request->id_kec)
        //                     ->where('idPuskes', $request->id_puskesmas)
        //                     ->where('idPos', $request->id_posyandu)->get()
        //             ))->download(
        //                 'all-data-anak.xlsx',
        //                 function ($data) {
        //                     return [
        //                         'No KK' => $data->no_kk,
        //                         'NIK' => $data->nik,
        //                         'Nama' => $data->nama,
        //                         'Nik Orang Tua' => $data->nik_ortu,
        //                         'Nama Ibu' => $data->nama_ibu,
        //                         'Nama Ayah' => $data->nama_ayah,
        //                         'Jenis Kelamin' => $data->jk,
        //                         'Tempat Lahir' => $data->tempat_lahir,
        //                         'Tanggal Lahir' => $data->tgl_lahir,
        //                         'Golongan Darah' => $data->golda,
        //                         'Anak Ke-' => $data->anak,
        //                         'Catatan' => $data->catatan,
        //                         'hbo' => $data->hbo,
        //                         'bcg' => $data->bcg,
        //                         'polio1' => $data->polio1,
        //                         'dpthb_hib1' => $data->dpthb_hib1,
        //                         'polio2' => $data->polio2,
        //                         'dpthb_hib2' => $data->dpthb_hib2,
        //                         'polio3' => $data->polio3,
        //                         'dpthb_hib3' => $data->dpthb_hib3,
        //                         'polio4' => $data->polio4,
        //                         'campak' => $data->campak,
        //                         'Kecamatan' => $data->nameKec,
        //                         'Kelurahan' => $data->nameKel,
        //                         'Puskesmas' => $data->namePuskes,
        //                         'Posyandu' => $data->namePos,
        //                         'RT' => $data->nameRt,
        //                         'Bulan' => $data->bln,
        //                         'Posisi' => $data->posisi,
        //                         'Tinggi Badan' => $data->tb,
        //                         'Berat Badan' => $data->bb,
        //                         'BMI' => round(10000 * $data->bb / pow($data->tb, 2), 2),
        //                         'Lingkar Lengan Atas' => $data->lla,
        //                         'Lingkar Kepala' => $data->lk,
        //                         'NTOB' => $data->ntob,
        //                         'ASI' => $data->asi,
        //                         'Vitamin A' => $data->vit_a,
        //                         'Nama Petugas' => $data->namaPetugas,
        //                     ];
        //                 },
        //             );
        //         }
        //     } elseif ($request->id_kelurahan !== "0" && $request->id_kelurahan !== null) {
        //         return (new FastExcel(AllData::where('idKec', $request->id_kec)
        //             ->where('idKel', $request->id_kel)
        //             ->get()))->download(
        //             'all-data-anak.xlsx',
        //             function ($data) {
        //                 return [
        //                     'No KK' => $data->no_kk,
        //                     'NIK' => $data->nik,
        //                     'Nama' => $data->nama,
        //                     'Nik Orang Tua' => $data->nik_ortu,
        //                     'Nama Ibu' => $data->nama_ibu,
        //                     'Nama Ayah' => $data->nama_ayah,
        //                     'Jenis Kelamin' => $data->jk,
        //                     'Tempat Lahir' => $data->tempat_lahir,
        //                     'Tanggal Lahir' => $data->tgl_lahir,
        //                     'Golongan Darah' => $data->golda,
        //                     'Anak Ke-' => $data->anak,
        //                     'Catatan' => $data->catatan,
        //                     'hbo' => $data->hbo,
        //                     'bcg' => $data->bcg,
        //                     'polio1' => $data->polio1,
        //                     'dpthb_hib1' => $data->dpthb_hib1,
        //                     'polio2' => $data->polio2,
        //                     'dpthb_hib2' => $data->dpthb_hib2,
        //                     'polio3' => $data->polio3,
        //                     'dpthb_hib3' => $data->dpthb_hib3,
        //                     'polio4' => $data->polio4,
        //                     'campak' => $data->campak,
        //                     'Kecamatan' => $data->nameKec,
        //                     'Kelurahan' => $data->nameKel,
        //                     'Puskesmas' => $data->namePuskes,
        //                     'Posyandu' => $data->namePos,
        //                     'RT' => $data->nameRt,
        //                     'Bulan' => $data->bln,
        //                     'Posisi' => $data->posisi,
        //                     'Tinggi Badan' => $data->tb,
        //                     'Berat Badan' => $data->bb,
        //                     'BMI' => round(10000 * $data->bb / pow($data->tb, 2), 2),
        //                     'Lingkar Lengan Atas' => $data->lla,
        //                     'Lingkar Kepala' => $data->lk,
        //                     'NTOB' => $data->ntob,
        //                     'ASI' => $data->asi,
        //                     'Vitamin A' => $data->vit_a,
        //                     'Nama Petugas' => $data->namaPetugas,
        //                 ];
        //             },
        //         );

        //         if ($request->id_rt !== "0" && $request->id_rt !== null) {
        //             return (new FastExcel(
        //                 AllData::where('idKec', $request->id_kec)
        //                     ->where('idKel', $request->id_kel)
        //                     ->where('idRt', $request->id_rt)->get()
        //             ))->download(
        //                 'all-data-anak.xlsx',
        //                 function ($data) {
        //                     return [
        //                         'No KK' => $data->no_kk,
        //                         'NIK' => $data->nik,
        //                         'Nama' => $data->nama,
        //                         'Nik Orang Tua' => $data->nik_ortu,
        //                         'Nama Ibu' => $data->nama_ibu,
        //                         'Nama Ayah' => $data->nama_ayah,
        //                         'Jenis Kelamin' => $data->jk,
        //                         'Tempat Lahir' => $data->tempat_lahir,
        //                         'Tanggal Lahir' => $data->tgl_lahir,
        //                         'Golongan Darah' => $data->golda,
        //                         'Anak Ke-' => $data->anak,
        //                         'Catatan' => $data->catatan,
        //                         'hbo' => $data->hbo,
        //                         'bcg' => $data->bcg,
        //                         'polio1' => $data->polio1,
        //                         'dpthb_hib1' => $data->dpthb_hib1,
        //                         'polio2' => $data->polio2,
        //                         'dpthb_hib2' => $data->dpthb_hib2,
        //                         'polio3' => $data->polio3,
        //                         'dpthb_hib3' => $data->dpthb_hib3,
        //                         'polio4' => $data->polio4,
        //                         'campak' => $data->campak,
        //                         'Kecamatan' => $data->nameKec,
        //                         'Kelurahan' => $data->nameKel,
        //                         'Puskesmas' => $data->namePuskes,
        //                         'Posyandu' => $data->namePos,
        //                         'RT' => $data->nameRt,
        //                         'Bulan' => $data->bln,
        //                         'Posisi' => $data->posisi,
        //                         'Tinggi Badan' => $data->tb,
        //                         'Berat Badan' => $data->bb,
        //                         'BMI' => round(10000 * $data->bb / pow($data->tb, 2), 2),
        //                         'Lingkar Lengan Atas' => $data->lla,
        //                         'Lingkar Kepala' => $data->lk,
        //                         'NTOB' => $data->ntob,
        //                         'ASI' => $data->asi,
        //                         'Vitamin A' => $data->vit_a,
        //                         'Nama Petugas' => $data->namaPetugas,
        //                     ];
        //                 },
        //             );
        //         }
        //     } else {
        //         return (new FastExcel(AllData::where('idKec', $request->id_kec)->get()))->download(
        //             'all-data-anak.xlsx',
        //             function ($data) {
        //                 return [
        //                     'No KK' => $data->no_kk,
        //                     'NIK' => $data->nik,
        //                     'Nama' => $data->nama,
        //                     'Nik Orang Tua' => $data->nik_ortu,
        //                     'Nama Ibu' => $data->nama_ibu,
        //                     'Nama Ayah' => $data->nama_ayah,
        //                     'Jenis Kelamin' => $data->jk,
        //                     'Tempat Lahir' => $data->tempat_lahir,
        //                     'Tanggal Lahir' => $data->tgl_lahir,
        //                     'Golongan Darah' => $data->golda,
        //                     'Anak Ke-' => $data->anak,
        //                     'Catatan' => $data->catatan,
        //                     'hbo' => $data->hbo,
        //                     'bcg' => $data->bcg,
        //                     'polio1' => $data->polio1,
        //                     'dpthb_hib1' => $data->dpthb_hib1,
        //                     'polio2' => $data->polio2,
        //                     'dpthb_hib2' => $data->dpthb_hib2,
        //                     'polio3' => $data->polio3,
        //                     'dpthb_hib3' => $data->dpthb_hib3,
        //                     'polio4' => $data->polio4,
        //                     'campak' => $data->campak,
        //                     'Kecamatan' => $data->nameKec,
        //                     'Kelurahan' => $data->nameKel,
        //                     'Puskesmas' => $data->namePuskes,
        //                     'Posyandu' => $data->namePos,
        //                     'RT' => $data->nameRt,
        //                     'Bulan' => $data->bln,
        //                     'Posisi' => $data->posisi,
        //                     'Tinggi Badan' => $data->tb,
        //                     'Berat Badan' => $data->bb,
        //                     'BMI' => round(10000 * $data->bb / pow($data->tb, 2), 2),
        //                     'Lingkar Lengan Atas' => $data->lla,
        //                     'Lingkar Kepala' => $data->lk,
        //                     'NTOB' => $data->ntob,
        //                     'ASI' => $data->asi,
        //                     'Vitamin A' => $data->vit_a,
        //                     'Nama Petugas' => $data->namaPetugas,
        //                 ];
        //             },
        //         );
        //     }
        // }
    }

    public function exportAllExcel()
    {
        //return Excel::download(new AllExport, 'all-data-anak.xlsx');
        // $datax= AllData::all();
        return (new FastExcel(AllData::all()))->download(
            'all-data-anak.xlsx',
            function ($data) {
                return [
                    'No KK' => $data->no_kk,
                    'NIK' => $data->nik,
                    'Nama' => $data->nama,
                    'Nik Orang Tua' => $data->nik_ortu,
                    'Nama Ibu' => $data->nama_ibu,
                    'Nama Ayah' => $data->nama_ayah,
                    'Jenis Kelamin' => $data->jk,
                    'Tempat Lahir' => $data->tempat_lahir,
                    'Tanggal Lahir' => $data->tgl_lahir,
                    'Golongan Darah' => $data->golda,
                    'Anak Ke-' => $data->anak,
                    'Catatan' => $data->catatan,
                    'hbo' => $data->hbo,
                    'bcg' => $data->bcg,
                    'polio1' => $data->polio1,
                    'dpthb_hib1' => $data->dpthb_hib1,
                    'polio2' => $data->polio2,
                    'dpthb_hib2' => $data->dpthb_hib2,
                    'polio3' => $data->polio3,
                    'dpthb_hib3' => $data->dpthb_hib3,
                    'polio4' => $data->polio4,
                    'campak' => $data->campak,
                    'Kecamatan' => $data->nameKec,
                    'Kelurahan' => $data->nameKel,
                    'Puskesmas' => $data->namePuskes,
                    'Posyandu' => $data->namePos,
                    'RT' => $data->nameRt,
                    'Tanggal Kunjungan' => $data->tgl_kunjungan,
                    'Bulan' => $data->bln,
                    'Posisi' => $data->posisi,
                    'Tinggi Badan' => $data->tb,
                    'Berat Badan' => $data->bb,
                    'BMI' => round(10000 * $data->bb / pow($data->tb, 2), 2),
                    // 'BB/U' => z_score($data->bb, $data->tb, $data->bln, $data->posisi, $data->jk),
                    'Lingkar Lengan Atas' => $data->lla,
                    'Lingkar Kepala' => $data->lk,
                    'NTOB' => $data->ntob,
                    'ASI' => $data->asi,
                    'Vitamin A' => $data->vit_a,
                    'Nama Petugas' => $data->namaPetugas,
                ];
            },
        );
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
All Admin Posyandu Controller
--------------------------------------------
--------------------------------------------*/
    public function adminPosyanduHome()
    {
        return view('admin.dashboard.posyandu');
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
        $kec = Kecamatan::all();
        return view('admin.user.index', compact('user', 'kec'));
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

    public function editUser($id)
    {
        $user = User::find($id);
        $kec = Kecamatan::all();
        return view('admin.user.edit', compact('user', 'kec'));
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
