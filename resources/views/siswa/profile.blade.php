@extends('layouts.siswa')

@section('title', 'Profil Siswa')

@section('link')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/content.css') }}">
    <link rel="stylesheet" href="{{ asset('css/universal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/button.css') }}">
    <style>
        body {
            background: radial-gradient(circle at top, #eef2ff, #f8fafc);
        }


        .profile-wrapper {
            max-width: 1000px;
            margin: auto;

        }

        /* MAIN CARD */
        .profile-card {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(18px);
            border-radius: 26px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.08);
            padding: 30px;
            border: 1px solid rgba(255, 255, 255, 0.4);
            overflow: hidden;
            position: relative;
        }



        /* HEADER */
        .profile-header {
            display: flex;
            align-items: center;
            gap: 18px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.06);
        }

        .avatar {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: #2980b9;
            /* fallback for old browsers */
            background: -webkit-linear-gradient(to right,
                    #2c3e50,
                    #2980b9);
            /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to right, #2c3e50, #2980b9);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 30px;
            font-weight: 700;
            box-shadow: 0 10px 30px rgba(99, 102, 241, 0.35);
            position: relative;
        }

        .avatar::after {
            content: "";
            position: absolute;
            inset: -5px;
            border-radius: 50%;
            border: 2px solid #426382c7;
        }

        .info-title {
            font-size: 22px;
            font-weight: 700;
            color: #111827;
            margin: 0;
        }

        .info-sub {
            font-size: 13px;
            color: #6b7280;
        }

        /* GRID INFO */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 14px;
            margin-top: 22px;
        }

        .info-box {
            background: rgba(249, 250, 251, 0.8);
            padding: 14px;
            border-radius: 14px;
            transition: 0.25s;
            border: 1px solid rgba(0, 0, 0, 0.04);
        }

        .info-box:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.06);
            background: white;
        }

        .label {
            font-size: 11px;
            color: #9ca3af;
            margin-bottom: 4px;
        }

        .value {
            font-weight: 600;
            color: #111827;
            font-size: 14px;
        }

        /* SECTION */
        .form-section {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px dashed rgba(0, 0, 0, 0.1);
        }

        .form-title {
            font-size: 15px;
            font-weight: 700;
            margin-bottom: 14px;
            color: #111827;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* INPUT */
        .form-control {
            border-radius: 14px;
            height: 44px;
            font-size: 14px;
            border: 1px solid #e5e7eb;
            transition: 0.2s;
        }

        .form-control:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.12);
        }

        /* BUTTONS */
        .btn-modern {
            border-radius: 14px;
            padding: 10px 16px;
            font-weight: 600;
            transition: 0.25s;
            border: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #6366f1, #4338ca);
            color: white;
            box-shadow: 0 10px 20px rgba(99, 102, 241, 0.25);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(99, 102, 241, 0.35);
        }

        .btn-success {
            background: linear-gradient(135deg, #22c55e, #15803d);
            color: white;
            box-shadow: 0 10px 20px rgba(34, 197, 94, 0.25);
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(34, 197, 94, 0.35);
        }

        /* RESPONSIVE */
        @media(max-width: 768px) {
            .info-grid {
                grid-template-columns: 1fr;
            }

            .profile-header {
                flex-direction: column;
                text-align: center;
            }
        }

        .form-section {
            height: 100%;
        }

        /* WRAPPER BIAR ADA JARAK */
        .row.mt-3 {
            margin-top: 25px !important;
        }

        /* FORM CARD */
        .form-section {
            background: rgba(255, 255, 255, 0.65);
            backdrop-filter: blur(14px);
            border-radius: 18px;
            padding: 20px;
            border: 1px solid rgba(255, 255, 255, 0.4);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        /* GLOW EFFECT */
        .form-section::before {
            content: "";
            position: absolute;
            width: 180px;
            height: 180px;
            /* background: radial-gradient(circle, rgba(99, 102, 241, 0.25), transparent 70%);
                                            top: -60px;
                                            right: -60px;
                                            filter: blur(10px); */
        }

        /* HOVER CARD */
        .form-section:hover {
            transform: translateY(-5px) scale(1.01);
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.08);
        }

        /* TITLE */
        .form-title {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 15px;
            color: #111827;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* INPUT */
        .form-control {
            border-radius: 14px;
            height: 44px;
            border: 1px solid #e5e7eb;
            transition: all 0.25s ease;
            background: #fff;
        }

        /* INPUT FOCUS */
        .form-control:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15);
            transform: scale(1.02);
        }

        /* BUTTON BASE */
        .btn-modern {
            border-radius: 14px;
            font-weight: 600;
            padding: 10px;
            transition: all 0.25s ease;
            position: relative;
            overflow: hidden;
        }

        /* BUTTON GRADIENT */
        .btn-primary {
            background: linear-gradient(135deg, #6366f1, #4338ca);
            border: none;
            box-shadow: 0 10px 25px rgba(99, 102, 241, 0.3);
        }

        .btn-success {
            background: linear-gradient(135deg, #22c55e, #15803d);
            border: none;
            box-shadow: 0 10px 25px rgba(34, 197, 94, 0.3);
        }

        /* BUTTON HOVER */
        .btn-modern:hover {
            transform: translateY(-2px);
        }

        /* SHINE EFFECT */
        .btn-modern::after {
            content: "";
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(120deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transition: 0.6s;
        }

        .btn-modern:hover::after {
            left: 100%;
        }

        /* ANIMASI MASUK */
        .form-section {
            animation: fadeUp 0.5s ease;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* WRAPPER SPACING */
        .row.mt-3 {
            margin-top: 30px !important;
        }

        /* FORM CARD PREMIUM */
        .form-section {
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.7), rgba(255, 255, 255, 0.4));
            backdrop-filter: blur(18px);
            border-radius: 20px;
            padding: 22px;
            border: 1px solid rgba(255, 255, 255, 0.5);
            position: relative;
            overflow: hidden;
            transition: all 0.35s ease;
        }

        /* TOP ACCENT LINE */
        .form-section::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            height: 3px;
            width: 100%;
            background: #2c3e50;
            /* fallback */
            background: -webkit-linear-gradient(to right, #243447, #2e6f9e);

            background: linear-gradient(to right, #243447, #2e6f9e);
            opacity: 0.8;
        }


        /* SOFT GLOW */
        .form-section::before {
            content: "";
            position: absolute;
            width: 220px;
            height: 220px;
            /* background: radial-gradient(circle, rgba(99, 102, 241, 0.25), transparent 70%); */
            top: -80px;
            right: -80px;
            filter: blur(12px);
            opacity: 0.7;
        }

        /* HOVER EFFECT */
        .form-section:hover {
            transform: translateY(-6px) scale(1.015);
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.12);
        }

        /* TITLE UPGRADE */
        .form-title {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 16px;
            color: #111827;
            letter-spacing: 0.3px;
        }

        /* INPUT PREMIUM */
        .form-control {
            border-radius: 14px;
            height: 46px;
            border: 1px solid #e5e7eb;
            padding: 0 14px;
            font-size: 14px;
            transition: all 0.25s ease;
            background: rgba(255, 255, 255, 0.9);
        }

        /* INPUT HOVER */
        .form-control:hover {
            border-color: #6366f1;
        }

        /* INPUT FOCUS */
        .form-control:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15);
            transform: scale(1.02);
        }

        /* BUTTON BASE */
        .btn-modern {
            border-radius: 14px;
            font-weight: 600;
            padding: 11px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            letter-spacing: 0.3px;
        }

        /* BUTTON DEPTH */
        .btn-primary {
            background: linear-gradient(135deg, #6366f1, #4338ca);
            box-shadow: 0 12px 25px rgba(99, 102, 241, 0.35);
        }

        .btn-success {
            background: linear-gradient(135deg, #22c55e, #15803d);
            box-shadow: 0 12px 25px rgba(34, 197, 94, 0.35);
        }

        /* BUTTON HOVER */
        .btn-modern:hover {
            transform: translateY(-3px) scale(1.02);
        }

        /* BUTTON CLICK EFFECT */
        .btn-modern:active {
            transform: scale(0.97);
        }

        /* SHINE ANIMATION */
        .btn-modern::after {
            content: "";
            position: absolute;
            top: 0;
            left: -120%;
            width: 120%;
            height: 100%;
            background: linear-gradient(120deg,
                    transparent,
                    rgba(255, 255, 255, 0.5),
                    transparent);
            transition: 0.6s;
        }

        .btn-modern:hover::after {
            left: 120%;
        }

        /* STAGGER ANIMATION */
        .form-section:nth-child(1) {
            animation: fadeUp 0.5s ease;
        }

        .form-section:nth-child(2) {
            animation: fadeUp 0.7s ease;
        }

        /* ANIMATION */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(25px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* WRAPPER CLEAN PREMIUM */
        .profile-wrapper {
            max-width: 1000px;
            margin: 25px auto 30px;
            padding: 0 10px;
            position: relative;
        }

        /* BACKGROUND SUBTLE (TIDAK GANGGU) */
        .profile-wrapper::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(120deg,
                    rgba(99, 102, 241, 0.06),
                    rgba(99, 102, 241, 0.06));
            border-radius: 30px;
            z-index: 0;
        }

        /* CARD LEBIH TEGAS */
        .profile-card {
            position: relative;
            z-index: 2;
            background: #ffffff;
            border-radius: 24px;
            padding: 32px;
            border: 1px solid #e5e7eb;
            box-shadow:
                0 10px 25px rgba(0, 0, 0, 0.05),
                0 2px 6px rgba(0, 0, 0, 0.03);
        }

        /* HEADER LEBIH RAPAT & PROFESSIONAL */
        .profile-header {
            gap: 16px;
            padding-bottom: 18px;
            border-bottom: 1px solid #f1f5f9;
        }

        /* INFO GRID LEBIH RAPAT */
        .info-grid {
            gap: 12px;
        }

        /* INFO BOX CLEAN */
        .info-box {
            background: #eff1f376;
            border-radius: 12px;
            padding: 12px 14px;
            border: 1px solid #f1f5f9;
        }

        /* FORM SECTION CLEAN */
        .form-section {
            background: #ffffff;
            border-radius: 16px;
            padding: 18px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.03);
        }

        /* TITLE LEBIH TEGAS */
        .form-title {
            font-size: 15px;
            font-weight: 600;
            color: #111827;
        }

        /* INPUT CLEAN */
        .form-control {
            border-radius: 10px;
            height: 42px;
            border: 1px solid #e5e7eb;
            background: #fff;
        }

        /* FOCUS MINIMAL */
        .form-control:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.08);
        }

        /* BUTTON LEBIH ELEGAN */
        .btn-modern {
            border-radius: 10px;
            padding: 10px;
            font-weight: 600;
            font-size: 14px;
        }

        /* PRIMARY */
        .btn-primary {
            background: #6366f1;
            box-shadow: 0 4px 10px rgba(99, 102, 241, 0.2);
        }

        /* SUCCESS */
        .btn-success {
            background: #22c55e;
            box-shadow: 0 4px 10px rgba(34, 197, 94, 0.2);
        }

 
    </style>
