<?php

namespace App\Http\Controllers;

use App\Models\JenisAlat;
use App\Models\TipeAlat;
use App\Services\AlatService;
use App\Services\DashboardService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class AlatController extends Controller
{
    public function indexSiswa()
    {
        $jenis = JenisAlat::all();
        $tipes = TipeAlat::with('jenisAlat')->get();

        return view('siswa.daftarAlat', compact('jenis', 'tipes'));
    }
    public function indexAdmin()
    {
        $jenis = JenisAlat::all();
        $tipes = TipeAlat::with('jenisAlat')->get();

        return view('admin.daftarAlat', compact('jenis', 'tipes'));
    }

    public function check(Request $request, AlatService $alatService)
    {
        $result = $alatService->check(
            $request->tglMulai,
            $request->jamMulai
        );

        return response()->json($result);
    }


    public function dashboardAdmin(DashboardService $dashboardService)
    {
        return view('admin.dashboardAdmin', $dashboardService->dashboardAdmin());
    }

    public function dashboardKabeng(DashboardService $dashboardService)
    {
        return view('kabeng.dashboardKabeng', $dashboardService->dashboardKabeng());
    }

    public function dashboardSiswa(DashboardService $dashboardService)
    {
        return view('siswa.dashboardSiswa', $dashboardService->dashboardSiswa());
    }

    public function tracking(Request $request, DashboardService $dashboardService)
    {
        return $dashboardService->tracking($request);
    }

    public function permintaanPinjam(Request $request, DashboardService $dashboardService)
    {
        return $dashboardService->permintaanPinjam($request);
    }

    public function kondisiAlatKabeng(DashboardService $dashboardService)
    {
        return $dashboardService->kondisiAlatKabeng();
    }

public function exportKondisi()
{
    $kondisis = TipeAlat::with([
        'jenisAlat',
        'detailAlat' => function ($query) {
            $query->where('kondisi_alat', '!=', 'baik');
        }
    ])
    ->whereHas('detailAlat', function ($query) {
        $query->where('kondisi_alat', '!=', 'baik');
    })
    ->get();

    foreach ($kondisis as $item) {

        $item->total_perbaikan = $item->detailAlat
            ->where('kondisi_alat', 'perlu perbaikan')
            ->count();

        $item->total_rusak = $item->detailAlat
            ->where('kondisi_alat', 'rusak')
            ->count();

        $item->total_hilang = $item->detailAlat
            ->where('kondisi_alat', 'hilang')
            ->count();
    }

    $kondisis = $kondisis->filter(function ($item) {
        return
            $item->total_perbaikan > 0 ||
            $item->total_rusak > 0 ||
            $item->total_hilang > 0;
    });

    $pdf = Pdf::loadView(
        'kabeng.exportKondisi',
        compact('kondisis')
    );

    return $pdf->download('Data Kondisi Alat.pdf');
}
}
