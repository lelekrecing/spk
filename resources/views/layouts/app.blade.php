<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'SPK Profile Matching')</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

  <style>
    :root{
      --bg:#0b1220;
      --card:rgba(15,23,42,.80);
      --border:rgba(255,255,255,.12);
      --text:#e5e7eb;
      --muted:rgba(229,231,235,.70);
      --accent:#60a5fa;
      --accent2:#34d399;
    }

    body{
      background:
        radial-gradient(1200px 600px at 20% -10%, rgba(96,165,250,.18), transparent 60%),
        radial-gradient(900px 500px at 100% 0%, rgba(52,211,153,.16), transparent 55%),
        radial-gradient(900px 600px at 0% 100%, rgba(167,139,250,.12), transparent 50%),
        var(--bg);
      color: var(--text);
      min-height: 100vh;
    }

    /* NAVBAR */
    .glass-nav{
      background: rgba(15, 23, 42, .78) !important;
      border-bottom: 1px solid var(--border);
      backdrop-filter: blur(10px);
    }
    .brand{
      font-weight: 900;
      letter-spacing: .2px;
      background: linear-gradient(90deg, var(--accent), var(--accent2));
      -webkit-background-clip:text;
      background-clip:text;
      color: transparent;
    }

    .nav-link{
      border-radius: 12px;
      padding: 8px 12px !important;
      margin-left: 6px;
      color: rgba(255,255,255,.78) !important;
      border: 1px solid transparent;
    }
    .nav-link:hover{
      background: rgba(255,255,255,.08);
      border-color: rgba(255,255,255,.08);
      color:#fff !important;
    }
    .nav-link.active{
      background: rgba(96,165,250,.14);
      border-color: rgba(96,165,250,.28);
      color:#fff !important;
    }

    /* HERO */
    .page-hero{
      background: linear-gradient(135deg, rgba(96,165,250,.14), rgba(52,211,153,.10));
      border: 1px solid rgba(255,255,255,.10);
      border-radius: 18px;
      padding: 18px;
    }
    .badge-soft{
      background: rgba(255,255,255,.08);
      border: 1px solid rgba(255,255,255,.10);
      color: rgba(255,255,255,.88);
      font-weight: 600;
    }

    /* CARD WRAP */
    .soft-card{
      background: var(--card);
      border: 1px solid rgba(255,255,255,.10);
      border-radius: 18px;
      box-shadow: 0 18px 50px rgba(0,0,0,.35);
    }

    /* FORMS */
    .form-control, .form-select{
      background: rgba(255,255,255,.06);
      border: 1px solid rgba(255,255,255,.14);
      color: var(--text);
      border-radius: 12px;
    }
    .form-control:focus, .form-select:focus{
      border-color: rgba(96,165,250,.55);
      box-shadow: 0 0 0 .25rem rgba(96,165,250,.15);
      background: rgba(255,255,255,.07);
      color: var(--text);
    }
    .form-control::placeholder{ color: rgba(229,231,235,.55); }

    /* BUTTON */
    .btn{ border-radius: 12px; font-weight: 700; }
    .btn-primary{
      background: linear-gradient(90deg, rgba(96,165,250,.95), rgba(52,211,153,.85));
      border: 0;
    }
    .btn-primary:hover{ filter: brightness(1.06); }

    /* ALERT */
    .alert{
      border-radius: 16px;
      border: 1px solid rgba(255,255,255,.10);
      background: rgba(15,23,42,.75);
      color: var(--text);
    }
    .alert-success{ border-color: rgba(52,211,153,.25); }
    .alert-danger{ border-color: rgba(248,113,113,.28); }
    .text-muted{ color: var(--muted) !important; }

    /* ===== TABLE FIX (BIAR NAMPak) ===== */
    .table-wrap{
      background: rgba(255,255,255,.04);
      border: 1px solid rgba(255,255,255,.14);
      border-radius: 14px;
      padding: 10px;
    }
    .table{
      margin-bottom: 0;
      color: rgba(255,255,255,.92) !important;
      --bs-table-bg: transparent;
      --bs-table-border-color: rgba(255,255,255,.14);
    }
    .table td, .table th{
      color: rgba(255,255,255,.92) !important;
      border-color: rgba(255,255,255,.12) !important;
    }
    .table thead th{
      background: rgba(255,255,255,.10) !important;
      border-bottom: 1px solid rgba(255,255,255,.18) !important;
      white-space: nowrap;
    }
    .table tbody td{
      background: rgba(15, 23, 42, .35) !important;
    }
    .table-striped>tbody>tr:nth-of-type(odd)>*{
      background: rgba(255,255,255,.03) !important;
    }
    .table-hover>tbody>tr:hover>*{
      background: rgba(96,165,250,.12) !important;
    }
  </style>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark glass-nav sticky-top">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('pelanggans.index') }}">
      <span class="bg-white rounded-3 px-2 py-1">
        <i class="bi bi-diagram-3-fill text-dark"></i>
      </span>
      <span class="brand">Sistem Pendukung Keputusan</span>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
      <span class="navbar-toggler-icon"></span>
    </button>

    @php
      $r = request()->route()?->getName();
      $isPelanggan = str_starts_with($r ?? '', 'pelanggans.');
      $isSpk = str_starts_with($r ?? '', 'spk.');
    @endphp

    <div class="collapse navbar-collapse" id="navMenu">
      <div class="navbar-nav ms-auto align-items-lg-center">
        <a class="nav-link {{ $isPelanggan ? 'active' : '' }}" href="{{ route('pelanggans.index') }}">
          <i class="bi bi-people me-1"></i> Data Pelanggan
        </a>
        <a class="nav-link {{ $isSpk ? 'active' : '' }}" href="{{ route('spk.index') }}">
          <i class="bi bi-trophy me-1"></i> Hasil SPK
        </a>
      </div>
    </div>
  </div>
</nav>

<div class="container py-4">

  <div class="page-hero mb-4">
    <div class="d-flex flex-wrap gap-2 mb-2">
      <span class="badge badge-soft rounded-pill px-3 py-2">
        <i class="bi bi-lightning-charge-fill me-1"></i> SPK
      </span>
      <span class="badge badge-soft rounded-pill px-3 py-2">
        <i class="bi bi-diagram-3 me-1"></i> Profile Matching
      </span>
      <span class="badge badge-soft rounded-pill px-3 py-2">
        <i class="bi bi-percent me-1"></i> Core 60% • Secondary 40%
      </span>
    </div>

    <h3 class="mb-0 fw-bold">@yield('page_title', 'Sistem Pendukung Keputusan')</h3>
    <div class="text-muted">@yield('page_subtitle', 'Metode Profile Matching')</div>
  </div>

  @if(session('ok'))
    <div class="alert alert-success mb-4">
      <div class="d-flex align-items-start gap-2">
        <i class="bi bi-check-circle-fill fs-5"></i>
        <div>
          <div class="fw-semibold">Berhasil</div>
          <div>{{ session('ok') }}</div>
        </div>
      </div>
    </div>
  @endif

  @if($errors->any())
    <div class="alert alert-danger mb-4">
      <div class="d-flex align-items-start gap-2">
        <i class="bi bi-exclamation-triangle-fill fs-5"></i>
        <div>
          <div class="fw-semibold">Ada error</div>
          <ul class="mb-0">
            @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
          </ul>
        </div>
      </div>
    </div>
  @endif

  <div class="soft-card p-3 p-md-4">
    @yield('content')
  </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
