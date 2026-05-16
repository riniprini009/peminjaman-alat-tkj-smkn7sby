@extends('layouts.admin')
@section('title', 'Daftar Alat')
@section('link')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('deskap/src/plugins/switchery/switchery.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/content.css') }}">
    <link rel="stylesheet" href="{{ asset('css/universal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/daftarAlat.css') }}">
    <link rel="stylesheet" href="{{ asset('css/filter.css') }}">
    <link rel="stylesheet" href="{{ asset('css/table.css') }}">
    <link rel="stylesheet" href="{{ asset('css/button.css') }}">
@endsection
@section('content')
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="title">
                            <h4>Daftar Alat</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><i class="bx bx-home"></i>
                                    <a href="#">Dashboard Admin</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Daftar Alat
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="card-body p-4 card-input mb-4">
                <div class="row mx-0 gx-3 gy-2">

                    <!-- TANGGAL -->
                    <div class="col-md-3">
                        <label class="filter-label">Tanggal Pakai</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-date text-white border-0">
                                    <i class="bi bi-calendar"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control border-left-0 form-input" id="tanggal-mulai"
                                placeholder="Pilih Tanggal">
                        </div>
                    </div>

                    <!-- JAM -->
                    <div class="col-md-3">
                        <label class="filter-label">Jam Pakai</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-time text-white border-0">
                                    <i class="bi bi-clock"></i>
                                </span>
                            </div>
                            <select id="jam-mulai" class="form-control border-left-0 form-input">
                                <option value="" disabled selected>Pilih Jam</option>
                                <option value="07:00:00">07:00</option>
                                <option value="07:45:00">07:45</option>
                                <option value="08:30:00">08:30</option>
                                <option value="09:15:00">09:15</option>
                                <option value="10:00:00">10:00</option>
                                <option value="10:45:00">10:45</option>
                                <option value="11:30:00">11:30</option>
                                <option value="12:00:00">12:00</option>
                                <option value="10:55:00">10:55</option>
                                <option value="13:00:00">13:00</option>
                                <option value="13:45:00">13:45</option>
                                <option value="14:30:00">14:30</option>
                                <option value="15:15:00">15:15</option>
                            </select>
                        </div>
                    </div>

                    <!-- JENIS -->
                    <div class="col-md-3">
                        <label class="filter-label">Jenis</label>
                        <select id="filterJenis" class="form-control form-input">
                            <option value="">All Jenis</option>
                            @foreach ($jenis as $jns)
                                <option value="{{ $jns->nama_jenis }}">{{ ucwords($jns->nama_jenis) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- TIPE -->
                    <div class="col-md-3">
                        <label class="filter-label">Tipe</label>
                        <select id="filterTipe" class="form-control form-input">
                            <option value="">All Tipe</option>
                            @foreach ($tipes as $tipe)
                                <option value="{{ $tipe->nama_tipe }}">{{ ucwords($tipe->nama_tipe) }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="footer p-0">
                    <button type="button" class="btn btn-universal mr-2 mb-2" id="btn-cari"><i
                            class="fa-solid fa-magnifying-glass"></i>Cari</button>
                    <button type="reset" class="btn btn-back mb-2" id="btn-reset"><i
                            class="fa-solid fa-arrow-rotate-left"></i>Reset</button>
                </div>
            </div>
            <div class="box-ketersediaan" id="box-ketersediaan">
                <div id="section-ketersediaan">
                    <div class="box m-0 border-0">
                        <div class="row align-items-center">
                            <div
                                class="col-12 d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-2 gap-2 mt-1">
                                <h6 id="info-tanggal-jam" class="info-premium mb-0 d-flex align-items-center flex-nowrap">
                                    <i class="bi bi-calendar2-week"></i>
                                    <span class="title">Ketersediaan Alat</span>
                                    <span class="divider"></span>
                                    <span id="tanggal" class="chip chip-date"></span>
                                    <span id="jam" class="chip chip-time"></span>
                                </h6>
                                <div class="d-flex flex-wrap align-items-center" style="gap:10px;">
                                    <div class="toolbar-wrapper">
                                        <div class="search-wrapper mb-2">
                                            <i class="fa fa-search search-wrapper-icon"></i>
                                            <input type="text" class="form-control search-box-wrapper"
                                                placeholder="Search..." id="searchInput">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-between align-items-center mb-1">
                                <div id="show-entries" class="ml-0"></div>
                                <div class="d-flex align-items-center">
                                    <span class="mr-2"><i class="bi bi-list"></i></span>
                                    <input type="checkbox" class="switch-btn" id="toggle-view" />
                                    <span class="ml-2"><i class="bi bi-grid"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="view-table">
                        <div class="table-responsive p-0 m-0">
                            <table class="table table-hover  mb-0 data-table py-3 px-4 border-0"
                                style="background: #e9edf9b1 !important; border-radius: 22px;">
                                <thead class="thead-light">
                                    <tr>
                                        <th>No.</th>
                                        <th>Tipe Alat</th>
                                        <th>Jenis Alat</th>
                                        <th>Ketersediaan</th>
                                      
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tipes as $index => $tipe)
                                        <tr class="alat-table" data-id="{{ $tipe->id_tipe }}"
                                            data-nama="{{ ucwords($tipe->nama_tipe) }}"
                                            data-jenis="{{ ucwords($tipe->jenisAlat->nama_jenis) }}">
                                            <td>
                                                <div class="no-badge">{{ $index + 1 }}.</div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0 " style="width:40px;">
                                                        <img src="{{ asset('storage/' . $tipe->gambar) }}"
                                                            alt="{{ ucwords($tipe->nama_tipe) }}"
                                                            style="width:40px; height:40px; object-fit:cover; border-radius:4px;">
                                                    </div>
                                                    <div class="ms-2 pl-2">
                                                        <span class="fw-bold text-truncate "
                                                            style="max-width: 150px;">{{ ucwords($tipe->nama_tipe) }}</span>

                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ ucwords($tipe->jenisAlat->nama_jenis) }}</td>
                                            <td>
                                                @if ($tipe->stok > 0)
                                                    <span class="status-pill available stok-tersedia">Tersedia
                                                        :
                                                        {{ $tipe->stok }}</span>
                                                @else
                                                    <span class="status-pill empty stok-tersedia">Tidak Tersedia</span>
                                                @endif
                                            </td>
                                           
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div id="view-card">
                        <div class="card border-0" style="background: #e9edf9b1 !important; border-radius: 22px;">
                            <div class="row clearfix mt-4 mb-3 mx-3">
                                @foreach ($tipes as $tipe)
                                    <div class="col-lg-3 col-md-6 col-sm-12 mb-30">
                                        <div class="da-card alat-card" data-id="{{ $tipe->id_tipe }}"
                                            data-jenis="{{ strtolower($tipe->jenisAlat->nama_jenis) }}"
                                            data-nama="{{ strtolower($tipe->nama_tipe) }}">
                                            <div class="da-card-photo image-wrapper">
                                                <img src="{{ asset('storage/' . $tipe->gambar) }}"
                                                    alt="{{ $tipe->nama_tipe }}" />
                                            </div>
                                            <div class="kop-line"></div>
                                            <div class="da-card-content pb-0">
                                                <h5 class="h5 text-center">{{ $tipe->nama_tipe }}</h5>
                                                <p class="mb-0 text-center">{{ $tipe->jenisAlat->nama_jenis }}
                                                </p>
                                            </div>
                                            <div class="mt-2 mb-2 text-center">
                                                @if ($tipe->stok > 0)
                                                    <span class="status-pill available stok-tersedia">Tersedia
                                                        :
                                                        {{ $tipe->stok }}</span>
                                                @else
                                                    <span class="status-pill empty stok-tersedia">Tidak Tersedia</span>
                                                @endif
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between gap-2">
                                                <div class="qty-box d-flex align-items-center mt-2 mb-3 mx-3">
                                                    <button class="qty-btn btn-kurang" disabled>-</button>
                                                    <input type="number" value="1" min="1"
                                                        data-stok="{{ $tipe->stok }}" class="qty-input jumlah"
                                                        style="text-align: center;  width: 25px;" readonly>
                                                    <button class="qty-btn btn-tambah">+</button>
                                                </div>
                                                {{-- <div>
                                                    <button type="button" class="btn btn-custom btn-pinjam m-3"
                                                        data-id="{{ $tipe->id_tipe }}">
                                                        Pinjam
                                                    </button>
                                                </div> --}}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="alert-box" class="alert alert-danger alert-dismissible fade show d-none" role="alert"
        style="position: fixed; top: 70px; right: 15px; min-width: 250px; z-index: 1050; background-color: #f8d7da; color: #842029; border-color: #f5c2c7;">
        <i class="bi bi-exclamation-circle mr-2"></i>
        <span id="alert-message"></span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="{{ asset('deskap/src/plugins/switchery/switchery.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
    <script src="{{ asset('deskap/src/plugins/sweetalert2/sweetalert2.all.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('js/daftarAlat.js') }}"></script>


    <script>
        @if (session('success'))
            toastr.success(
                "{{ session('success') }}",
                "Berhasil", {
                    progressBar: true,
                    closeButton: true,
                    timeOut: 3000,
                    positionClass: "toast-top-right"
                }
            );
        @endif
    </script>
@endpush
