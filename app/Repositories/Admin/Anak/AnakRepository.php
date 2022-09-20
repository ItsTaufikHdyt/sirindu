<?php

namespace App\Repositories\Admin\Anak;

use App\Repositories\Admin\Core\Anak\AnakRepositoryInterface;
use App\Models\Anak;
use App\Models\DataAnak;
use GuzzleHttp\Promise\Create;
use Illuminate\Support\Facades\DB;

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
            'id_kec' => $request->id_kec,
            'id_kel' => $request->id_kel,
            'rt' => $request->rt,
            'rw' => $request->rw,
            'catatan' => $request->catatan,
        ]);
           
        DataAnak::create([
            'id_anak' => $anak_baru->id,
            'bln' => 0,
            'posisi' => 'L',
            'tb' => $request->tb,
            'bb' => $request->bb,
        ]);
    }

    public function updateAnak($request, $id)
    {
        $anak = Anak::find($id);
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
            'id_kec' => $request->id_kec,
            'id_kel' => $request->id_kel,
            'rt' => $request->rt,
            'rw' => $request->rw,
            'catatan' => $request->catatan,
        ]);
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
            'bln' => $request->bln,
            'posisi' => $request->posisi,
            'tb' => $request->tb,
            'bb' => $request->bb,
        ]);
    }


}
