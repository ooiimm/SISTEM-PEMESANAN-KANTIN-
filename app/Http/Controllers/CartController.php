<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Menambahkan item ke keranjang
    public function add(Request $request, Menu $menu)
    {
        $request->validate(['jumlah' => 'required|integer|min:1']);

        $cart = session()->get('cart', []);

        // Jika item sudah ada di keranjang, tambahkan jumlahnya
        if(isset($cart[$menu->id])) {
            $cart[$menu->id]['jumlah'] += $request->jumlah;
        } else {
            // Jika item belum ada, tambahkan sebagai item baru
            $cart[$menu->id] = [
                "nama_menu" => $menu->nama_menu,
                "jumlah" => $request->jumlah,
                "harga" => $menu->harga,
                "gambar" => $menu->gambar
            ];
        }
        
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Menu berhasil ditambahkan ke keranjang!');
    }

    // Menampilkan halaman keranjang
    public function show()
    {
        $cart = session()->get('cart', []);
        return view('cart.show', compact('cart'));
    }

    // Menghapus item dari keranjang
    public function remove($menuId)
    {
        $cart = session()->get('cart');
        if(isset($cart[$menuId])) {
            unset($cart[$menuId]);
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Menu berhasil dihapus dari keranjang.');
    }
}