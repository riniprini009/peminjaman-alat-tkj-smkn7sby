<?php

namespace App\Imports;

use App\Models\Siswa;
use App\Models\AkunUser;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class SiswaImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    public function model(array $row)
    {
        // 🔥 VALIDASI WAJIB (hindari null error)
        if (
            empty($row['nis']) ||
            empty($row['nama']) ||
            empty($row['kelas']) ||
            empty($row['jenis_kelamin'])
        ) {
            return null;
        }

        // Cari siswa berdasarkan NIS
        $siswa = Siswa::where('nis', $row['nis'])->first();

        // ==============================
        // JIKA BELUM ADA → BUAT BARU
        // ==============================
        if (!$siswa) {

            $akun = AkunUser::create([
                'username' => (string) $row['nis'], // pastikan string
                'password' => Hash::make($row['nis']),
                'role' => 'siswa',
            ]);

            return new Siswa([
                'id_akun_user' => $akun->id_akun_user,
                'nama_siswa' => strtolower($row['nama']),
                'nis' => $row['nis'],
                'kelas' => strtolower($row['kelas']),
                'jenis_kelamin' => strtolower($row['jenis_kelamin']),
            ]);
        }

        // ==============================
        // JIKA SUDAH ADA → UPDATE
        // ==============================
        $siswa->update([
            'nama_siswa' => strtolower($row['nama']),
            'kelas' => strtolower($row['kelas']),
            'jenis_kelamin' => strtolower($row['jenis_kelamin']),
        ]);

        // update akun jika relasi ada
        if ($siswa->akun) {
            $siswa->akun->update([
                'username' => (string) $row['nis'],
                'password' => Hash::make($row['nis']),
            ]);
        }

        return null; // karena update
    }
}
