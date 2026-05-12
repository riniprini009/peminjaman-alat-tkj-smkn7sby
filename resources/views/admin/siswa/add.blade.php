@extends('layouts.admin')
@section('title', 'Tambah Data Siswa')
@section('link')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/universal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/add.css') }}">
    <link rel="stylesheet" href="{{ asset('css/button.css') }}">
@endsection
@section('content')
    <div class="pd-ltr-20 xs-pd-20-10 pt-2">
        <div class="min-height-200px">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item d-flex align-items-center gap-1">
                                    <i class="fa-solid fa-house"></i>
                                    <a href="index.html">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="index.html">User</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="index.html">Data Siswa</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Tambah Data Siswa
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <section id="basic-horizontal-layouts p-0">
                <div class="row justify-content-center">
                    <div class="col-md-6 col-12">
                        <div class="card mb-2" style="border-radius: 10px;">
                            <div class="card-header">
                                <h5 class="mb-0 text-white"><i class="fa-solid fa-user-plus"></i>Tambah Data Siswa</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('siswa.store') }}" method="post">
                                    @csrf

                                    <!-- US phone mask -->
                                    <div class="form-group mb-0">
                                        <label for="nama_siswa">Nama Siswa</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                            </div>
                                            <input type="text" class="form-control" id="nama_siswa" name="nama_siswa"
                                                placeholder="Masukkan nama siswa" style="border-radius: 10px;" required>
                                        </div>
                                    </div>
                                    <!-- US phone mask -->
                                    <div class="form-group mb-0">
                                        <label for="nis">Nomor Induk Siswa</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="bi bi-card-heading"></i></span>
                                            </div>
                                            <input type="text" class="form-control" id="nis" name="nis"
                                                placeholder="Masukkan nis siswa" style="border-radius: 10px;" required>
                                        </div>
                                    </div>
                                    <!-- US phone mask -->
                                    <div class="form-group mb-0">
                                        <label for="kelas">Kelas</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="bi bi-mortarboard"></i></span>
                                            </div>
                                            <select name="kelas" id="kelas" name="kelas" required
                                                class="form-control" style="border-radius: 10px;">
                                                <option value="" disabled selected>--Pilih--</option>
                                                <option value="x tkj 1">X TKJ 1</option>
                                                <option value="x tkj 2">X TKJ 2</option>
                                                <option value="x tkj 3">X TKJ 3</option>
                                                <option value="x tkj 4">X TKJ 4</option>
                                                <option value="x tkj 5">X TKJ 5</option>
                                                <option value="x tkj 6">X TKJ 6</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group mb-0">
                                        <label for="jenis_kelamin">Jenis Kelamin</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="bi bi-gender-ambiguous"></i></span>
                                            </div>
                                            <select name="jenis_kelamin" id="jenis_kelamin" name="jenis_kelamin" required
                                                class="form-control" style="border-radius: 10px;">
                                                <option value="" disabled selected>--Pilih--</option>
                                                <option value="laki-laki">Laki-Laki</option>
                                                <option value="perempuan">Perempuan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group mt-4 d-flex justify-content-end mb-1 gap-2">
                                        <a href="{{ route('siswa.index') }}" class="btn-action btn-back mr-2">
                                            <i class="fa fa-times"></i>
                                            Batal
                                        </a>
                                        <button type="submit" class="btn-action btn-universal">
                                            <i class="fa fa-check"></i>
                                            Submit
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
{{-- @section('modal')
    
@endsection --}}
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $(document).ready(function() {
            @if (session('error'))
                toastr.error("{{ session('error') }}", "Terjadi Kesalahan", {
                    timeOut: 5000, // 5 detik
                    progressBar: true,
                    closeButton: true
                });
            @endif
        });
    </script>
@endpush
