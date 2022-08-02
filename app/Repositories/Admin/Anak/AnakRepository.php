<?php

namespace App\Repositories\Admin\Anak;

use App\Repositories\Admin\Core\Anak\AnakRepositoryInterface;
use App\Models\Anak;

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
        $anak = Anak::create([
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
}
