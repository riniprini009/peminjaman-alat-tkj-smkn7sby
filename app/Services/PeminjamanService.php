<?php

namespace App\Services;

use App\Models\DetailAlat;
use App\Models\Peminjaman;
use App\Services\FCMService;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Auth;

class PeminjamanService
{
    public function updateStatus(Peminjaman $peminjaman)
    {
        if (in_array($peminjaman->status_pinjam, [
            'batal',
            'selesai',
            'aktif',
            'proses pengembalian'
        ])) {
            return;
        }

        $waktuPakai = CarbonImmutable::parse(
            $peminjaman->tanggal_mulai . ' ' . $peminjaman->jam_mulai
        );

        $waktuSelesai = CarbonImmutable::parse(
            $peminjaman->tanggal_selesai . ' ' . $peminjaman->jam_selesai
        );

        $batasMulai = $waktuPakai->subMinutes(10);

        $sekarang = now();

        if ($sekarang->lessThan($batasMulai)) {
            $statusBaru = 'menunggu';
        } elseif ($sekarang->greaterThan($waktuSelesai)) {
            $statusBaru = 'batal';
        } else {
            $statusBaru = 'siap diambil';
        }

        if ($peminjaman->status_pinjam !== $statusBaru) {

            $peminjaman->status_pinjam = $statusBaru;
            $peminjaman->save();

            if ($statusBaru === 'siap diambil') {

                $token = $peminjaman->siswa?->akunUser?->fcm_token;

                if ($token) {
                    FCMService::send(
                        $token,
                        "Alat Siap Diambil",
                        "Silakan ambil alat yang kamu pinjam"
                    );
                }
            }
        }
    }

    public function checkReminder(Peminjaman $peminjaman)
    {
        if (in_array($peminjaman->status_pinjam, [
            'batal',
            'selesai',
            'menunggu',
            'siap diambil',
            'proses_pengembalian'
        ])) {
            return;
        }

        $sekarang = now();

        $batas = Carbon::parse(
            $peminjaman->tanggal_selesai . ' ' . $peminjaman->jam_selesai
        );

        $reminder = $batas->copy()->subMinutes(10);
        $reminderEnd = $reminder->copy()->addMinute();

        if ($sekarang >= $reminder && $sekarang < $reminderEnd) {

            $token = $peminjaman->siswa?->akunUser?->fcm_token;

            if ($token) {
                FCMService::send(
                    $token,
                    "Reminder Pengembalian",
                    "10 menit lagi waktu peminjaman habis"
                );
            }
        }
    }

    public function storePinjamTipe($request, AlatService $alatService)
    {
        // 1. CEK KETERSEDIAAN DULU (INI KUNCINYA)
        $check = $alatService->check($request->tanggal_mulai, $request->jam_mulai);

        $jamMulai = $request->jam_mulai;

        $alat = $request->input('alat');

        foreach ($alat as $item) {

            $idTipe = $item['id'];
            $qty = $item['jumlah'];

            // stok pada jam itu
            $stokTersisa = $check[$idTipe] ?? 0;

            if ($qty > $stokTersisa) {
                throw new \Exception("Stok tidak cukup untuk tipe alat ID: {$idTipe} pada jam {$jamMulai}");
            }
        }

        // 2. kalau lolos baru CREATE
        $peminjaman = Peminjaman::create([
            'id_siswa' => Auth::user()->siswa->id_siswa,
            'tanggal_mulai' => $request->tanggal_mulai,
            'jam_mulai' => $request->jam_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'jam_selesai' => $request->jam_selesai,
        ]);

        $data = [];

        foreach ($alat as $item) {
            $data[$item['id']] = [
                'quantity' => $item['jumlah']
            ];
        }

        $peminjaman->tipeAlat()->attach($data);

        return $peminjaman;
    }

