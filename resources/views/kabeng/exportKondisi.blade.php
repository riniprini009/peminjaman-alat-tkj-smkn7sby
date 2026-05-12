<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Kondisi Alat</title>
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
        <h3>DATA KONDISI ALAT BERMASALAH</h3>
    </div>

    <div style="text-align:center;">
        <div class="subtitle">
            Update Terakhir: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Jenis Alat</th>
                <th>Tipe Alat</th>

                <th>Kondisi Perlu Perbaikan</th>
                <th>Kondisi Rusak</th>
                <th>Kondisi Hilang</th>

            </tr>
        </thead>
        <tbody>

            @foreach ($kondisis as $item)
                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td class="text-left">
                        {{ ucwords($item->jenisAlat->nama_jenis ?? '-') }}
                    </td>

                    <td class="text-left">
                        {{ ucwords($item->nama_tipe) }}
                    </td>

                    <td>
                        {{ $item->total_perbaikan }}
                    </td>

                    <td>
                        {{ $item->total_rusak }}
                    </td>

                    <td>
                        {{ $item->total_hilang }}
                    </td>

                </tr>
            @endforeach

        </tbody>
    </table>
</body>

</html>
