<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\Admin;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $admin = Admin::paginate(10);
        return view('admin.admin.index', ['admin' => $admin]);
    }

    public function create()
    {
        return view('admin.admin.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => ['required'],
            'username' => ['required', 'unique:admin,username'],
            'password' => ['required'],

        ], [
            'nama.required'        => 'Nama Admin wajib diisi.',
            'username.required'    => 'Username wajib diisi.',
            'username.unique'      => 'Username sudah digunakan.',
            'password.required'    => 'Password wajib diisi.',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        Admin::create($validatedData);

        return redirect('admin')->with('success', 'Data Admin Berhasil Ditambah');
    }

    public function edit($id)
    {
        $admin = Admin::findOrFail($id);
        return view('admin.admin.edit', ['admin' => $admin]);
    }

    public function update(Request $request, $id)
    {
        $admin = Admin::findOrFail($id); // Ambil data pengguna dulu

        $validatedData = $request->validate([
            'nama' => ['required'],
            'username' => ['required', Rule::unique('admin', 'username')->ignore($admin->id)],
            'password' => ['required'],
        ], [
            'nama.required'        => 'Nama Admin wajib diisi.',
            'username.required'    => 'Username wajib diisi.',
            'username.unique'      => 'Username sudah digunakan.',
            'password.required'    => 'Password wajib diisi.',
        ]);

        // Hash password baru sebelum disimpan
        $validatedData['password'] = Hash::make($validatedData['password']);

        $admin->update($validatedData);

        return redirect('admin')->with('success', 'Data Admin Berhasil Diupdate');
    }


    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);
        $admin->delete();
        return redirect('/admin')->with('success', 'Data Admin Berhasil Dihapus');
    }
}
