@extends('layouts.app')

@section('page_title', 'Hasil Perhitungan SPK')
@section('page_subtitle', 'Tabel GAP, Bobot GAP, Nilai Tertimbang, Total C1/C2, dan Ranking')

@section('content')
@php
  $labels = [
    'intensitas' => 'Intensitas Pembelian',
    'frekuensi' => 'Frekuensi Kunjungan',
    'porsi' => 'Jumlah Porsi',
    'loyalitas' => 'Loyalitas Pembeli',
    'lama' => 'Lama Menjadi Pelanggan',
    'rekomendasi' => 'Rekomendasi Org Lain',
  ];
  $cols = array_keys($labels);

  // helper format biar seperti sheet (contoh: 2,4)
  $fmt1 = fn($n) => number_format((float)$n, 1, ',', '.');
  $fmt2 = fn($n) => number_format((float)$n, 2, ',', '.');
@endphp

<h4 class="mb-3">SPK Loyalitas Pelanggan - Profile Matching</h4>

{{-- NILAI IDEAL + BOBOT KRITERIA --}}
<div class="mb-3">
  <div class="d-flex justify-content-between align-items-center mb-2">
    <div class="fw-bold">Nilai Ideal & Bobot Kriteria</div>
  </div>

  <div class="table-wrap table-responsive">
    <table class="table table-bordered table-striped table-hover table-sm align-middle">
      <thead>
        <tr>
          @foreach($labels as $lbl)
            <th>{{ $lbl }}</th>
          @endforeach
        </tr>
      </thead>
      <tbody>
        <tr>
          @foreach($cols as $k)
            <td class="text-center fw-semibold">{{ $ideal[$k] }}</td>
          @endforeach
        </tr>
        <tr class="table-warning">
          @foreach($cols as $k)
            <td class="text-center">
              {{ number_format($w[$k] * 100, 0) }}%
            </td>
          @endforeach
        </tr>
      </tbody>
    </table>
  </div>
</div>

{{-- TABEL 2 GAP --}}
<div class="mb-3">
  <div class="fw-bold mb-2">Tabel 2 — GAP (Aktual - Ideal)</div>

  <div class="table-wrap table-responsive">
    <table class="table table-bordered table-striped table-hover table-sm align-middle">
      <thead>
        <tr>
          <th>Kode</th>
          <th>Nama</th>
          @foreach($labels as $lbl)
            <th>{{ $lbl }}</th>
          @endforeach
        </tr>
      </thead>
      <tbody>
        @forelse($tabelGap as $r)
        <tr>
          <td>{{ $r['kode'] }}</td>
          <td>{{ $r['nama'] }}</td>
          @foreach($cols as $k)
            @php
              $gap = (int) $r[$k];
              $cls = $gap < 0 ? 'text-danger fw-semibold'
                    : ($gap === 0 ? 'text-success fw-semibold' : '');
            @endphp
            <td class="text-center {{ $cls }}">{{ $gap }}</td>
          @endforeach
        </tr>
        @empty
        <tr>
          <td colspan="{{ 2 + count($cols) }}" class="text-center text-muted">Belum ada data.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

{{-- BOBOT GAP --}}
<div class="mb-3">
  <div class="fw-bold mb-2">Konversi GAP → Bobot (Tabel Keterangan Bobot GAP)</div>

  <div class="table-wrap table-responsive">
    <table class="table table-bordered table-striped table-hover table-sm align-middle">
      <thead>
        <tr>
          <th>Kode</th>
          <th>Nama</th>
          @foreach($labels as $lbl)
            <th>{{ $lbl }}</th>
          @endforeach
        </tr>
      </thead>
      <tbody>
        @forelse($tabelBobot as $r)
        <tr>
          <td>{{ $r['kode'] }}</td>
          <td>{{ $r['nama'] }}</td>
          @foreach($cols as $k)
            <td class="text-center">{{ $fmt1($r[$k]) }}</td>
          @endforeach
        </tr>
        @empty
        <tr>
          <td colspan="{{ 2 + count($cols) }}" class="text-center text-muted">Belum ada data.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

{{-- TABEL 3 (BOBOT * %) --}}
<div class="mb-3">
  <div class="fw-bold mb-2">Tabel 3 — Nilai Tertimbang (Bobot × Persentase Kriteria)</div>

  <div class="table-wrap table-responsive">
    <table class="table table-bordered table-striped table-hover table-sm align-middle">
      <thead>
        <tr>
          <th>Kode</th>
          <th>Nama</th>
          @foreach($labels as $k => $lbl)
            <th>
              {{ $lbl }}
              <div class="text-muted" style="font-size:.85rem">
                {{ number_format($w[$k]*100,0) }}%
              </div>
            </th>
          @endforeach
        </tr>
      </thead>
      <tbody>
        @forelse($tabelTertimbang as $r)
        <tr>
          <td>{{ $r['kode'] }}</td>
          <td>{{ $r['nama'] }}</td>
          @foreach($cols as $k)
            <td class="text-center">{{ $fmt1($r[$k]) }}</td>
          @endforeach
        </tr>
        @empty
        <tr>
          <td colspan="{{ 2 + count($cols) }}" class="text-center text-muted">Belum ada data.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

{{-- PERHITUNGAN NILAI TOTAL --}}
<div class="mb-3">
  <div class="fw-bold mb-2">Perhitungan Nilai Total</div>

  <div class="table-wrap table-responsive">
    <table class="table table-bordered table-striped table-hover table-sm align-middle">
      <thead>
        <tr>
          <th>Kode</th>
          <th>Nama</th>
          <th>C1</th>
          <th>C2</th>
        </tr>
      </thead>
      <tbody>
        @forelse($total as $r)
        <tr>
          <td>{{ $r['kode'] }}</td>
          <td>{{ $r['nama'] }}</td>
          <td class="text-center">{{ $fmt1($r['C1']) }}</td>
          <td class="text-center">{{ $fmt1($r['C2']) }}</td>
        </tr>
        @empty
        <tr>
          <td colspan="4" class="text-center text-muted">Belum ada data.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="text-muted mt-2" style="font-size:.95rem">
    C1 = Intensitas + Frekuensi + Porsi, C2 = Loyalitas + Lama + Rekomendasi (diambil dari Tabel 3).
  </div>
</div>

{{-- RANKING --}}
<div class="mb-0">
  <div class="fw-bold mb-2">Ranking (Nilai = 60%×C1 + 40%×C2)</div>

  <div class="table-wrap table-responsive">
    <table class="table table-bordered table-striped table-hover table-sm align-middle">
      <thead>
        <tr>
          <th>Kode</th>
          <th>Nama</th>
          <th>Core (0.60×C1)</th>
          <th>Secondary (0.40×C2)</th>
          <th>Nilai Akhir</th>
          <th>Ranking</th>
        </tr>
      </thead>
      <tbody>
        @forelse($ranking as $r)
        <tr>
          <td>{{ $r['kode'] }}</td>
          <td>{{ $r['nama'] }}</td>
          <td class="text-center">{{ $fmt2($r['core']) }}</td>
          <td class="text-center">{{ $fmt2($r['secondary']) }}</td>
          <td class="text-center fw-bold">{{ $fmt2($r['nilai']) }}</td>
          <td class="text-center">{{ $r['rank'] }}</td>
        </tr>
        @empty
        <tr>
          <td colspan="6" class="text-center text-muted">Belum ada data.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
