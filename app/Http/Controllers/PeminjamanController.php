<?php

namespace App\Http\Controllers;


use App\Models\DetailAlat;
use App\Models\Peminjaman;
use App\Models\TipeAlat;
use App\Services\AlatService;
use App\Services\PeminjamanService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    public function adminIndex()
    {
        $peminjamanMenunggu = Peminjaman::where('status_pinjam', 'menunggu')
            ->with('tipeAlat')
            ->get();

        $peminjamanSiapDiambil = Peminjaman::where('status_pinjam', 'siap diambil')
            ->with('tipeAlat')
            ->get();

        $peminjamanAktif = Peminjaman::where('status_pinjam', 'aktif')
            ->with('tipeAlat')
            ->get();
        $peminjamanProsesPengembalian = Peminjaman::where('status_pinjam', 'proses pengembalian')
            ->with([
                'siswa',
                'tipeAlat.detailAlat' // INI yang benar
            ])
            ->get();
        $peminjamanBatal = Peminjaman::where('status_pinjam', 'batal')
            ->with('tipeAlat')
            ->get();

        return view('admin.peminjaman.index', compact('peminjamanMenunggu', 'peminjamanSiapDiambil', 'peminjamanAktif', 'peminjamanProsesPengembalian', 'peminjamanBatal'));
    }

    public function siswaIndex()
    {
        $idSiswa = Auth::user()->siswa->id_siswa;

        // $peminjamans = Peminjaman::where('id_siswa', $idSiswa)->get();

        // update status otomatis
        // foreach ($peminjamans as $peminjaman) {
        //     $peminjaman->updateStatus();
        // }

        $peminjamanMenunggu = Peminjaman::where('id_siswa', $idSiswa)
            ->where('status_pinjam', 'menunggu')
            ->with('tipeAlat')
            ->get();

        $peminjamanSiapDiambil = Peminjaman::where('id_siswa', $idSiswa)
            ->where('status_pinjam', 'siap diambil')
            ->with('tipeAlat')
            ->get();

        $peminjamanAktif = Peminjaman::where('id_siswa', $idSiswa)
            ->where('status_pinjam', 'aktif')
            ->with(['tipeAlat', 'detailAlat'])
            ->get();

        $peminjamanProsesPengembalian = Peminjaman::where('id_siswa', $idSiswa)
            ->where('status_pinjam', 'proses pengembalian')
            ->with('tipeAlat')
            ->get();

        $peminjamanBatal = Peminjaman::where('id_siswa', $idSiswa)
            ->where('status_pinjam', 'batal')
            ->with('tipeAlat')
            ->get();
        return view('siswa.peminjaman', compact(
            'peminjamanMenunggu',
            'peminjamanSiapDiambil',
            'peminjamanAktif',
            'peminjamanProsesPengembalian',
            'peminjamanBatal'
        ));
    }

    public function riwayatAdmin()
    {
        $tipes = TipeAlat::all();
        $data = Peminjaman::with(['siswa', 'tipeAlat'])
            ->where('status_pinjam', 'selesai')
            ->get();

        return view('admin.riwayatPinjam', compact('data', 'tipes'));
    }

    public function riwayatSiswa()
    {
        $siswa = Auth::user()->siswa->id_siswa;

        $data = Peminjaman::with(['siswa', 'tipeAlat'])
            ->where('status_pinjam', 'selesai')
            ->where('id_siswa', $siswa)
            ->get();

        return view('siswa.riwayatPinjam', compact('data'));
    }

    public function storePinjamTipe(Request $request, PeminjamanService $peminjamanService, AlatService $alatService)
    {
        try {
            DB::beginTransaction();

            $peminjaman = $peminjamanService->storePinjamTipe($request, $alatService);

            DB::commit();

            return redirect()->route('alat.index')
                ->with('success', 'Berhasil pinjam');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function scanPinjamIndex($id)
    {
        $peminjaman = Peminjaman::with(['tipeAlat.jenisAlat', 'tipeAlat.detailAlat'])->findOrFail($id);
        $allAlat = DetailAlat::with('tipeAlat')->get();
        return view('siswa.scan', compact('peminjaman', 'allAlat'));
    }

    public function storePinjamDetail(Request $request, PeminjamanService $peminjamanService, $idPinjam)
    {
        try {
            DB::beginTransaction();

            $peminjamanService->storePinjamDetail($request, $idPinjam);

            DB::commit();

            return redirect()
                ->route('peminjamanSiswa.index')
                ->with('success', 'Berhasil!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function scanQr($kode, PeminjamanService $peminjamanService)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        return $peminjamanService->scanQr($kode);
    }

    public function scanKembali(Request $request, PeminjamanService $peminjamanService, $idPinjam)
    {
        try {
            DB::beginTransaction();

            $peminjamanService->scanKembali($request, $idPinjam);

            DB::commit();

            return redirect()
                ->route('peminjamanSiswa.index')
                ->with('success', 'Berhasil!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function prosesPengembalianIndex($idPinjam)
    {
        $peminjaman = Peminjaman::with('detailAlat.tipeAlat')
            ->findOrFail($idPinjam);
        $detailAlat = DetailAlat::all();
        return view('siswa.prosesPengembalian', compact('peminjaman', 'detailAlat'));
    }

    public function validasi(Request $request, PeminjamanService $peminjamanService, $idPinjam)
    {
        try {
            DB::beginTransaction();

            $peminjamanService->validasi($request, $idPinjam);

            DB::commit();

            return redirect()->route('peminjaman.index')->with('success', 'Validasi selesai');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function cancel($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->status_pinjam = 'batal';
        $peminjaman->save();
        return back()->with('success', 'peminjaman berhasil dibatalkan');
    }

    public function exportPdf(Request $request)
    {

        $query = Peminjaman::with(['siswa', 'tipeAlat'])
            ->where('status_pinjam', 'selesai')
            ->orderBy('tanggal_mulai', 'asc');

        // filter kelas
        if ($request->kelas) {
            $query = $query->whereHas('siswa', function ($q) {
                $q->where('kelas', request('kelas'));
            });
        }

        // filter tipe
        if ($request->tipe) {
            $query = $query->whereHas('tipeAlat', function ($q) {
                $q->where('nama_tipe', request('tipe'));
            });
        }

        if ($request->start && $request->end) {
            $query->whereBetween('tanggal_mulai', [$request->start, $request->end]);
        }

        $data = $query->get();

        $pdf = Pdf::loadView('admin.exportRiwayat', compact('data'));

        return $pdf->download('Riwayat Peminjaman.pdf');
    }
}
