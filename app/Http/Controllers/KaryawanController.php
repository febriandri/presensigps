<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

class KaryawanController extends Controller
{
    public function index(Request $request)
    {
        $query = Karyawan::query();
        $query->orderBy('nama_lengkap');
        if (!empty($request->nama_karyawan)) {
            $query->where('nama_lengkap', 'like', '%' . $request->nama_karyawan . '%');
        }
        $karyawan = $query->paginate(10);

        return view('karyawan.index', compact('karyawan'));
    }

    public function store(Request $request)
    {
        $nik = $request->nik;
        $nama_lengkap = $request->nama_lengkap;
        $jabatan = $request->jabatan;
        $no_hp = $request->no_hp;
        $password = Hash::make('123');
        $foto = $request->hasFile('foto') ? $nik . "." . $request->file('foto')->getClientOriginalExtension() : NULL;

        try {
            $data = [
                'nik' => $nik,
                'nama_lengkap' => $nama_lengkap,
                'jabatan' => $jabatan,
                'no_hp' => $no_hp,
                'password' => $password,
                'foto' => $foto
            ];

            $simpan = DB::table('karyawan')->insert($data);
            if ($simpan) {
                if ($request->hasFile('foto')) {
                    $folderPath = "public/uploads/karyawan/";
                    $request->file('foto')->storeAs($folderPath, $foto);
                }
                return Redirect::back()->with(['success' => 'Data berhasil disimpan']);
            }
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => 'Data gagal disimpan']);
        }
    }

    public function edit(Request $request)
    {
        $nik = $request->nik;
        $karyawan = DB::table('karyawan')->whereNik($nik)->first();
        return view('karyawan.edit', compact('karyawan'));
    }

    public function update(Request $request, $nik)
    {
        $nama_lengkap = $request->nama_lengkap;
        $jabatan = $request->jabatan;
        $no_hp = $request->no_hp;
        $password = Hash::make('123');
        $foto = $request->hasFile('foto') ? $nik . "." . $request->file('foto')->getClientOriginalExtension() : $request->old_foto;

        try {
            $data = [
                'nik' => $nik,
                'nama_lengkap' => $nama_lengkap,
                'jabatan' => $jabatan,
                'no_hp' => $no_hp,
                'password' => $password,
                'foto' => $foto
            ];

            $update = DB::table('karyawan')->whereNik($nik)->update($data);
            if ($update) {
                if ($request->hasFile('foto')) {
                    $folderPath = "public/uploads/karyawan/";
                    $folderPathOld = "public/uploads/karyawan/" . $request->old_foto;
                    Storage::delete($folderPathOld);
                    $request->file('foto')->storeAs($folderPath, $foto);
                }
                return Redirect::back()->with(['success' => 'Data berhasil disimpan']);
            }
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => 'Data gagal diupdate']);
        }
    }

    public function delete($nik)
    {
        $delete = DB::table('karyawan')->whereNik($nik)->delete();
        if($delete) {
            return Redirect::back()->with(['success' => 'Data berhasil dihapus']);
        } else {
            return Redirect::back()->with(['success' => 'Data gagal dihapus']);
        }
    }
}
