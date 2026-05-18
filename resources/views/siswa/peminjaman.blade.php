@extends('layouts.siswa')
@section('title', 'Peminjaman')
@section('link')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/content.css') }}">
    <link rel="stylesheet" href="{{ asset('css/universal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/table.css') }}">
    <style>
        table td:last-child {
            text-align: left !important;
        }
    </style>
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
                            <h4>Peminjaman</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><i class="bx bx-home"></i>
                                    <a href="{{ route('dashboardSiswa.index') }}">Dashboard Siswa</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Peminjaman
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
                                                            <a href="{{ route('peminjaman.scan', $item->id_pinjam) }}"><button
                                                                    type="button" class="btn btn-camera-soft"
                                                                    title="Scan"
                                                                    {{ !$item->cameraActive() ? 'disabled title=Belum masuk waktu scan' : '' }}>
                                                                    <i class="fa-solid fa-camera"></i>
                                                                </button></a>
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
                                                <th>Tanggal Pemakaian</th>
                                                <th>Batas Pengembalian</th>
                                                <th>Keterlambatan</th>
                                                <th>Status</th>
                                                <th>Alat</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($peminjamanAktif as $index => $item)
                                                <tr>
                                                    <td>
                                                        <div class="no-badge">{{ $index + 1 }}.</div>
                                                    </td>
                                                    <td>PJM-0{{ $item->id_pinjam }}</td>
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
                                                    <td> <a href="{{ route('peminjamanSiswa.prosesPengembalian', $item->id_pinjam) }}"
                                                            class="btn btn-camera-soft" title="Scan">
                                                            <i class="fa-solid fa-camera"></i>
                                                        </a></td>
                                                    {{-- <td class="td-detail">
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
                                                    </td> --}}
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
                                                <th>Tanggal Pemakaian</th>
                                                <th>Batas Pengembalian</th>
                                                <th>Keterlambatan</th>
                                                <th>Status</th>
                                                <th>Alat</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($peminjamanProsesPengembalian as $index => $item)
                                                <tr>
                                                    <td>
                                                        <div class="no-badge">{{ $index + 1 }}.</div>
                                                    </td>
                                                    <td>PJM-0{{ $item->id_pinjam }}</td>
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
                                                    <td>{{ $item->jadwalFormat() }}</td>
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
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="{{asset('js/peminjaman.js')}}"></script>
    <script>
        @if (session('error'))
            toastr.error("{{ session('error') }}");
        @endif

        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @endif
    </script>
    {{-- <script>
        function initDataTable(tableId, searchWrapperId, showEntriesId) {
            let table = $(tableId).DataTable({
                responsive: false,
                autoWidth: false,
                pageLength: 10,
                lengthChange: true,
                searching: true,
                dom: 'lfrtip',

                columnDefs: [{
                    orderable: false,
                    targets: 0
                }],

                language: {
                    search: "",
                    searchPlaceholder: "🔍 Search...",
                    zeroRecords: "Data tidak ditemukan",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    lengthMenu: "_MENU_",
                    paginate: {
                        next: ">>",
                        previous: "<<"
                    }
                }
            });
            $(searchWrapperId).html($(tableId + '_filter').detach());
            $(showEntriesId).html($(tableId + '_length').detach()).prepend('<span class="mr-1">Show :</span>');

            return table;
        }

        // ===================== TAB INDICATOR =====================
        function moveTab(el) {
            let $el = $(el);
            let $parent = $el.closest('.nav-tabs');

            $parent.css({
                '--x': $el.position().left + 'px',
                '--w': $el.outerWidth() + 'px'
            });
        }

        // ===================== DOCUMENT READY =====================
        $(document).ready(function() {

            // ===== INIT TABLE =====
            initDataTable('#table-menunggu', '#search-wrapper-menunggu', '#show-entries-menunggu');
            initDataTable('#table-siap-diambil', '#search-wrapper-siap-diambil', '#show-entries-siap-diambil');
            initDataTable('#table-aktif', '#search-wrapper-aktif', '#show-entries-aktif');
            initDataTable('#table-proses-pengembalian', '#search-wrapper-proses-pengembalian',
                '#show-entries-proses-pengembalian');
            initDataTable('#table-batal', '#search-wrapper-batal', '#show-entries-batal');

            // ===== TAB CLICK =====
            $('.nav-tabs .nav-link').on('click', function() {
                setTimeout(() => moveTab(this), 50);
            });

            // ===== INIT TAB POSITION =====
            moveTab($('.nav-tabs .nav-link.active'));

            // ===== HOVER EFFECT =====
            $('.nav-tabs .nav-link').on('mouseenter', function() {
                moveTab(this);
            });

        });

        // ===================== DETAIL TOGGLE =====================

        $(document).on('click', '.btn-detail', function() {

            let detail = $(this).siblings('.detail-alat');
            let icon = $(this).find('i');
            let isPlus = icon.hasClass('fa-plus');

            detail.stop(true, true).slideToggle(220);

            $(this).toggleClass('active');
            if (isPlus) {
                icon.removeClass('fa-plus').addClass('fa-minus');
            } else {
                icon.removeClass('fa-minus').addClass('fa-plus');
            }
        });
    </script> --}}
@endpush


