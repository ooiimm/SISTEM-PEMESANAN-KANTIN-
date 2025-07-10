<?php

// app/Http/Controllers/MenuController.php
namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; // Ganti Storage dengan File Fassade

class MenuController extends Controller
{
    // Menampilkan daftar semua menu (Halaman utama Admin)
    public function index()
    {
        $menus = Menu::all();
        return view('admin.menu.index', compact('menus'));
    }

    // Menampilkan form untuk membuat menu baru
    public function create()
    {
        return view('admin.menu.create');
    }

    // Menyimpan menu baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'nama_menu' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|integer',
            'stok' => 'required|integer',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // === LOGIKA UPLOAD BARU ===
        $gambar = $request->file('gambar');
        $nama_gambar = time() . '_' . $gambar->getClientOriginalName();
        $tujuan_upload = 'images/menu'; // Folder di dalam 'public'
        
        // Cek dan buat folder tujuan jika belum ada
        if (!File::isDirectory(public_path($tujuan_upload))) {
            File::makeDirectory(public_path($tujuan_upload), 0755, true, true);
        }

        // Pindahkan file ke folder tujuan
        $gambar->move($tujuan_upload, $nama_gambar);

        Menu::create([
            'nama_menu' => $request->nama_menu,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'gambar' => $nama_gambar, // Simpan HANYA NAMA FILE
        ]);
        // === AKHIR LOGIKA UPLOAD BARU ===

        return redirect()->route('menu.index')->with('success', 'Menu berhasil ditambahkan.');
    }

    // Menampilkan form untuk mengedit menu
    public function edit(Menu $menu)
    {
        return view('admin.menu.edit', compact('menu'));
    }

    // Mengupdate data menu di database
    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'nama_menu' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|integer',
            'stok' => 'required|integer',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $nama_gambar = $menu->gambar;
        if ($request->hasFile('gambar')) {
            // === LOGIKA HAPUS & UPLOAD BARU ===
            // Hapus gambar lama dari folder public
            $path_gambar_lama = public_path('images/menu/' . $menu->gambar);
            if (File::exists($path_gambar_lama)) {
                File::delete($path_gambar_lama);
            }

            $gambar = $request->file('gambar');
            $nama_gambar = time() . '_' . $gambar->getClientOriginalName();
            $tujuan_upload = 'images/menu';
            $gambar->move($tujuan_upload, $nama_gambar);
            // === AKHIR LOGIKA BARU ===
        }

        $menu->update([
            'nama_menu' => $request->nama_menu,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'gambar' => $nama_gambar, // Simpan HANYA NAMA FILE
        ]);

        return redirect()->route('menu.index')->with('success', 'Menu berhasil diperbarui.');
    }

    // Menghapus menu dari database
    public function destroy(Menu $menu)
    {
        // === LOGIKA HAPUS BARU ===
        // Hapus gambar fisik dari folder public
        $path_gambar = public_path('images/menu/' . $menu->gambar);
        if (File::exists($path_gambar)) {
            File::delete($path_gambar);
        }
        $menu->delete();
        // === AKHIR LOGIKA BARU ===
        
        return redirect()->route('menu.index')->with('success', 'Menu berhasil dihapus.');
    }

    // Method placeOrder tidak perlu diubah
    public function placeOrder(Request $request)
    {
        // ... (kode ini sudah benar dan tidak berhubungan dengan gambar) ...
    }
}