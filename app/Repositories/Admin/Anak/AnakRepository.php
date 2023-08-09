<?php

namespace App\Repositories\Admin\Anak;

use App\Repositories\Admin\Core\Anak\AnakRepositoryInterface;
use App\Models\Anak;
use App\Models\User;
use App\Models\DataAnak;
use App\Models\Imunisasi;
use GuzzleHttp\Promise\Create;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isEmpty;

class AnakRepository implements AnakRepositoryInterface
{
    protected $anak;

    public function __contruct(
        anak $anak
    ) {
        $this->anak = $anak;
    }

    public function storeAnak($request)
    {
        $lahir = strtotime($request->tgl_lahir);
        $now = strtotime($request->tgl_kunjungan);
        $y1 = date('Y', $lahir);
        $y2 = date('Y', $now);
        $m1 = date('m', $lahir);
        $m2 = date('m', $now);
        $umur = (($y2 - $y1) * 12) + ($m2 - $m1);

        $anak_baru = Anak::create([
            'no_kk' => $request->no_kk,
            'nik' => $request->nik,
            'nama' => $request->nama,
            'nik_ortu' => $request->nik_ortu,
            'nama_ibu' => $request->nama_ibu,
            'nama_ayah' => $request->nama_ayah,
            'jk' => $request->jk,
            'tempat_lahir' => $request->tempat_lahir,
            'tgl_lahir' => $request->tgl_lahir,
            'golda' => $request->golda,
            'anak' => $request->anak,
            'no' => $request->no,
            'status' => 1,
            'id_kec' => $request->id_kec,
            'id_kel' => $request->id_kel,
            'id_rt' => $request->id_rt,
            'id_posyandu' => $request->id_posyandu,
            'id_puskesmas' => $request->id_puskesmas,
            'catatan' => $request->catatan,
            'alamat' => $request->alamat,
        ]);

        DataAnak::create([
            'id_anak' => $anak_baru->id,
            'bln' => $umur,
            'posisi' => 'L',
            'tb' => $request->tb,
            'bb' => $request->bb,
            'lla' => $request->lla,
            'lk' => $request->lk,
            'ntob' => null,
            'asi' => $request->asi,
            'tgl_kunjungan' => $request->tgl_kunjungan,
            'obat_cacing' => $request->obat_cacing,
            'ddtka' => $request->ddtka,
            'id_user' => Auth::user()->id,
        ]);
    }

    public function updateAnak($request, $id)
    {
        $lahir = strtotime($request->tgl_lahir);
        $now = strtotime($request->tgl_kunjungan);
        $y1 = date('Y', $lahir);
        $y2 = date('Y', $now);
        $m1 = date('m', $lahir);
        $m2 = date('m', $now);
        $umur = (($y2 - $y1) * 12) + ($m2 - $m1);
        $anak = Anak::find($id);
        $dt = DataAnak::where('id_anak', $id)->first();
        if ($request->id_kec == null) {
            $anak->update([
                'no_kk' => $request->no_kk,
                'nik' => $request->nik,
                'nama' => $request->nama,
                'nik_ortu' => $request->nik_ortu,
                'nama_ibu' => $request->nama_ibu,
                'nama_ayah' => $request->nama_ayah,
                'jk' => $request->jk,
                'tempat_lahir' => $request->tempat_lahir,
                'tgl_lahir' => $request->tgl_lahir,
                'golda' => $request->golda,
                'anak' => $request->anak,
                'no' => $request->no,
                'status' => $request->status,
                'id_kec' => $anak->id_kec,
                'id_kel' => $anak->id_kel,
                'id_rt' => $anak->id_rt,
                'id_posyandu' => $anak->id_posyandu,
                'id_puskesmas' => $anak->id_puskesmas,
                'catatan' => $request->catatan,
                'alamat' => $request->alamat
            ]);
            $dt->update([
                'bln' => $umur,
                'posisi' => 'L',
                'tb' => $request->tb,
                'bb' => $request->bb,
                'lla' => $request->lla,
                'lk' => $request->lk,
                'ntob' => null,
                'asi' => $request->asi,
                'tgl_kunjungan' => $request->tgl_kunjungan,
                'obat_cacing' => $request->obat_cacing,
                'ddtka' => $request->ddtka,
                'id_user' => Auth::user()->id,
            ]);
        } else {
            $anak->update([
                'no_kk' => $request->no_kk,
                'nik' => $request->nik,
                'nama' => $request->nama,
                'nik_ortu' => $request->nik_ortu,
                'nama_ibu' => $request->nama_ibu,
                'nama_ayah' => $request->nama_ayah,
                'jk' => $request->jk,
                'tempat_lahir' => $request->tempat_lahir,
                'tgl_lahir' => $request->tgl_lahir,
                'golda' => $request->golda,
                'anak' => $request->anak,
                'no' => $request->no,
                'status' => $request->status,
                'id_kec' => $request->id_kec,
                'id_kel' => $request->id_kel,
                'id_rt' => $request->id_rt,
                'id_posyandu' => $request->id_posyandu,
                'id_puskesmas' => $request->id_puskesmas,
                'catatan' => $request->catatan,
                'alamat' => $request->alamat
            ]);
            $dt->update([
                'bln' => $umur,
                'posisi' => 'L',
                'tb' => $request->tb,
                'bb' => $request->bb,
                'lla' => $request->lla,
                'lk' => $request->lk,
                'ntob' => null,
                'asi' => $request->asi,
                'tgl_kunjungan' => $request->tgl_kunjungan,
                'obat_cacing' => $request->obat_cacing,
                'ddtka' => $request->ddtka,
                'id_user' => Auth::user()->id,
            ]);
        }
    }

    public function destroyAnak($id)
    {
        try {
            $anak = Anak::find($id);
            $anak->delete();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function storeDataAnak($request)
    {
        $anak = DataAnak::create([
            'id_anak' => $request->id_anak,
            'tgl_kunjungan' => $request->tgl_kunjungan,
            'bln' => $request->bln,
            'posisi' => $request->posisi,
            'tb' => $request->tb,
            'bb' => $request->bb,
            'lla' => $request->lla,
            'lk' => $request->lk,
            'ntob' => null,
            'asi' => $request->asi,
            'vit_a' => $request->vit_a,
            'obat_cacing' => $request->obat_cacing,
            'ddtka' => $request->ddtka,
            'id_user' => Auth::user()->id,
        ]);
    }

    public function updateImunisasi($request, $id)
    {
        $dataImunisasi = Anak::find($id);
        $dataImunisasi->update([
            'hbo' => $request->hbo,
            'bcg' => $request->bcg,
            'polio1' => $request->polio1,
            'dpthb_hib1' => $request->dpthb_hib1,
            'polio2' => $request->polio2,
            'dpthb_hib2' => $request->dpthb_hib2,
            'polio3' => $request->polio3,
            'dpthb_hib3' => $request->dpthb_hib3,
            'polio4' => $request->polio4,
            'campak' => $request->campak
        ]);
    }

    public function updateDataAnak($request, $id)
    {
        $dataAnak = DataAnak::find($id);
        $dataAnak->update([
            'posisi' => $request->posisi,
            'tb' => $request->tb,
            'bb' => $request->bb,
            'lla' => $request->lla,
            'lk' => $request->lk,
            'ntob' => null,
            'asi' => $request->asi,
            'vit_a' => $request->vit_a,
            'tgl_kunjungan' => $request->tgl_kunjungan,
            'obat_cacing' => $request->obat_cacing,
            'ddtka' => $request->ddtka,
            'id_user' => Auth::user()->id,
        ]);
    }
}
