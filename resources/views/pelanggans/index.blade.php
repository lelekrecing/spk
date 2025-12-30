@extends('layouts.app')

@section('page_title', 'Data Pelanggan')
@section('page_subtitle', 'Kelola data pelanggan untuk perhitungan SPK')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">Data Pelanggan</h4>
  <a class="btn btn-primary" href="{{ route('pelanggans.create') }}">
    <i class="bi bi-plus-lg me-1"></i> Tambah
  </a>
</div>

<div class="table-wrap table-responsive">
  <table class="table table-bordered table-striped table-hover table-sm align-middle">
    <thead>
      <tr>
        <th>Kode</th><th>Nama</th>
        <th>Intensitas</th><th>Frekuensi</th><th>Porsi</th><th>Loyalitas</th>
        <th>Lama</th><th>Rekomendasi</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($pelanggans as $p)
      <tr>
        <td>{{ $p->kode }}</td>
        <td>{{ $p->nama }}</td>
        <td class="text-center">{{ $p->intensitas }}</td>
        <td class="text-center">{{ $p->frekuensi }}</td>
        <td class="text-center">{{ $p->porsi }}</td>
        <td class="text-center">{{ $p->loyalitas }}</td>
        <td class="text-center">{{ $p->lama }}</td>
        <td class="text-center">{{ $p->rekomendasi }}</td>
        <td class="text-nowrap">
          <a class="btn btn-warning btn-sm" href="{{ route('pelanggans.edit', $p) }}">
            <i class="bi bi-pencil-square"></i> Edit
          </a>
          <form class="d-inline" method="POST" action="{{ route('pelanggans.destroy', $p) }}">
            @csrf @method('DELETE')
            <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus data ini?')">
              <i class="bi bi-trash"></i> Hapus
            </button>
          </form>
        </td>
      </tr>
      @empty
      <tr><td colspan="9" class="text-center text-muted">Belum ada data.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>

<div class="mt-3">
  {{ $pelanggans->links() }}
</div>
@endsection
