<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DetailAlat;
use App\Models\TipeAlat;
use App\Services\TipeAlatService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;


class DetailAlatController extends Controller
{
    public function detailIndex($idTipe)
    {
        $details = DetailAlat::where('id_tipe', $idTipe)->get();
        $tipe = TipeAlat::findOrFail($idTipe);
        return view('admin.detail.detailIndex', compact('details', 'tipe', 'idTipe'));
    }

    public function store(Request $request, $idTipe, TipeAlatService $tipeAlatService)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1'
        ]);

        try {
            $tipe = TipeAlat::findOrFail($idTipe);
            $tipeAlatService->generateQr($tipe, $request->jumlah);
            return redirect()
                ->route('detail.index', $idTipe)
                ->with('store_success', 'Data berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan QR Code');
        }
    }

    public function update(Request $request, $idTipe)
    {
        $request->validate([
            'kondisi_alat' => 'required|in:baik,perlu perbaikan,rusak,hilang'
        ]);

        $detail = DetailAlat::findOrFail($idTipe);

        // tentukan status berdasarkan kondisi
        $status = $request->kondisi_alat === 'baik'
            ? 'tersedia'
            : 'tidak tersedia';

        $detail->update([
            'kondisi_alat' => $request->kondisi_alat,
            'status_alat' => $status
        ]);

        return redirect()
            ->route('detail.index', $detail->id_tipe)
            ->with('update_success', $detail->kode_alat);
    }
    
    public function delete($id)
    {
        $detail = DetailAlat::findOrFail($id);
        $idTipe = $detail->id_tipe;
        $detail->delete();
        return redirect()->route('detail.index', $idTipe);
    }

    public function exportPdf(Request $request, $id)
    {
        $tipe = TipeAlat::findOrFail($id);

        $query = DetailAlat::where('id_tipe', $id);

        if ($request->kondisi_alat) {
            $query->where('kondisi_alat', $request->kondisi_alat);
        }

        if ($request->status_alat) {
            $query->where('status_alat', $request->status_alat);
        }

        $details = $query->get();

        $pdf = Pdf::loadView(
            'admin.detail.exportPdf',
            compact('details', 'tipe')
        )->setPaper('a4', 'portrait');

        return $pdf->download('qr-code-alat.pdf');
    }
}
