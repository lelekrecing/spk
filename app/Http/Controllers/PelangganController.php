<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PelangganController extends Controller
{
    public function index()
    {
        // urut berdasarkan urutan biar A1, A2, A3 rapi di tabel
        $pelanggans = Pelanggan::orderBy('urutan')->paginate(10);
        return view('pelanggans.index', compact('pelanggans'));
    }

    public function create()
    {
        return view('pelanggans.create');
    }

    public function store(Request $request)
    {
        // KODE TIDAK DIINPUT LAGI (AUTO)
        $data = $request->validate([
            'nama' => 'required|string|max:100',
            'intensitas' => 'required|integer|min:1|max:10',
            'frekuensi'  => 'required|integer|min:1|max:10',
            'porsi'      => 'required|integer|min:1|max:10',
            'loyalitas'  => 'required|integer|min:1|max:10',
            'lama'       => 'required|integer|min:1|max:10',
            'rekomendasi'=> 'required|integer|min:1|max:10',
        ]);

        DB::transaction(function () use ($data) {
            $next = (int) (Pelanggan::max('urutan') ?? 0) + 1;

            Pelanggan::create([
                'urutan' => $next,
                'kode'   => 'A'.$next,
                ...$data
            ]);
        });

        return redirect()->route('pelanggans.index')->with('ok', 'Data pelanggan berhasil ditambahkan.');
    }

    public function edit(Pelanggan $pelanggan)
    {
        return view('pelanggans.edit', compact('pelanggan'));
    }

    public function update(Request $request, Pelanggan $pelanggan)
    {
        // KODE & URUTAN TIDAK DIUBAH (BIAR TETAP AUTO)
        $data = $request->validate([
            'nama' => 'required|string|max:100',
            'intensitas' => 'required|integer|min:1|max:10',
            'frekuensi'  => 'required|integer|min:1|max:10',
            'porsi'      => 'required|integer|min:1|max:10',
            'loyalitas'  => 'required|integer|min:1|max:10',
            'lama'       => 'required|integer|min:1|max:10',
            'rekomendasi'=> 'required|integer|min:1|max:10',
        ]);

        $pelanggan->update($data);

        return redirect()->route('pelanggans.index')->with('ok', 'Data pelanggan berhasil diupdate.');
    }

    public function destroy(Pelanggan $pelanggan)
    {
        DB::transaction(function () use ($pelanggan) {
            $pelanggan->delete();

            // RAPiKAN: kalau A1 dihapus, A2 jadi A1, dst
            $all = Pelanggan::orderBy('urutan')->get();

            foreach ($all as $i => $p) {
                $new = $i + 1;
                if ($p->urutan != $new) {
                    $p->update([
                        'urutan' => $new,
                        'kode'   => 'A'.$new,
                    ]);
                }
            }
        });

        return redirect()->route('pelanggans.index')->with('ok', 'Data pelanggan berhasil dihapus & kode dirapikan.');
    }
}
