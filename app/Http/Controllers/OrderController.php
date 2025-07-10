<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Menu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Menyimpan pesanan dari keranjang ke database.
     * Digunakan oleh Mahasiswa.
     */
    public function placeOrder(Request $request)
    {
        $request->validate(['nomor_meja' => 'required|integer|min:1']);
        $cart = session()->get('cart');

        if (!$cart) {
            return redirect()->route('dashboard')->with('error', 'Keranjang Anda kosong!');
        }
        
        DB::beginTransaction();
        try {
            // Langkah 1: Hitung total & cek stok
            $totalHarga = 0;
            foreach ($cart as $id => $details) {
                $menu = Menu::find($id);
                if ($menu->stok < $details['jumlah']) {
                    throw new \Exception('Stok untuk ' . $menu->nama_menu . ' tidak mencukupi.');
                }
                $totalHarga += $details['harga'] * $details['jumlah'];
            }

            // Langkah 2: Buat record di tabel 'orders'
            $order = Order::create([
                'user_id' => Auth::id(),
                'nomor_meja' => $request->nomor_meja,
                'total_harga' => $totalHarga,
                'status' => 'pending'
            ]);

            // Langkah 3: Buat record di tabel 'order_items' & kurangi stok
            foreach ($cart as $id => $details) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_id' => $id,
                    'jumlah' => $details['jumlah'],
                    'harga_satuan' => $details['harga']
                ]);
                // Kurangi stok
                $menu = Menu::find($id);
                $menu->stok -= $details['jumlah'];
                $menu->save();
            }

            DB::commit();

            // Langkah 4: Kosongkan keranjang
            session()->forget('cart');
            return redirect()->route('dashboard')->with('success', 'Pesanan Anda berhasil dibuat dan sedang diproses!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('cart.show')->with('error', $e->getMessage());
        }
    }


    /**
     * Menampilkan daftar pesanan yang masuk untuk Admin.
     */
    public function indexAdmin()
    {
        // Ambil semua pesanan yang statusnya 'pending'
        // 'with()' digunakan untuk eager loading, agar query lebih efisien
        $orders = Order::with(['user', 'items.menu'])
                        ->where('status', 'pending')
                        ->orderBy('created_at', 'asc') // Tampilkan yang paling lama dulu
                        ->get();

        // Kirim data pesanan ke view admin
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Menandai pesanan sebagai 'selesai'.
     */
    public function completeOrder(Order $order)
    {
        // Hapus item terkait jika Anda ingin
        // $order->items()->delete();

        // Ubah status pesanan
        $order->status = 'selesai';
        $order->save(); // Simpan perubahan ke database

        // Kembali ke halaman daftar pesanan dengan pesan sukses
        return redirect()->back()->with('success', 'Pesanan #' . $order->id . ' telah ditandai sebagai selesai.');
    }


    // ======================================================================
    // ▼▼▼ METHOD BARU UNTUK HALAMAN RIWAYAT ▼▼▼
    // ======================================================================

    /**
     * Menampilkan riwayat pesanan yang sudah selesai untuk Admin.
     */
    public function historyAdmin()
    {
        // Ambil semua order yang statusnya 'selesai'
        // Urutkan berdasarkan yang paling baru diselesaikan
        $orders = Order::with(['user', 'items.menu'])
                        ->where('status', 'selesai')
                        ->orderBy('updated_at', 'desc')
                        ->paginate(10); // Gunakan paginate agar tidak berat jika data banyak

        return view('admin.orders.history', compact('orders'));
    }

    /**
     * Menampilkan riwayat pesanan untuk Mahasiswa yang sedang login.
     */
    public function historyUser()
    {
        // Ambil pesanan milik user yang sedang login
        $orders = Order::where('user_id', Auth::id())
                        ->orderBy('created_at', 'desc')
                        ->paginate(10); // Gunakan paginate agar tidak berat jika data banyak

        return view('orders.history', compact('orders'));
    }
}