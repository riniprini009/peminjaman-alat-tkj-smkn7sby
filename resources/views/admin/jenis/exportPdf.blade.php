<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Data Jenis Alat</title>
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
        <h3>DATA JENIS ALAT</h3>
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
                <th width="30%">Jenis Alat</th>
                <th width="20%">Jumlah Tipe</th>
                <th width="20%">Total Alat</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($jenis as $index => $jns)
                <tr>
                    <td>{{ $index + 1 }}.</td>
                    <td class="text-left">{{ ucwords($jns->nama_jenis) }}</td>
                    <td>{{ $jns->tipeAlat->count() }}</td>
                    <td>{{ ucwords($jns->tipeAlat->sum('stok')) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
