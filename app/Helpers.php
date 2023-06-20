<?php

use Illuminate\Support\Facades\DB;

function getZscore($x)
{
    $no = 0;
    foreach ($x as $key => $data) {
        $no++;
        $tinggi = $data->tb;
        $tgl_kunjungan = $data->tgl_kunjungan;
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

        if ($umur <= 60) {
            if ($bmi < $imt_u[0]->a1) {
                $s1 = "Gizi buruk (severely wasted)";
            } elseif ($bmi >= $imt_u[0]->a1 && $bmi < $imt_u[0]->b1) {
                $s1 = "Gizi kurang (wasted)";
            } elseif ($bmi >= $imt_u[0]->b1 && $bmi <= $imt_u[0]->c1) {
                $s1 = "Gizi baik (normal)";
            } elseif ($bmi > $imt_u[0]->c1 && $bmi <= $imt_u[0]->d1) {
                $s1 = "Berisiko gizi lebih (possible risk of overweight)";
            } elseif ($bmi > $imt_u[0]->d1 && $bmi <= $imt_u[0]->e1) {
                $s1 = "Gizi lebih (overweight)";
            } else {
                $s1 = "Obesitas (obese)";
            }
        } elseif ($umur > 60) {
            if ($bmi < $imt_u[0]->a1) {
                $s1 = "Gizi buruk (severely thinness)";
            } elseif ($bmi >= $imt_u[0]->a1 && $bmi < $imt_u[0]->b1) {
                $s1 = "Gizi kurang (thinness)";
            } elseif ($bmi >= $imt_u[0]->b1 && $bmi <= $imt_u[0]->c1) {
                $s1 = "Gizi baik (normal)";
            } elseif ($bmi > $imt_u[0]->c1 && $bmi <= $imt_u[0]->d1) {
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
                $s4 = "Gizi buruk (severely wasted)";
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
            // $s4 = $key;
            $s4 = "Data Tidak Valid";
            // continue;
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
            "tgl_kunjungan" => $tgl_kunjungan,
            "tinggi" => $tinggi,
            "berat" => $berat,
            "imt" => $s1,
            "bb" => $s2,
            "tb" => $s3,
            "bt" => $s4
        );
    }

    return $hasilx;
}
