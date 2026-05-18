<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Imports\SiswaImport;
use App\Models\AkunUser;
use App\Models\Siswa;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;


class SiswaController extends Controller
{
    public function siswaIndex()
    {
        $siswas = Siswa::all();
        return view('admin.siswa.siswaIndex', compact('siswas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_siswa' => 'required|string|max:255',
            'nis' => [
                'required',
                'string',
                Rule::unique('siswa', 'nis')
            ],
            'kelas' => 'required|string',
            'jenis_kelamin' => 'required|string|in:laki-laki,perempuan',
        ]);

        try {
            DB::beginTransaction();
            $akun_user = AkunUser::create([
                'username' => $request->nis,
                'password' => Hash::make($request->nis),
                'role' => 'siswa',
                'fcm_token' => null
            ]);

            $siswa = Siswa::create([
                'id_akun_user' => $akun_user->id_akun_user,
                'nama_siswa' => strtolower($request->nama_siswa),
                'nis' => $request->nis,
                'kelas' => ($request->kelas),
                'jenis_kelamin' => ($request->jenis_kelamin),
            ]);

            DB::commit();
            return redirect()->route('siswa.index')
                ->with('store_success', ucwords(strtolower($request->nama_siswa)));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Data siswa gagal disimpan');
        }
    }

    public function update(Request $request, $idSiswa)
    {

        $request->validate([
            'nama_siswa' => 'required|string|max:255',
            'nis' => [
                'required',
                'string',
                Rule::unique('siswa', 'nis')->ignore($idSiswa, 'id_siswa'),
            ],
            'kelas' => 'required|string',
            'jenis_kelamin' => 'required|string|in:laki-laki,perempuan'
        ], [
            'nis.unique' => 'NIS sudah digunakan',
        ]);

        $siswa = Siswa::findOrFail($idSiswa);
        try {
            DB::beginTransaction();
            $siswa->update([
                'nama_siswa' => strtolower($request->nama_siswa),
                'nis' => $request->nis,
                'kelas' => ($request->kelas),
                'jenis_kelamin' => ($request->jenis_kelamin)
            ]);

            $siswa->akunUser()->update([
                'username' => $request->nis,
                'password' => Hash::make($request->nis)
            ]);

            DB::commit();
            return redirect()->route('siswa.index')->with('update_success', ucwords(strtolower($siswa->nama_siswa)));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

   public function checkNis(Request $request)
{
    $nis = $request->nis;
    $id = $request->id_siswa;

    $exists = Siswa::where('nis', $nis)
        ->when($id, fn($q) => $q->where('id_siswa', '!=', $id))
        ->exists();

    return response()->json([
        'exist' => $exists
    ]);
}

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $siswa = Siswa::findOrFail($id);
            $siswa->akunUser()->delete();
            $siswa->delete();
            DB::commit();
            return redirect()->route('siswa.index');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Data gagal dihapus');
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls'
        ]);

        try {
            Excel::import(new SiswaImport, $request->file('file'));
            return redirect()->route('siswa.index')->with('upload_success', 'Data siswa berhasil diimport!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal import: ' . $e->getMessage());
        }
    }

    public function exportPdf(Request $request)
    {
        if ($request->kelas) {
            $siswas = Siswa::where('kelas', $request->kelas)->get();
        } else {
            $siswas = Siswa::all();
        }

        $pdf = Pdf::loadView('admin.siswa.exportPdf', compact('siswas'));

        return $pdf->download('Data Siswa.pdf');
    }
}
