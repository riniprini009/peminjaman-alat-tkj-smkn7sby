<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\JenisAlat;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class JenisAlatController extends Controller
{
    public function jenisIndex()
    {
        $jns = JenisAlat::with('tipeAlat')->get();
        return view('admin.jenis.jenisIndex', compact('jns'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_jenis' => 'required|string|unique:jenis_alat,nama_jenis|regex:/^(?!.*(.)\1{2,}).+$/'
        ]);

        try {
            JenisAlat::create([
                'nama_jenis' => strtolower($request->nama_jenis)
            ]);
            return redirect()->route('jenis.index')->with('store_success',  ucwords(strtolower($request->nama_jenis)));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, $idJenis)
    {
        $request->validate([
            'nama_jenis' => [
                'required',
                'string',
                'regex:/^(?!.*(.)\1{2,}).+$/',
                Rule::unique('jenis_alat', 'nama_jenis')->ignore($idJenis, 'id_jenis')
            ]
        ]);

        try {
            $jenis = JenisAlat::findOrFail($idJenis);
            $jenis->update([
                'nama_jenis' => strtolower($request->nama_jenis)
            ]);
            return redirect()->route('jenis.index')->with('update_success', ucwords(strtolower($request->nama_jenis)));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $jenis = JenisAlat::findOrFail($id);
            $jenis->delete();
            return redirect()->route('jenis.index')->with('delete_success', ucwords(strtolower($jenis->nama_jenis)));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function exportPdf()
    {
        $jenis = JenisAlat::with('tipeAlat')->get();
        $pdf = Pdf::loadView('admin.jenis.exportPdf', compact('jenis'));

        return $pdf->download('Data Jenis Alat.pdf');
    }
}
