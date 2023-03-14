<?php

namespace App\Exports;

use App\Models\AllData;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;

class AnakExport implements FromQuery
{
    protected $req;

    function __construct($req)
    {
        $this->req = $req;
    }


    public function query()
    {
        // dd($this->req);
        if ($this->req->id_kec!=="0" && $this->req->id_kec !== null) {
 
            if ($this->req->id_puskesmas!=="0" && $this->req->id_puskesmas !== null) {
                return AllData::query()
                ->where('idKec',$this->req->id_kec)
                ->where('idPuskes',$this->req->id_puskesmas);

                if ($this->req->id_posyandu!=="0" && $this->req->id_posyandu !== null) {
                    return AllData::query()
                    ->where('idKec',$this->req->id_kec)
                    ->where('idPuskes',$this->req->id_puskesmas)
                    ->where('idPos',$this->req->id_posyandu);

                }
            } elseif ($this->req->id_kelurahan!=="0" && $this->req->id_kelurahan !== null) {
                return AllData::query()
                ->where('idKec',$this->req->id_kec)
                ->where('idKel',$this->req->id_kelurahan);

                if ($this->req->id_rt!=="0" && $this->req->id_rt !== null) {

                    return AllData::query()
                ->where('idKec',$this->req->id_kec)
                ->where('idKel',$this->req->id_kelurahan)
                ->where('idRt',$this->req->id_rt);
                }
            }else{
              
             return AllData::query()->where('idKec',$this->req->id_kec);   
            }
        }

        // return $query;
    }

}