    public function storePinjamDetail($request, $idPinjam)
    {
        $peminjaman = Peminjaman::findOrFail($idPinjam);

        $kodeAlat = explode(',', $request->alat);

        $detailAlat = DetailAlat::whereIn('kode_alat', $kodeAlat)
            ->pluck('id_detail_alat');

        $dataPivot = [];

        foreach ($detailAlat as $id) {
            $dataPivot[$id] = [
                'tanggal_pengembalian' => null,
                'is_kembali' => false,
                'kondisi_kembali' => null,
                'catatan' => null,
                'is_terlambat' => false
            ];
        }

        $peminjaman->detailAlat()->attach($dataPivot);

        DetailAlat::whereIn('id_detail_alat', $detailAlat)
            ->update(['status_alat' => 'tidak tersedia']);

        $peminjaman->update([
            'status_pinjam' => 'aktif'
        ]);

        return $peminjaman;
    }

    public function scanQr($kode)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $alat = DetailAlat::where('kode_alat', $kode)->firstOrFail();
        $idSiswa = Auth::user()->siswa->id_siswa;

        // $peminjamanAktif = Peminjaman::where('status_pinjam', 'aktif')
        //     ->whereHas('detailAlat', function ($q) use ($alat) {
        //         $q->where('detail_alat.id_detail_alat', $alat->id_detail_alat);
        //     })
        //     ->latest('id_pinjam')
        //     ->first();

        // if ($peminjamanAktif) {

        //     if ($peminjamanAktif->id_siswa != $idSiswa) {
        //         return redirect()->route('peminjamanSiswa.index')
        //             ->with('error', 'Alat tidak tersedia');
        //     }

        //     return redirect()->route('peminjamanSiswa.index')
        //         ->with('error', 'Peminjaman sedang berjalan');
        // }

        $peminjaman = Peminjaman::where('id_siswa', $idSiswa)
            ->whereIn('status_pinjam', ['menunggu', 'siap diambil'])
            ->whereHas('tipeAlat', function ($q) use ($alat) {
                $q->where('tipe_alat.id_tipe', $alat->id_tipe);
            })
            ->latest('id_pinjam')
            ->first();

        if (!$peminjaman) {
            return redirect()->route('peminjamanSiswa.index')
                ->with('error', 'Alat ini tidak ada di daftar peminjaman! Silahkan lakukan peminjaman');
        }

        if ($peminjaman->status_pinjam === 'menunggu') {
            return redirect()->route('peminjamanSiswa.index')
                ->with('error', 'Belum memasuki waktu pemakaian');
        }

        if ($peminjaman->status_pinjam === 'siap diambil') {
            return redirect()->route('peminjaman.scan', [
                'id' => $peminjaman->id_pinjam,
                'kode' => $kode
            ]);
        }

        return redirect()->route('alat.index');
    }

    public function scanKembali($request, $idPinjam)
    {
        $peminjaman = Peminjaman::with('detailAlat')->findOrFail($idPinjam);

        $alatData = json_decode($request->alat, true);

        foreach ($alatData as $idTipe => $listKode) {
            foreach ($listKode as $kode) {

                $alat = DetailAlat::where('kode_alat', $kode)->first();

                if ($alat) {
                    $peminjaman->detailAlat()->updateExistingPivot(
                        $alat->id_detail_alat,
                        ['is_kembali' => true]
                    );
                }
            }
        }

        $peminjaman->update([
            'status_pinjam' => 'proses pengembalian'
        ]);

        return $peminjaman;
    }

    public function validasi($request, $id_pinjam)
    {
        $peminjaman = Peminjaman::with('detailAlat')->findOrFail($id_pinjam);

        foreach ($peminjaman->detailAlat as $alat) {

            $idAlat = $alat->id_detail_alat;

            $kondisi = $request->kondisi_kembali[$idAlat] ?? 'baik';
            $catatan = $request->catatan[$idAlat] ?? null;

            $status = $kondisi === 'baik' ? 'tersedia' : 'tidak tersedia';

            $peminjaman->detailAlat()->updateExistingPivot($idAlat, [
                'is_kembali' => true,
                'kondisi_kembali' => $kondisi,
                'catatan' => $catatan,
                'tanggal_pengembalian' => now(),
                'is_terlambat' => now()->greaterThan($peminjaman->tanggal_selesai)
            ]);

            $alat->update([
                'status_alat' => $status,
                'kondisi_alat' => $kondisi
            ]);
        }

        $peminjaman->update([
            'status_pinjam' => 'selesai'
        ]);

        return $peminjaman;
    }
}
