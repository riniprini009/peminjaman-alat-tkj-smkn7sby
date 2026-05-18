{{-- <!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Login - SiPinjam</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{ asset('deskap/vendors/styles/core.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('deskap/vendors/styles/icon-font.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('deskap/vendors/styles/style.css') }}" />
    <link rel="stylesheet" href="{{ 'css/universal.css' }}">
    <link rel="stylesheet" href="{{ 'css/button.css' }}">
    <link rel="stylesheet" href="{{ 'css/login.css' }}">
</head>

<body class="login-page">
    <div class="login-header box-shadow">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <div class="brand-logo">
                <a href="#">
                    <img src="{{ asset('logo.png') }}" alt="" />
                </a>
            </div>
        </div>
    </div>
    <div class="login-wrap">
        <div class="container-fluid">
            <div class="row align-items-center justify-content-center">
                <div
                    class="col-12 col-lg-5 d-flex flex-column justify-content-center left-panel text-center text-lg-left">
                    <h1 class="title">
                        Sistem Informasi<br>
                        <span style="color:#3668a9">Peminjaman Alat Laboratorium</span>
                    </h1>
                    <p class="subtitle">
                        Jurusan Teknik Komputer Jaringan - SMKN 7 Surabaya
                    </p>
                </div>

                <div class="col-lg-5 d-flex justify-content-center p-0">
                    <div class="login-box m-0" style="width:100%; max-width:420px;">
                        <div class="login-title text-center mb-2">
                            <h2>Login</h2>
                            <p class="text-muted mb-3">Silakan masuk untuk melanjutkan</p>
                        </div>
                        @if (session('error'))
                            <div class="alert alert-danger text-center">
                                {{ session('error') }}
                            </div>
                        @endif
                        <form action="{{ route('login') }}" method="post">
                            @csrf
                            <div class="input-group custom">
                                <input type="text" class="form-control" placeholder="Username" name="username"
                                    required>
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="icon-copy dw dw-user1"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="input-group custom">
                                <input type="password" class="form-control" placeholder="Password" name="password"
                                    required>
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="dw dw-padlock1"></i>
                                    </span>
                                </div>
                            </div>
                            <button class="btn btn-universal btn-block" id="btn-login">
                                Masuk
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script>
        $('form').on('submit', function() {
            $('#btn-login')
                .prop('disabled', true)
                .text('Loading...');
        });

        setTimeout(function() {
            $('.alert').alert('close');
        }, 3000);
    </script>
</body>

</html>
 --}}


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SiPinjam</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{ asset('deskap/vendors/styles/core.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('deskap/vendors/styles/icon-font.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/button.css') }}" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            margin: 0;
            min-height: 100vh;
            background:
                radial-gradient(circle at top left, rgba(54, 104, 169, 0.15), transparent 35%),
                radial-gradient(circle at bottom right, rgba(54, 104, 169, 0.12), transparent 30%),
                #f5f7fb;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            overflow-x: hidden;
        }

        .login-container {
            width: 100%;
            max-width: 1100px;
            background: white;
            border-radius: 30px;
            overflow: hidden;
            display: flex;
            box-shadow: 0 25px 60px rgba(15, 23, 42, 0.12);
            min-height: 550px;
        }

        .left-side {
            width: 50%;
            background: linear-gradient(135deg, #3668a9 0%, #244d82 100%);
            color: white;
            padding: 70px;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .left-side::before {
            content: '';
            position: absolute;
            width: 280px;
            height: 280px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
            top: -80px;
            right: -80px;
        }

        .left-side::after {
            content: '';
            position: absolute;
            width: 220px;
            height: 220px;
            background: rgba(255, 255, 255, 0.06);
            border-radius: 50%;
            bottom: -60px;
            left: -60px;
        }

        .logo img {
            width: 70px;
            margin-bottom: 35px;
            position: relative;
            z-index: 2;
        }

        .title {
            font-size: 48px;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 20px;
            position: relative;
            z-index: 2;
            letter-spacing: 0.5px;
        }

        .desc {
            font-size: 16px;
            line-height: 1.8;
            opacity: .9;
            max-width: 480px;
            position: relative;
            z-index: 2;
        }

        .right-side {
            width: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 60px;
            background: #fff;
        }

        .login-box {
            width: 100%;
            max-width: 400px;
        }

        .login-box h2 {
            font-size: 36px;
            font-weight: 800;
            color: #111827;
            margin-bottom: 10px;
        }

        .login-box p {
            color: #6b7280;
            margin-bottom: 35px;
        }

        .form-group {
            margin-bottom: 22px;
        }

        .form-label {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 10px;
            color: #374151;
            display: block;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 18px;
        }

        .form-control {
            width: 100%;
            height: 58px;
            border-radius: 16px;
            border: 1.5px solid #e5e7eb;
            padding: 0 18px 0 50px;
            font-size: 15px;
            transition: .3s ease;
            box-shadow: none !important;
        }

        .form-control:focus {
            border-color: #3668a9;
            box-shadow: 0 0 0 5px rgba(54, 104, 169, 0.12) !important;
        }

        .btn-login {
            width: 100%;
            height: 53px;
            border: none;
            border-radius: 16px;
            background: #3668a9;
            color: white;
            font-size: 16px;
            font-weight: 700;
            transition: .3s ease;
            margin-top: 10px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            background: #2b568d;
            box-shadow: 0 15px 30px rgba(54, 104, 169, 0.25);
        }

        .alert {
            border-radius: 14px;
            margin-bottom: 20px;
        }



        body {
            margin: 0;
            min-height: 100vh;

            background:
                radial-gradient(circle at top left,
                    rgba(54, 104, 169, 0.18),
                    transparent 30%),

                radial-gradient(circle at bottom right,
                    rgba(79, 142, 220, 0.16),
                    transparent 35%),

                linear-gradient(135deg,
                    #eef4fb 0%,
                    #f7f9fc 50%,
                    #edf3fb 100%);

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 40px;
            overflow-x: hidden;

            position: relative;
        }



        body::before {
    content: '';

    position: fixed;
    inset: 0;

    background-image:
        radial-gradient(
            rgba(54, 104, 169, 0.18) 1.4px,
            transparent 1.4px
        );

    background-size: 34px 34px;

    opacity: .9;

    pointer-events: none;
}
        .login-container {
            width: 100%;
            max-width: 1100px;

            background: rgba(255, 255, 255, 0.82);

            backdrop-filter: blur(18px);

            border-radius: 32px;

            overflow: hidden;

            display: flex;

            border: 3.1px solid rgba(255, 255, 255, 0.5);

            box-shadow:
                0 30px 70px rgba(15, 23, 42, 0.12),
                0 10px 30px rgba(15, 23, 42, 0.06);

            min-height: 550px;
        }

        .title span {
            color: #aec3d2;

            text-shadow:
                0 1px 6px rgba(174, 195, 210, 0.2);
        }

        @media(max-width: 992px) {
            body {
                padding: 15px;
            }

            .login-container {
                flex-direction: column;
                min-height: auto;
            }

            .left-side,
            .right-side {
                width: 100%;
            }

            .left-side {
                padding: 50px 35px;
            }

            .right-side {
                padding: 45px 30px;
            }

            .title {
                font-size: 36px;
            }

            .brand img{
                margin-bottom: 10px;
            }
        }

        @media(max-width: 576px) {
            .left-side {
                padding: 40px 25px;
            }

            .right-side {
                padding: 35px 20px;
            }

            .title {
                font-size: 30px;
            }

            .login-box h2 {
                font-size: 30px;
            }

             .brand img{
                margin-bottom: 15px;
            }
        }

        .left-side {

            background: linear-gradient(135deg, #3668a9 0%, #244d82 100%);
            color: white;

            padding: 35px 55px;

            position: relative;

            display: flex;
            flex-direction: column;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 8px;

            position: relative;
            z-index: 2;

            margin-bottom: auto;
        }

        .brand img {
            width: 65px;
            height: 65px;

            object-fit: contain;
        }

        .brand-text {
            font-size: 24px;
            font-weight: 800;

            color: rgb(234, 231, 231);

            letter-spacing: 1.1px;
        }

        .left-content {
            flex: 1;

            display: flex;
            flex-direction: column;
            justify-content: center;

            position: relative;
            z-index: 2;

            text-align: left;
        }
    </style>
</head>

<body>

    <div class="login-container">
        <div class="left-side">

            <div class="brand">
                <img src="{{ asset('coba.png') }}" alt="Logo">

                <div class="brand-text">
                    SiPinjam
                </div>
            </div>

            <div class="left-content">
                <h1 class="title">
                    Sistem Informasi <br>
                    <span>Peminjaman Alat</span>
                </h1>

                <div class="desc">
                    Jurusan Teknik Komputer Jaringan - SMKN 7 Surabaya
                </div>
            </div>

        </div>
        {{-- <div class="left-side">
            <div class="logo">
                <img src="{{ asset('coba.png') }}" alt="Logo">
            </div>

            <h1 class="title">
                Sistem Informasi <br>
                <span>Peminjaman Alat</span>
            </h1>

            <div class="desc">
                Jurusan Teknik Komputer Jaringan - SMKN 7 Surabaya

            </div>
        </div> --}}

        <div class="right-side">
            <div class="login-box">

                <h2>Login</h2>
                <p>Silahkan Login untuk melanjutkan!</p>

                @if (session('error'))
                    <div class="alert alert-danger text-center" id="alert-error">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label class="form-label">Username</label>
                        <div class="input-wrapper">
                            <i class="icon-copy dw dw-user1"></i>
                            <input type="text" class="form-control" name="username" placeholder="Masukkan username"
                                required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <div class="input-wrapper">
                            <i class="dw dw-padlock1"></i>
                            <input type="password" class="form-control" name="password" placeholder="Masukkan password"
                                required>
                        </div>
                    </div>

                    <button type="submit" class="btn-login" id="btn-login">
                        Masuk
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        $('form').on('submit', function() {
            $('#btn-login')
                .prop('disabled', true)
                .html(`
                <span class="spinner-border spinner-border-sm mr-2"></span>
                Loading...
            `);
        });

        setTimeout(function() {
            $('#alert-error').fadeOut(400, function() {
                $(this).remove();
            });
        }, 3000);
    </script>

</body>

</html>
