<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengguna::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%");
            });
        }

        // Urutkan berdasarkan angka setelah 'TB-' pada kolom id
        $query->orderByRaw('CAST(SUBSTRING(id, 4) AS UNSIGNED) ASC');

        $limit = $request->input('limit', 10); // default 10 jika tidak ada
        $pengguna = $query->paginate($limit)->withQueryString();

        return view('admin.pengguna.index', ['pengguna' => $pengguna]);
    }



    public function create()
    {
        return view('admin.pengguna.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => ['required', 'unique:pengguna,nama'],
            'username' => ['required', 'unique:pengguna,username'],
            'password' => ['required'],
        ], [
            'nama.required'        => 'Nama Pengguna wajib diisi.',
            'nama.unique'          => 'Nama Pengguna sudah digunakan.',
            'username.required'    => 'Username wajib diisi.',
            'username.unique'      => 'Username sudah digunakan.',
            'password.required'    => 'Password wajib diisi.',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        Pengguna::create($validatedData);

        return redirect('pengguna')->with('success', 'Data Pengguna Berhasil Ditambah');
    }

    public function edit($id)
    {
        $pengguna = Pengguna::findOrFail($id);
        return view('admin.pengguna.edit', ['pengguna' => $pengguna]);
    }

    public function update(Request $request, $id)
    {
        $pengguna = Pengguna::findOrFail($id); // Ambil data pengguna dulu

        $validatedData = $request->validate([
            'nama' => ['required'],
            'username' => ['required'],
            'password' => ['required'],
        ], [
            'nama.required'        => 'Nama Pengguna wajib diisi.',
            'username.required'    => 'Username wajib diisi.',
            'password.required'    => 'Password wajib diisi.',
        ]);

        // Hash password baru sebelum disimpan
        $validatedData['password'] = Hash::make($validatedData['password']);

        $pengguna->update($validatedData);

        return redirect('pengguna')->with('success', 'Data Pengguna Berhasil Diupdate');
    }


    public function destroy($id)
    {
        $pengguna = Pengguna::findOrFail($id);
        $pengguna->delete();
        return redirect('/pengguna')->with('success', 'Data Pengguna Berhasil Dihapus');
    }
}
