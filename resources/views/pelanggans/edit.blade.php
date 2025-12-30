@extends('layouts.app')

@section('page_title', 'Edit Data Pelanggan')
@section('page_subtitle', 'Perbarui data pelanggan untuk perhitungan SPK')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">Edit Pelanggan ({{ $pelanggan->kode }})</h4>
  <a href="{{ route('pelanggans.index') }}" class="btn btn-secondary">
    <i class="bi bi-arrow-left"></i> Kembali
  </a>
</div>

@include('pelanggans.form', [
  'action' => route('pelanggans.update', $pelanggan),
  'method' => 'PUT',
  'pelanggan' => $pelanggan
])
@endsection
