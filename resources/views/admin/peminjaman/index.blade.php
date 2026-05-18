@extends('layouts.admin')
@section('title', 'Peminjaman')
@section('link')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/content.css') }}">
    <link rel="stylesheet" href="{{ asset('css/universal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/peminjaman.css') }}">
    <link rel="stylesheet" href="{{ asset('css/table.css') }}">
    <link rel="stylesheet" href="{{ asset('css/filter.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/button.css') }}">
@endsection
@section('content')
    @php
        function badgeClass($status)
        {
            if ($status == 'batal') {
                return 'badge-soft-danger';
            } elseif ($status == 'menunggu') {
                return 'badge-soft-warning';
            } elseif ($status == 'siap diambil') {
                return 'badge-soft-success';
            } elseif ($status == 'aktif') {
                return 'badge-soft-primary';
            } else {
                return 'badge-soft-purple';
            }
        }
    @endphp
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="title">
                            <h4>Data Peminjaman</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><i class="bx bx-home"></i>
                                    <a href="{{ route('dashboardAdmin.index') }}">Dashboard Admin</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Data Peminjaman
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="col-12 mb-4 p-0">
                <div class="tab-system">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active text-blue" data-toggle="tab" href="#menunggu" role="tab"
                                aria-selected="true">Menunggu</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-blue" data-toggle="tab" href="#siap-diambil" role="tab"
                                aria-selected="false">Siap Diambil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-blue" data-toggle="tab" href="#aktif" role="tab"
                                aria-selected="false">Aktif</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-blue" data-toggle="tab" href="#proses-pengembalian" role="tab"
                                aria-selected="false">Proses Pengembalian</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-blue" data-toggle="tab" href="#batal" role="tab"
                                aria-selected="false">Dibatalkan</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active tab-custom px-3" id="menunggu" role="tabpanel">
                            <div class="row  align-items-center">
                                <div class="col-md-6 col-12 mb-md-0">
                                    <div class="input-group mt-4 mb-0">
                                        <div id="search-wrapper-menunggu" class="pr-2"></div>

                                    </div>
                                </div>
                                <div class="col-md-6 col-12 d-flex gap-2 flex-wrap justify-content-md-end mt-2">
                                    <div id="show-entries-menunggu"></div>
                                </div>
                            </div>
                            <div class="pb-20 pt-1">
                                <div class="table-responsive">
                                    <table class="data-table table hover py-3 px-4 border-0 py-3 px-4 border-0"
                                        style="background: #e9edf9b1 !important; border-radius: 22px;" id="table-menunggu"
                                        style="background: #e9edf9b1 !important; border-radius: 22px;">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Nama Siswa</th>
                                                <th>Kelas</th>
                                                <th>Jadwal Pemakaian</th>
                                                <th>Status</th>
                                                <th>Alat</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($peminjamanMenunggu as $index => $item)
                                                <tr>
                                                    <td>
                                                        <div class="no-badge">{{ $index + 1 }}.</div>
                                                    </td>
                                                    <td>{{ ucwords($item->siswa->nama_siswa) }}</td>
                                                    <td>{{ ucwords($item->siswa->kelas) }}</td>
                                                    <td>{{ $item->jadwalFormat() }}</td>
                                                    <td>
                                                        <span
                                                            class="badge {{ badgeClass($item->status_pinjam) }} px-3 py-2 rounded-pill">
                                                            {{ ucwords($item->status_pinjam) }}
                                                        </span>
                                                    </td>
                                                    <td class="td-detail">
                                                        <button class="btn-detail-soft btn-detail">
                                                            <span class="icon-wrap">
                                                                <i class="fas fa-plus"></i>
                                                            </span>
                                                        </button>
                                                        <div class="detail-alat mt-2" style="display:none;">
                                                            <ul class="mb-0 p-0 detail-list">
                                                                @foreach ($item->tipeAlat as $detail)
                                                                    <li>
                                                                        <span class="dot"></span>
                                                                        <span
                                                                            class="name">{{ ucwords($detail->nama_tipe) }}</span>
                                                                        <span
                                                                            class="qty">x{{ $detail->pivot->quantity }}</span>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <form action="{{ route('peminjaman.cancel', $item->id_pinjam) }}"
                                                            method="POST">
                                                            @csrf
                                                            <button type="submit" class="btn-cancel-soft" title="Batalkan">
                                                                <i class="fa-solid fa-circle-xmark"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade tab-custom px-3" id="siap-diambil" role="tabpanel">
                            <div class="row align-items-center">
                                <div class="col-md-6 col-12 mb-md-0">
                                    <div class="input-group mt-3 mb-0">
                                        <div id="search-wrapper-siap-diambil" class="pr-2"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12 d-flex gap-2 flex-wrap justify-content-md-end mt-2">
                                    <div id="show-entries-siap-diambil"></div>
                                </div>
                            </div>
                            <div class="pb-20 pt-1">
                                <div class="table-responsive">
                                    <table class="data-table table hover py-3 px-4 border-0" id="table-siap-diambil"
                                        style="background: #e9edf9b1 !important; border-radius: 22px;">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Nama Siswa</th>
                                                <th>Kelas</th>
                                                <th>Jadwal Pemakaian</th>
                                                <th>Status</th>
                                                <th>Alat</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($peminjamanSiapDiambil as $index => $item)
                                                <tr>
                                                    <td>
                                                        <div class="no-badge">{{ $index + 1 }}.</div>
                                                    </td>
                                                    <td>{{ ucwords($item->siswa->nama_siswa) }}</td>
                                                    <td>{{ ucwords($item->siswa->kelas) }}</td>
                                                    <td>{{ $item->jadwalFormat() }}</td>
                                                    <td>
                                                        <span
                                                            class="badge {{ badgeClass($item->status_pinjam) }} px-3 py-2 rounded-pill">
                                                            {{ ucwords($item->status_pinjam) }}
                                                        </span>
                                                    </td>
                                                    <td class="td-detail">
                                                        <button class="btn-detail-soft btn-detail">
                                                            <span class="icon-wrap">
                                                                <i class="fas fa-plus"></i>
                                                            </span>
                                                        </button>

                                                        <div class="detail-alat mt-2" style="display:none;">

                                                            @foreach ($item->tipeAlat as $detail)
                                                                <div class="mb-3 pb-2 border-bottom">

                                                                    <div
                                                                        class="d-flex justify-content-between align-items-center">
                                                                        <span class="fw-semibold">
                                                                            {{ ucwords($detail->nama_tipe) }}
                                                                        </span>

                                                                        <small class="text-muted">
                                                                            x{{ $detail->pivot->quantity }}
                                                                        </small>
                                                                    </div>

                                                                    <div class="mt-2 ps-2">
                                                                        @foreach ($item->detailAlat->where('id_tipe', $detail->id_tipe) as $alat)
                                                                            <div class="text-muted small">
                                                                                • {{ $alat->kode_alat }}
                                                                            </div>
                                                                        @endforeach
                                                                    </div>

                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="action-group">
                                                            <form
                                                                action="{{ route('peminjaman.cancel', $item->id_pinjam) }}"
                                                                method="POST" class="m-0">
                                                                @csrf
                                                                <button type="submit" class="btn-cancel-soft"
                                                                    title="Batalkan">
                                                                    <i class="fa-solid fa-circle-xmark"></i>

                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade tab-custom px-3" id="aktif" role="tabpanel">
                            <div class="row align-items-center">
                                <div class="col-md-6 col-12 mb-md-0">
                                    <div class="input-group mt-3 mb-0">
                                        <div id="search-wrapper-aktif" class="pr-2"></div>

                                    </div>
                                </div>
                                <div class="col-md-6 col-12 d-flex gap-2 flex-wrap justify-content-md-end mt-2">
                                    <div id="show-entries-aktif"></div>
                                </div>
                            </div>
                            <div class="pb-20 pt-1">
                                <div class="table-responsive">
                                    <table class="data-table table hover py-3 px-4 border-0" id="table-aktif"
                                        style="background: #e9edf9b1 !important; border-radius: 22px;">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>ID Peminjaman</th>
                                                <th>Nama Siswa</th>
                                                <th>Kelas</th>
                                                <th>Tanggal Pemakaian</th>
                                                <th>Batas Pengembalian</th>
                                                <th>Keterlambatan</th>
                                                <th>Status</th>
                                                <th>Alat</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($peminjamanAktif as $index => $item)
                                                <tr>
                                                    <td>
                                                        <div class="no-badge">{{ $index + 1 }}.</div>
                                                    </td>
                                                    <td>PJM-0{{ $item->id_pinjam }}</td>
                                                    <td>{{ ucwords($item->siswa->nama_siswa) }}</td>
                                                    <td>{{ ucwords($item->siswa->kelas) }}</td>
                                                    <td>{{ $item->tanggalPemakaianFormat() }}</td>
                                                    <td>{{ $item->batasPengembalianFormat() }}</td>
                                                    <td>
                                                        @if ($item->terlambat())
                                                            <span class="badge badge-soft-danger rounded-pill">
                                                                Terlambat
                                                            </span>

                                                            <div class="menit-terlambat mt-1 ml-1">
                                                                {{ $item->keterlambatanText() }}
                                                            </div>
                                                        @else
                                                            <span class=" badge badge-soft-success rounded-pill">
                                                                Tepat Waktu
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge {{ badgeClass($item->status_pinjam) }} px-3 py-2 rounded-pill">
                                                            {{ ucwords($item->status_pinjam) }}
                                                        </span>
                                                    </td>
                                                    <td class="td-detail">
                                                        <button class="btn-detail-soft btn-detail">
                                                            <span class="icon-wrap">
                                                                <i class="fas fa-plus"></i>
                                                            </span>
                                                        </button>

                                                        <div class="detail-alat mt-2" style="display:none;">

                                                            @foreach ($item->tipeAlat as $detail)
                                                                <div class="mb-3 pb-2 border-bottom">

                                                                    <div
                                                                        class="d-flex justify-content-between align-items-center">
                                                                        <span class="fw-semibold">
                                                                            {{ ucwords($detail->nama_tipe) }}
                                                                        </span>

                                                                        <small class="text-muted">
                                                                            x{{ $detail->pivot->quantity }}
                                                                        </small>
                                                                    </div>

                                                                    <div class="mt-2 ps-2">
                                                                        @foreach ($item->detailAlat->where('id_tipe', $detail->id_tipe) as $alat)
                                                                            <div class="text-muted small">
                                                                                • {{ $alat->kode_alat }}
                                                                            </div>
                                                                        @endforeach
                                                                    </div>

                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade tab-custom px-3" id="proses-pengembalian" role="tabpanel">
                            <div class="row align-items-center">
                                <div class="col-md-6 col-12 mb-md-0">
                                    <div class="input-group mt-3 mb-0">
                                        <div id="search-wrapper-proses-pengembalian" class="pr-2"></div>

                                    </div>
                                </div>
                                <div class="col-md-6 col-12 d-flex gap-2 flex-wrap justify-content-md-end mt-2">
                                    <div id="show-entries-proses-pengembalian"></div>
                                </div>
                            </div>
                            <div class="pb-20 pt-1">
                                <div class="table-responsive">
                                    <table class="data-table table hover py-3 px-4 border-0"
                                        id="table-proses-pengembalian"
                                        style="background: #e9edf9b1 !important; border-radius: 22px;">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>ID Peminjaman</th>
                                                <th>Nama Siswa</th>
                                                <th>Kelas</th>
                                                <th>Tanggal Pemakaian</th>
                                                <th>Batas Pengembalian</th>
                                                <th>Keterlambatan</th>
                                                <th>Status</th>
                                                <th>Alat</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($peminjamanProsesPengembalian as $index => $item)
                                                <tr>
                                                    <td>
                                                        <div class="no-badge">{{ $index + 1 }}.</div>
                                                    </td>
                                                    <td>PJM-0{{ $item->id_pinjam }}</td>
                                                    <td>{{ ucwords($item->siswa->nama_siswa) }}</td>
                                                    <td>{{ ucwords($item->siswa->kelas) }}</td>
                                                    <td>{{ $item->tanggalPemakaianFormat() }}</td>
                                                    <td>{{ $item->batasPengembalianFormat() }}</td>
                                                    <td>
                                                        @if ($item->terlambat())
                                                            <span class="badge badge-soft-danger rounded-pill">
                                                                Terlambat
                                                            </span>

                                                            <div class="menit-terlambat mt-1 ml-1">
                                                                {{ $item->keterlambatanText() }}
                                                            </div>
                                                        @else
                                                            <span class=" badge badge-soft-success rounded-pill">
                                                                Tepat Waktu
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge {{ badgeClass($item->status_pinjam) }} px-3 py-2 rounded-pill">
                                                            {{ ucwords($item->status_pinjam) }}
                                                        </span>
                                                    </td>
                                                    <td class="td-detail">
                                                        <button class="btn-detail-soft btn-detail">
                                                            <span class="icon-wrap">
                                                                <i class="fas fa-plus"></i>
                                                            </span>
                                                        </button>

                                                        <div class="detail-alat mt-2" style="display:none;">

                                                            @foreach ($item->tipeAlat as $detail)
                                                                <div class="mb-3 pb-2 border-bottom">

                                                                    <div
                                                                        class="d-flex justify-content-between align-items-center">
                                                                        <span class="fw-semibold">
                                                                            {{ ucwords($detail->nama_tipe) }}
                                                                        </span>

                                                                        <small class="text-muted">
                                                                            x{{ $detail->pivot->quantity }}
                                                                        </small>
                                                                    </div>

                                                                    <div class="mt-2 ps-2">
                                                                        @foreach ($item->detailAlat->where('id_tipe', $detail->id_tipe) as $alat)
                                                                            <div class="text-muted small">
                                                                                • {{ $alat->kode_alat }}
                                                                            </div>
                                                                        @endforeach
                                                                    </div>

                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn-validasi-soft" title="Validasi"
                                                            data-toggle="modal" data-target="#modal-validasi"
                                                            data-id-pinjam="{{ $item->id_pinjam }}"
                                                            data-nama-siswa="{{ ucfirst($item->siswa->nama_siswa) }}"
                                                            data-kelas="{{ strtoupper($item->siswa->kelas) }}"
                                                            data-tanggal-mulai="{{ $item->tanggalPeminjamanFormat() }}"
                                                            data-batas-kembali="{{ $item->batasKembaliFormat() }}"
                                                            data-terlambat="{{ $item->terlambat() ? 1 : 0 }}"
                                                            data-terlambat-text="{{ $item->keterlambatanText() }}"
                                                            data-alat='@json($item->detailAlat->load('tipeAlat'))'>
                                                            <i class="fa-solid fa-check-to-slot"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade tab-custom px-3" id="batal" role="tabpanel">
                            <div class="row align-items-center">
                                <div class="col-md-6 col-12 mb-md-0">
                                    <div class="input-group mt-3 mb-0">
                                        <div id="search-wrapper-batal" class="pr-2"></div>

                                    </div>
                                </div>
                                <div class="col-md-6 col-12 d-flex gap-2 flex-wrap justify-content-md-end mt-2">
                                    <div id="show-entries-batal"></div>
                                </div>
                            </div>
                            <div class="pb-20 pt-1">
                                <div class="table-responsive">
                                    <table class="data-table table hover py-3 px-4 border-0" id="table-batal"
                                        style="background: #e9edf9b1 !important; border-radius: 22px;">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Nama Siswa</th>
                                                <th>Kelas</th>
                                                <th>Jadwal Pemakaian</th>
                                                <th>Alat</th>
                                                <th>Status</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($peminjamanBatal as $index => $item)
                                                <tr>
                                                    <td>
                                                        <div class="no-badge">{{ $index + 1 }}.</div>
                                                    </td>
                                                    <td>{{ ucwords($item->siswa->nama_siswa) }}</td>
                                                    <td>{{ ucwords($item->siswa->kelas) }}</td>
                                                    <td>{{ $item->jadwalFormat() }}</td>
                                                    <td class="td-detail">
                                                        <button class="btn-detail-soft btn-detail">
                                                            <span class="icon-wrap">
                                                                <i class="fas fa-plus"></i>
                                                            </span>
                                                        </button>
                                                        <div class="detail-alat mt-2" style="display:none;">
                                                            <ul class="mb-0 p-0 detail-list">
                                                                @foreach ($item->tipeAlat as $detail)
                                                                    <li>
                                                                        <span class="dot"></span>
                                                                        <span
                                                                            class="name">{{ ucwords($detail->nama_tipe) }}
                                                                        </span>
                                                                        <span
                                                                            class="qty">x{{ $detail->pivot->quantity }}
                                                                        </span>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge {{ badgeClass($item->status_pinjam) }} px-3 py-2 rounded-pill">
                                                            {{ ucwords($item->status_pinjam) }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade modal-validasi" id="modal-validasi" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content modal-premium">

                <!-- HEADER -->
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title fw-bold text-white">
                            <i class="fa-solid fa-file-zipper mr-2"></i>
                            Validasi Pengembalian
                        </h5>
                        <p class="text-white mb-0 small">
                            Periksa tipe alat, kode, dan kondisi masing-masing item alat
                        </p>
                    </div>

                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <form id="form-validasi" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="pinjam-card mb-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <span>ID Pinjam</span>
                                        <strong id="v-id-pinjam">-</strong>
                                    </div>
                                    <div class="info-item">
                                        <span>Nama Siswa</span>
                                        <strong id="v-nama-siswa">-</strong>
                                    </div>
                                    <div class="info-item">
                                        <span>Kelas</span>
                                        <strong id="v-kelas">-</strong>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <span>Tanggal Pinjam</span>
                                        <strong id="v-tanggal-mulai">-</strong>
                                    </div>
                                    <div class="info-item">
                                        <span>Batas Kembali</span>
                                        <strong id="v-batas-kembali">-</strong>
                                    </div>
                                    <div class="info-item">
                                        <span>Keterlambatan & Kelengkapan</span>
                                        <strong id="v-terlambat">-</strong>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="table-wrapper">
                            <div class="table-head">
                                <span>Tipe Alat</span>
                            </div>
                            <div id="v-alat">



                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-back" data-dismiss="modal">
                            <i class="fa-solid fa-circle-xmark"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-universal">
                            <i class="fa fa-thumbs-up mr-1"></i>
                            Validasi Pengembalian
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
    <script src="{{ asset('js/peminjaman.js') }}"></script>
    <script>
    //     /* =========================================
    //                        MODAL VALIDASI PENGEMBALIAN
    //                     ========================================= */
    // //     $('#modal-validasi').on('show.bs.modal', function(event) {

    // //         let button = $(event.relatedTarget);
    // //         let alatList = button.data('alat');

    // //         let idPinjam = button.data('id-pinjam');
    // //         let nama = button.data('nama-siswa');
    // //         let kelas = button.data('kelas');
    // //         let tglMulai = button.data('tanggal-mulai');
    // //         let batas = button.data('batas-kembali');
    // //         let terlambat = button.data('terlambat');


    // //         /* ========= SET DATA HEADER ========= */
    // //         $('#v-id-pinjam').text(idPinjam);
    // //         $('#v-nama-siswa').text(nama);
    // //         $('#v-kelas').text(kelas);
    // //         $('#v-tanggal-mulai').text(tglMulai);
    // //         $('#v-batas-kembali').text(batas);

    // //         $('#form-validasi').attr(
    // //             'action',
    // //             '/validasi/' + idPinjam
    // //         );


    // //         /* ========= HITUNG KELENGKAPAN ========= */
    // //         let total = alatList.length;
    // //         let kembali = 0;

    // //         alatList.forEach(function(alat) {
    // //             if (alat.pivot.is_kembali == 1) {
    // //                 kembali++;
    // //             }
    // //         });


    // //         /* ========= BADGE TERLAMBAT ========= */
    // //         let badgeTerlambat = '';

    // //         if (terlambat) {
    // //             badgeTerlambat = `
    // //                 <span class="badge badge-soft-danger rounded-pill px-2 py-1"
    // //                     style="font-size:11px;width:auto;">
    // //                     Terlambat
    // //                 </span>
    // //             `;
    // //         } else {
    // //             badgeTerlambat = `
    // //                 <span class="badge badge-soft-success rounded-pill px-2 py-1"
    // //                     style="font-size:11px;width:auto;">
    // //                     Tepat Waktu
    // //                 </span>
    // //             `;
    // //         }


    // //         /* ========= BADGE KELENGKAPAN ========= */
    // //         let badgeKelengkapan = '';

    // //         if (kembali == total) {
    // //             badgeKelengkapan = `
    // //         <span class="badge badge-soft-success rounded-pill px-2 py-1"
    // //             style="font-size:11px;width:auto;">
    // //             ${kembali}/${total} Lengkap
    // //         </span>
    // //     `;
    // //         } else {
    // //             badgeKelengkapan = `
    // //         <span class="badge badge-soft-danger rounded-pill px-2 py-1"
    // //             style="font-size:11px;width:auto;">
    // //             ${kembali}/${total} Tidak Lengkap
    // //         </span>
    // //     `;
    // //         }


    // //         /* ========= TAMPILKAN BADGE ========= */
    // //         $('#v-terlambat').html(`
    // //     <div class="d-flex align-items-center gap-2 flex-wrap mt-1">
    // //         ${badgeTerlambat}
    // //         ${badgeKelengkapan}
    // //     </div>
    // // `);


    // //         /* =====================================
    // //            GROUP TIPE ALAT
    // //         ===================================== */
    // //         let container = $('#v-alat');
    // //         container.html('');

    // //         let grouped = [];

    // //         alatList.forEach(alat => {

    // //             let tipeId = alat.tipe_alat.id_tipe;

    // //             let index = grouped.findIndex(
    // //                 item => item.id_tipe === tipeId
    // //             );

    // //             if (index === -1) {
    // //                 grouped.push({
    // //                     id_tipe: tipeId,
    // //                     nama_tipe: alat.tipe_alat.nama_tipe,
    // //                     items: [alat]
    // //                 });
    // //             } else {
    // //                 grouped[index].items.push(alat);
    // //             }
    // //         });


    // //         /* =====================================
    // //            RENDER ALAT
    // //         ===================================== */
    // //         grouped.forEach(tipe => {

    // //             let id = 'tipe_' + tipe.id_tipe;

    // //             let html = `
    // //     <div class="type-card">

    // //         <div class="type-header"
    // //              onclick="toggleDetail('${id}')">

    // //             <div class="type-title">
    // //                 <h6>
    // //                 ${tipe.nama_tipe.replace(/\b\w/g,
    // //                 huruf => huruf.toUpperCase())}
    // //                 </h6>
    // //             </div>

    // //             <div class="type-action">
    // //                 <span class="qty-pill">
    // //                     ${tipe.items.length}
    // //                 </span>
    // //             </div>

    // //         </div>

    // //         <div class="type-body collapse-detail"
    // //              id="${id}">

    // //             <div class="alat-table">

    // //                 <div class="alat-row head">
    // //                     <span>Kode</span>
    // //                     <span>Status</span>
    // //                     <span>Catatan</span>
    // //                 </div>
    // //     `;


    // //             tipe.items.forEach(alat => {

    // //                 html += `
    // //         <div class="alat-row">

    // //             <span class="kode-badge">
    // //                 ${alat.kode_alat}
    // //             </span>

    // //             <select
    // //               name="kondisi_kembali[${alat.id_detail_alat}]">

    // //                 <option value="baik" selected>
    // //                     Baik
    // //                 </option>

    // //                 <option value="rusak">
    // //                     Rusak
    // //                 </option>

    // //                 <option value="perlu perbaikan">
    // //                     Perlu Perbaikan
    // //                 </option>

    // //                 <option value="hilang">
    // //                     Hilang
    // //                 </option>

    // //             </select>

    // //             <input type="text"
    // //                 name="catatan[${alat.id_detail_alat}]"
    // //                 placeholder="Catatan...">

    // //         </div>
    // //         `;
    // //             });


    // //             html += `
    // //             </div>
    // //         </div>
    // //     </div>
    // //     `;

    // //             container.append(html);

    // //         });

    // //     });


    //     /* =========================================
    //        TOGGLE DETAIL ALAT
    //     ========================================= */
    //     // function toggleDetail(id) {
    //     //     let $el = $("#" + id);
    //     //     let $card = $el.closest(".type-card");
    //     //     let $icon = $card.find(".chevron");

    //     //     if ($el.is(":visible")) {
    //     //         $el.hide();
    //     //         $icon.css("transform", "rotate(0deg)");
    //     //     } else {
    //     //         $el.show();
    //     //         $icon.css("transform", "rotate(180deg)");
    //     //     }
    //     // }


    //     /* =========================================
    //        DATATABLE
    //     ========================================= */
    //     // function initDataTable(
    //     //     tableId,
    //     //     searchWrapperId,
    //     //     showEntriesId
    //     // ) {

    //     //     var table = $(tableId).DataTable({
    //     //         responsive: false,
    //     //         autoWidth: false,
    //     //         pageLength: 10,
    //     //         lengthChange: true,
    //     //         searching: true,
    //     //         dom: 'lfrtip',

    //     //         columnDefs: [{
    //     //             orderable: false,
    //     //             targets: 0
    //     //         }],

    //     //         language: {
    //     //             search: "",
    //     //             searchPlaceholder: "🔍 Search...",
    //     //             zeroRecords: "Data tidak ditemukan",
    //     //             info: "Showing _START_ to _END_ of _TOTAL_ entries",
    //     //             lengthMenu: "_MENU_",
    //     //             paginate: {
    //     //                 next: ">>",
    //     //                 previous: "<<"
    //     //             }
    //     //         }
    //     //     });

    //     //     $(searchWrapperId)
    //     //         .html($(tableId + '_filter').detach());

    //     //     $(showEntriesId)
    //     //         .html($(tableId + '_length').detach());

    //     //     $(showEntriesId)
    //     //         .prepend('<span class="mr-1">Show :</span>');
    //     // }


    //     // /* =========================================
    //     //    DOCUMENT READY
    //     // ========================================= */
    //     // $(document).ready(function() {

    //     //     initDataTable(
    //     //         '#table-menunggu',
    //     //         '#search-wrapper-menunggu',
    //     //         '#show-entries-menunggu'
    //     //     );

    //     //     initDataTable(
    //     //         '#table-siap-diambil',
    //     //         '#search-wrapper-siap-diambil',
    //     //         '#show-entries-siap-diambil'
    //     //     );

    //     //     initDataTable(
    //     //         '#table-aktif',
    //     //         '#search-wrapper-aktif',
    //     //         '#show-entries-aktif'
    //     //     );

    //     //     initDataTable(
    //     //         '#table-proses-pengembalian',
    //     //         '#search-wrapper-proses-pengembalian',
    //     //         '#show-entries-proses-pengembalian'
    //     //     );

    //     //     initDataTable(
    //     //         '#table-batal',
    //     //         '#search-wrapper-batal',
    //     //         '#show-entries-batal'
    //     //     );


    //     /* ========= TAB ANIMATION ========= */
    //     // function moveTab(el) {
    //     //     const $el = $(el);
    //     //     const parent = $el.closest('.nav-tabs');

    //     //     parent.css(
    //     //         '--x',
    //     //         $el.position().left + 'px'
    //     //     );

    //     //     parent.css(
    //     //         '--w',
    //     //         $el.outerWidth() + 'px'
    //     //     );
    //     // }

    //     // $('.nav-tabs .nav-link').on(
    //     //     'click',
    //     //     function() {
    //     //         setTimeout(
    //     //             () => moveTab(this),
    //     //             50
    //     //         );
    //     //     }
    //     // );

    //     // moveTab(
    //     //     $('.nav-tabs .nav-link.active')
    //     // );

    //     // $('.nav-tabs .nav-link').on(
    //     // 'mouseenter',
    //     // function() {
    //     //     moveTab(this);
    //     // }
    //     // );

    //     });


    //     /* =========================================
    //        DETAIL BUTTON
    //     ========================================= */
    //     // $(document).on(
    //     //     'click',
    //     //     '.btn-detail',
    //     //     function() {

    //     //         let detail = $(this)
    //     //             .siblings('.detail-alat');

    //     //         let icon = $(this).find('i');

    //     //         let isPlus =
    //     //             icon.hasClass('fa-plus');

    //     //         detail.stop(true, true)
    //     //             .slideToggle(220);

    //     //         $(this).toggleClass('active');

    //     //         if (isPlus) {
    //     //             icon.removeClass('fa-plus')
    //     //                 .addClass('fa-minus');
    //     //         } else {
    //     //             icon.removeClass('fa-minus')
    //     //                 .addClass('fa-plus');
    //     //         }

    //     //     });


    //     /* =========================================
    //        TOOLTIP
    //     ========================================= */
    //     // $(function() {
    //     //     $('[title]').tooltip({
    //     //         placement: 'top',
    //     //         offset: '0,3'
    //     //     });
    //     // });
    </script>
@endpush
