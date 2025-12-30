@extends('layouts.app')

@section('page_title', 'Tambah Data Pelanggan')
@section('page_subtitle', 'Isi data pelanggan untuk perhitungan SPK')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">Tambah Pelanggan</h4>
  <a href="{{ route('pelanggans.index') }}" class="btn btn-secondary">
    <i class="bi bi-arrow-left"></i> Kembali
  </a>
</div>

@include('pelanggans.form', [
  'action' => route('pelanggans.store'),
  'method' => 'POST',
  'pelanggan' => null
])
@endsection
