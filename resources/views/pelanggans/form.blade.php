@php
  $v = fn($k, $default='') => old($k, $pelanggan?->$k ?? $default);
@endphp

<form method="POST" action="{{ $action }}">
  @csrf
  @if($method !== 'POST') @method($method) @endif

  <div class="row g-3">
    <div class="col-12">
      <label class="form-label">Nama</label>
      <input class="form-control" name="nama" value="{{ $v('nama') }}" placeholder="Masukkan nama pelanggan" required>
    </div>

    <div class="col-md-3">
      <label class="form-label">Intensitas</label>
      <input type="number" class="form-control" name="intensitas" value="{{ $v('intensitas', 1) }}" min="1" max="10" required>
    </div>
    <div class="col-md-3">
      <label class="form-label">Frekuensi</label>
      <input type="number" class="form-control" name="frekuensi" value="{{ $v('frekuensi', 1) }}" min="1" max="10" required>
    </div>
    <div class="col-md-3">
      <label class="form-label">Jumlah Porsi</label>
      <input type="number" class="form-control" name="porsi" value="{{ $v('porsi', 1) }}" min="1" max="10" required>
    </div>
    <div class="col-md-3">
      <label class="form-label">Loyalitas</label>
      <input type="number" class="form-control" name="loyalitas" value="{{ $v('loyalitas', 1) }}" min="1" max="10" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">Lama Menjadi Pelanggan</label>
      <input type="number" class="form-control" name="lama" value="{{ $v('lama', 1) }}" min="1" max="10" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Rekomendasi Orang Lain</label>
      <input type="number" class="form-control" name="rekomendasi" value="{{ $v('rekomendasi', 1) }}" min="1" max="10" required>
    </div>
  </div>

  <div class="mt-4 d-flex gap-2">
    <button class="btn btn-primary">
      <i class="bi bi-save me-1"></i> Simpan
    </button>
    <a href="{{ route('pelanggans.index') }}" class="btn btn-secondary">
      Batal
    </a>
  </div>
</form>
