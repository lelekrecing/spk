<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;

class SpkController extends Controller
{
    public function index()
    {
        /**
         * NILAI IDEAL (sesuai permintaan)
         */
        $ideal = [
            'intensitas' => 10,
            'frekuensi'  => 10,
            'porsi'      => 10,
            'loyalitas'  => 10,
            'lama'       => 9,
            'rekomendasi'=> 8,
        ];

        /**
         * TABEL BOBOT NILAI GAP (standar Profile Matching)
         * gap: -5..5
         */
        $bobotGap = [
            0  => 6,
            1  => 5.5,
            -1 => 5,
            2  => 4.5,
            -2 => 4,
            3  => 3.5,
            -3 => 3,
            4  => 2.5,
            -4 => 2,
            5  => 1.5,
            -5 => 1,
        ];

        /**
         * BOBOT PER-KRITERIA (sesuai sheet kamu)
         * C–E = 60% ; F–H = 40%
         */
        $w = [
            'intensitas' => 0.60,
            'frekuensi'  => 0.60,
            'porsi'      => 0.60,
            'loyalitas'  => 0.40,
            'lama'       => 0.40,
            'rekomendasi'=> 0.40,
        ];

        // Kelompok C1 dan C2
        $colsC1  = ['intensitas', 'frekuensi', 'porsi'];        // Core
        $colsC2  = ['loyalitas', 'lama', 'rekomendasi'];        // Secondary
        $allCols = array_merge($colsC1, $colsC2);

        $pelanggans = Pelanggan::all();

        $tabelGap        = [];
        $tabelBobot      = [];
        $tabelTertimbang = [];
        $total           = [];
        $ranking         = [];

        foreach ($pelanggans as $p) {
            $rowGap     = ['kode' => $p->kode, 'nama' => $p->nama];
            $rowBobot   = ['kode' => $p->kode, 'nama' => $p->nama];
            $rowTimbang = ['kode' => $p->kode, 'nama' => $p->nama];

            foreach ($allCols as $k) {
                /**
                 * 1) GAP asli (Aktual - Ideal)
                 */
                $gapRaw = (int)$p->$k - (int)$ideal[$k];

                /**
                 * 2) GAP untuk mapping bobot dibatasi -5..5
                 * supaya tidak jatuh ke default terus kalau gap terlalu besar.
                 */
                $gapMap = max(-5, min(5, $gapRaw));

                // Tabel GAP tampilkan yang asli (biar sesuai definisi: aktual-ideal)
                $rowGap[$k] = $gapRaw;

                /**
                 * 3) Bobot GAP (pakai gapMap yang sudah dibatasi)
                 */
                $bobot = $bobotGap[$gapMap] ?? 1;
                $rowBobot[$k] = $bobot;

                /**
                 * 4) Nilai tertimbang (bobot gap * bobot kriteria)
                 */
                $rowTimbang[$k] = round($bobot * $w[$k], 2);
            }

            /**
             * Total C1 & C2 (jumlah dari tabel tertimbang)
             */
            $C1 = 0;
            foreach ($colsC1 as $k) $C1 += $rowTimbang[$k];

            $C2 = 0;
            foreach ($colsC2 as $k) $C2 += $rowTimbang[$k];

            $C1 = round($C1, 2);
            $C2 = round($C2, 2);

            /**
             * Nilai akhir Ranking
             * Nilai = 60%*C1 + 40%*C2
             */
            $nilaiCore  = round($C1 * 0.60, 2);
            $nilaiSec   = round($C2 * 0.40, 2);
            $nilaiAkhir = round($nilaiCore + $nilaiSec, 2);

            $tabelGap[]        = $rowGap;
            $tabelBobot[]      = $rowBobot;
            $tabelTertimbang[] = $rowTimbang;

            $total[] = [
                'kode' => $p->kode,
                'nama' => $p->nama,
                'C1'   => $C1,
                'C2'   => $C2,
            ];

            $ranking[] = [
                'kode'      => $p->kode,
                'nama'      => $p->nama,
                'core'      => $nilaiCore,
                'secondary' => $nilaiSec,
                'nilai'     => $nilaiAkhir,
            ];
        }

        // Sorting nilai tertinggi
        usort($ranking, fn($a, $b) => $b['nilai'] <=> $a['nilai']);

        // Kasih nomor ranking
        foreach ($ranking as $i => $r) {
            $ranking[$i]['rank'] = $i + 1;
        }

        return view('spk.index', compact(
            'ideal', 'w',
            'tabelGap', 'tabelBobot', 'tabelTertimbang',
            'total', 'ranking'
        ));
    }
}
