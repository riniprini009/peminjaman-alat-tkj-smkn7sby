<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Data Tipe Alat</title>
    <style>
        {!! file_get_contents(public_path('css/export.css')) !!}
    </style>
</head>

<body>
    <div class="kop">
        <div class="kop-left">
            <img src="{{ public_path('logo-smkn7-resmi.jpg') }}" class="logo">
        </div>
        <div class="kop-center">
            <div class="sekolah">SMK NEGERI 7 SURABAYA</div>
            <div class="jurusan">Jurusan Teknik Komputer & Jaringan</div>
            <div class="alamat">Jl. Pawiyatan No.2, Bubutan, Surabaya, Jawa Timur 60174</div>
            <div class="alamat">Telp: (031) 534240 | Email: smknegeri7sby@yahoo.com</div>
        </div>
        <div class="kop-right"></div>
    </div>
    <div class="line">
        <div class="top"></div>
        <div class="bottom"></div>
    </div>
    <div class="title">
        <h3>DATA TIPE ALAT</h3>
    </div>

    <div style="text-align:center;">
        <div class="subtitle">
            Update Terakhir: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th width="5%">No.</th>
                <th width="30%">Tipe Alat</th>
                <th width="20%">Stok</th>
                <th width="20%">Lokasi Rak</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tipes as $index => $tipe)
                <tr>
                    <td>{{ $index + 1 }}.</td>
                    <td class="text-left">{{ ucwords($tipe->nama_tipe) }}</td>
                    <td>{{ $tipe->stok }}</td>
                    <td>{{ ucwords($tipe->lokasi_rak) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
