<?php

namespace App\Services;

use App\Models\TipeAlat;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;

class AlatService
{
    public function check($tglMulai, $jamMulai)
    {
        $tanggalMulai = Carbon::parse($tglMulai);

        $stokTipe = TipeAlat::pluck('stok', 'id_tipe');

        $idTipes = TipeAlat::pluck('id_tipe');

        $peminjaman = DB::table('peminjaman_tipe')
            ->join('peminjaman', 'peminjaman.id_pinjam', '=', 'peminjaman_tipe.id_pinjam')
            ->whereIn('peminjaman.status_pinjam', [
                'menunggu',
                'siap diambil',
                'aktif',
                'proses pengembalian'
            ])
            ->whereDate('peminjaman.tanggal_mulai', '<=', $tanggalMulai)
            ->whereDate('peminjaman.tanggal_selesai', '>=', $tanggalMulai)
            ->select(
                'peminjaman_tipe.id_tipe',
                'peminjaman_tipe.quantity',
                'peminjaman.tanggal_mulai',
                'peminjaman.tanggal_selesai',
                'peminjaman.jam_mulai',
                'peminjaman.jam_selesai'
            )
            ->get()
            ->groupBy('id_tipe');

        $result = [];

        foreach ($idTipes as $idTipe) {

            $stok = $stokTipe[$idTipe] ?? 0;

            $listPinjam = $peminjaman[$idTipe] ?? collect();

            $terpakai = 0;

            foreach ($listPinjam as $item) {

                $tglMulai = Carbon::parse($item->tanggal_mulai);
                $tglSelesai = Carbon::parse($item->tanggal_selesai);

                if (!$tanggalMulai->between($tglMulai, $tglSelesai)) {
                    continue;
                }

                if (
                    $tanggalMulai->isSameDay($tglMulai) &&
                    $jamMulai < $item->jam_mulai
                ) {
                    continue;
                }

                if (
                    $tanggalMulai->isSameDay($tglSelesai) &&
                    $jamMulai >= $item->jam_selesai
                ) {
                    continue;
                }

                $terpakai += $item->quantity;
            }

            $result[$idTipe] = max($stok - $terpakai, 0);
        }

        return $result;
    }
}


    // public function check($tanggal)
    // {
    //     $tanggal = Carbon::parse($tanggal);

    //     $jamList = [
    //         "07:00:00",
    //         "07:45:00",
    //         "08:30:00",
    //         "09:15:00",
    //         "10:00:00",
    //         "10:45:00",
    //         "11:30:00",
    //         "12:00:00",
    //         "22:35:00",
    //         "13:00:00",
    //         "13:45:00",
    //         "14:30:00",
    //         "15:15:00"
    //     ];

    //     $stokTipe = TipeAlat::pluck('stok', 'id_tipe');
    //     $tipes = TipeAlat::select('id_tipe')->get();

    //     $data = DB::table('peminjaman_tipe')
    //         ->join('peminjaman', 'peminjaman.id_pinjam', '=', 'peminjaman_tipe.id_pinjam')
    //         ->whereIn('peminjaman.status_pinjam', ['menunggu', 'siap diambil', 'aktif', 'proses pengembalian'])
    //         ->whereDate('peminjaman.tanggal_mulai', '<=', $tanggal)
    //         ->whereDate('peminjaman.tanggal_selesai', '>=', $tanggal)
    //         ->select(
    //             'peminjaman_tipe.id_tipe',
    //             'peminjaman_tipe.quantity',
    //             'peminjaman.tanggal_mulai',
    //             'peminjaman.tanggal_selesai',
    //             'peminjaman.jam_mulai',
    //             'peminjaman.jam_selesai'
    //         )
    //         ->get()
    //         ->groupBy('id_tipe')
    //         ->map(function ($items) {
    //             return $items->map(function ($p) {
    //                 return [
    //                     'qty' => $p->quantity,
    //                     'tglMulai' => Carbon::parse($p->tanggal_mulai),
    //                     'tglSelesai' => Carbon::parse($p->tanggal_selesai),
    //                     'jamMulai' => $p->jam_mulai,
    //                     'jamSelesai' => $p->jam_selesai,
    //                 ];
    //             });
    //         });

    //     $result = [];

    //     foreach ($tipes as $tipe) {

    //         $list = $data[$tipe->id_tipe] ?? collect();
    //         $stok = $stokTipe[$tipe->id_tipe] ?? 0;

    //         foreach ($jamList as $jam) {

    //             $terpakai = 0;

    //             foreach ($list as $p) {

    //                 if (!$tanggal->between($p['tglMulai'], $p['tglSelesai'])) continue;
    //                 if ($tanggal->isSameDay($p['tglMulai']) && $jam < $p['jamMulai']) continue;
    //                 if ($tanggal->isSameDay($p['tglSelesai']) && $jam >= $p['jamSelesai']) continue;

    //                 $terpakai += $p['qty'];
    //             }

    //             $result[$tipe->id_tipe][$jam] = max($stok - $terpakai, 0);
    //         }
    //     }

    //     return $result;
    // }