@endsection

@section('content')
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="page-header mb-0">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="title">
                            <h4>Profil</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><i class="bx bx-home"></i>
                                    <a href="#">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Profil
                                </li>
                            </ol>
                        </nav>
                    </div>

                </div>
            </div>
            <div class="profile-wrapper">

                <div class="profile-card">

                    <!-- HEADER -->
                    <div class="profile-header">
                        <div class="avatar">
                            {{ collect(explode(' ', trim($siswa->nama_siswa)))->filter()->map(fn($kata) => strtoupper(substr($kata, 0, 1)))->take(2)->implode('') ?:
                                'NA' }}
                        </div>

                        <div>
                            <h4 class="info-title">{{ strtoupper($siswa->nama_siswa) }}</h4>
                            <div class="info-sub">{{ $siswa->akunUser->username }} •
                                {{ ucwords($siswa->akunUser->status_akun) }}
                            </div>
                        </div>
                    </div>

                    <!-- INFO -->
                    <div class="info-grid">

                        <div class="info-box">
                            <div class="label">Nama Lengkap</div>
                            <div class="value">{{ ucwords($siswa->nama_siswa) }}</div>
                        </div>

                        <div class="info-box">
                            <div class="label">Nomor Induk Siswa</div>
                            <div class="value">{{ $siswa->nis }}</div>
                        </div>

                        <div class="info-box">
                            <div class="label">Kelas</div>
                            <div class="value">{{ strtoupper($siswa->kelas) }}</div>
                        </div>

                        <div class="info-box">
                            <div class="label">Jenis Kelamin</div>
                            <div class="value">{{ ucwords($siswa->jenis_kelamin) }}</div>
                        </div>

                    </div>
                    <div class="row mt-3">

                        <!-- PASSWORD (KIRI) -->
                        <div class="col-md-6">
                            <div class="form-section h-100 m-0">
                                <div class="form-title">🔒 Ganti Password</div>

                                <form action="{{ route('profile.updatePassword', $siswa->akunUser->id_akun_user) }}"
                                    method="post">
                                    @method('PUT')
                                    @csrf
                                    <div class="row g-2">
                                        <div class="col-12 pb-3">
                                            <input type="password" class="form-control" placeholder="Password baru"
                                                name="password_baru">
                                        </div>
                                        <div class="col-12 pb-3">
                                            <input type="password" class="form-control" placeholder="Konfirmasi password"
                                                name="conf_pwd">
                                        </div>
                                        <div class="col-12 mt-1">
                                            <button class="btn btn-universal w-100" type="submit">
                                                Update Password
                                            </button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>

                        <!-- USERNAME (KANAN) -->
                        <div class="col-md-6">
                            <div class="form-section h-100 m-0">
                                <div class="form-title">🧑‍💻 Ganti Username</div>

                                <form action="{{ route('profile.updateUsername', $siswa->akunUser->id_akun_user) }}"
                                    method="post">
                                    @method('PUT')
                                    @csrf
                                    <div class="row g-2">
                                        <div class="col-12 pb-3">
                                            <input type="text" class="form-control" placeholder="Username baru"
                                                name="username_baru">
                                        </div>
                                        <div class="col-12 pb-3">
                                            <input type="text" class="form-control" placeholder="Konfirmasi username"
                                                name="conf_username">
                                        </div>
                                        <div class="col-12 mt-1">
                                            <button class="btn btn-universal-back w-100" type="submit">
                                                Update Username
                                            </button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>

@endsection
@section('modal')
    <div class="modal fade" id="update-success" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content text-center p-4">
                <div class="modal-body font-18">
                    <h3 class="mb-20">Update Berhasil!</h3>
                    <div class="mb-30">
                        <img src="{{ asset('deskap/vendors/images/success.png') }}" alt="success" />
                    </div>
                    <p id="update-success-text"></p>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    {{-- <script src="{{ asset('deskap/src/plugins/sweetalert2/sweetalert2.all.js') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if (session('update_success'))
            $('#update-success-text').html(
                '{{ session('update_success') }}'
            );

            $('#update-success').modal('show');

            setTimeout(function() {
                $('#update-success').modal('hide');
            }, 3000);
        @endif
    </script>
@endpush
