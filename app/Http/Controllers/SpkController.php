<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;

class SpkController extends Controller
{
    public function index()
    {
        // NILAI IDEAL (sesuai sheet awal)
        $ideal = [
            'intensitas' => 10,
            'frekuensi'  => 10,
            'porsi'      => 10,
            'loyalitas'  => 10,
            'lama'       => 9,
            'rekomendasi'=> 8,
        ];

        // TABEL KETERANGAN BOBOT NILAI GAP (sesuai foto)
        $bobotGap = [
            0 => 6,
            1 => 5.5,  -1 => 5,
            2 => 4.5,  -2 => 4,
            3 => 3.5,  -3 => 3,
            4 => 2.5,  -4 => 2,
            5 => 1.5,  -5 => 1,
        ];

        // PERSENTASE PER-KRITERIA (sesuai baris % di sheet kamu)
        // (bobot kriteria, bukan core/secondary)
        $w = [
            'intensitas' => 0.60,
            'frekuensi'  => 0.40,
            'porsi'      => 0.40,
            'loyalitas'  => 0.60,
            'lama'       => 0.60,
            'rekomendasi'=> 0.40,
        ];

        // Kelompok C1 dan C2 (untuk total C1/C2)
        $colsC1 = ['intensitas','frekuensi','porsi'];        // C1
        $colsC2 = ['loyalitas','lama','rekomendasi'];        // C2
        $allCols = array_merge($colsC1, $colsC2);

        $pelanggans = Pelanggan::all();

        $tabelGap = [];
        $tabelBobot = [];
        $tabelTertimbang = [];
        $total = [];
        $ranking = [];

        foreach ($pelanggans as $p) {
            $rowGap = ['kode' => $p->kode, 'nama' => $p->nama];
            $rowBobot = ['kode' => $p->kode, 'nama' => $p->nama];
            $rowTimbang = ['kode' => $p->kode, 'nama' => $p->nama];

            foreach ($allCols as $k) {
                // GAP (tabel ke-2)
                $gap = $p->$k - $ideal[$k];
                $rowGap[$k] = $gap;

                // Bobot gap (dari tabel keterangan)
                $bobot = $bobotGap[$gap] ?? 1;
                $rowBobot[$k] = $bobot;

                // Tabel ke-3 (bobot * persen kriteria)
                $rowTimbang[$k] = round($bobot * $w[$k], 2);
            }

            // Total C1 & C2 (dari tabel ke-3)
            $C1 = 0;
            foreach ($colsC1 as $k) $C1 += $rowTimbang[$k];

            $C2 = 0;
            foreach ($colsC2 as $k) $C2 += $rowTimbang[$k];

            $C1 = round($C1, 2);
            $C2 = round($C2, 2);

            // NILAI AKHIR RANKING (yang kamu minta)
            $nilaiCore = round($C1 * 0.60, 2);
            $nilaiSec  = round($C2 * 0.40, 2);
            $nilaiAkhir = round($nilaiCore + $nilaiSec, 2);

            $tabelGap[] = $rowGap;
            $tabelBobot[] = $rowBobot;
            $tabelTertimbang[] = $rowTimbang;

            $total[] = [
                'kode' => $p->kode,
                'nama' => $p->nama,
                'C1' => $C1,
                'C2' => $C2,
            ];

            $ranking[] = [
                'kode' => $p->kode,
                'nama' => $p->nama,
                'core' => $nilaiCore,
                'secondary' => $nilaiSec,
                'nilai' => $nilaiAkhir,
            ];
        }

        // sorting nilai tertinggi
        usort($ranking, fn($a, $b) => $b['nilai'] <=> $a['nilai']);

        // kasih ranking number
        foreach ($ranking as $i => $r) {
            $ranking[$i]['rank'] = $i + 1;
        }

        return view('spk.index', compact(
            'ideal','w',
            'tabelGap','tabelBobot','tabelTertimbang',
            'total','ranking'
        ));
    }
}
