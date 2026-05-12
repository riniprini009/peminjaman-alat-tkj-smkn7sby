<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Export QR Code</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        .qr-container {
            width: 100%;
            text-align: center;
        }

        .qr-item {
            display: inline-block;
            width: 30%;
            margin: 10px;
            vertical-align: top;

            page-break-inside: avoid;
            /* 🔥 penting */
        }

        .qr-box {
            width: 120px;
            border: 3.5px solid #000000;
            padding: 3px;
            margin: auto;
            border-radius: 10px;

            page-break-inside: avoid;
            /* 🔥 double protection */
        }

        .qr-img {
            width: 120px;
        }

        .garis {
            width: calc(100% + 6px);
            height: 2.9px;
            background: #000;
            margin: 1px -3px;
        }

        .kode-wrapper {
            margin-top: 6px;
            text-align: center;
        }

        .logo-kecil {
            width: 40px;
            height: 40px;
            display: inline-block;
            vertical-align: middle;
            margin-right: 2px;
        }

        .kode {
            font-weight: bold;
            display: inline-block;
            vertical-align: middle;
            font-size: 1.3em;
        }

        .header-text {
            text-align: center;
        }

        .header-text h2 {
            margin: 0;
            line-height: 1.2;
        }

        .header-text p {
            margin: 2px 0 0 0;
            /* atas dikit biar mepet */
            line-height: 1.2;
        }

        .line {
            margin-top: 10px;
            margin-bottom: 20px;
        }

        .line .top {
            border-top: 3px solid black;
            /* tebal */
            margin-bottom: 3px;
        }

        .line .bottom {
            border-top: 1px solid black;
            /* tipis */
        }
    </style>
</head>

<body>
    <div class="header-text">
        <h2>Data QR Code</h2>
        <p>{{ ucwords($tipe->nama_tipe) }}</p>
    </div>


    <div class="line">
        <div class="top"></div>
        <div class="bottom"></div>
    </div>

    <div class="qr-container">
        @foreach ($details as $detail)
            <div class="qr-item">
                <div class="qr-box">
                    <img class="qr-img" src="{{ public_path($detail->qr_code) }}">
                    <div class="garis"></div>

                    <div class="kode-wrapper">
                        <img class="logo-kecil" src="{{ public_path('logo-smkn7-resmi.jpg') }}">
                        <span class="kode">{{ $detail->kode_alat }}</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</body>

</html>
