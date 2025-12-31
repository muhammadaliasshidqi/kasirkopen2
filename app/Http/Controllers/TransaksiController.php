<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class TransaksiController extends Controller
{
    // Halaman POS
    public function index()
    {
        $menus = Menu::where('stok', '>', 0)->get();
        $kategoris = Menu::distinct()->pluck('kategori');
        
        return view('transaksi.index', compact('menus', 'kategoris'));
    }

    // Proses transaksi
    public function store(Request $request)
    {
        // Validasi input
        try {
            $validated = $request->validate([
                'items' => 'required|array|min:1',
                'items.*.id_menu' => 'required|exists:menu,id_menu',
                'items.*.jumlah' => 'required|integer|min:1',
                'metode_pembayaran' => 'required|in:tunai,qris',
                'bayar' => 'required|numeric|min:0',
                'bukti_pembayaran' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Tambahan validasi file
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid',
                'errors' => $e->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            $total = 0;
            $items = [];

            // Validasi stok dan hitung total
            foreach ($request->items as $item) {
                $menu = Menu::find($item['id_menu']);
                
                if (!$menu) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Menu tidak ditemukan!'
                    ], 404);
                }
                
                if ($menu->stok < $item['jumlah']) {
                    return response()->json([
                        'success' => false,
                        'message' => "Stok {$menu->nama_menu} tidak mencukupi! (Tersisa: {$menu->stok})"
                    ], 400);
                }

                $subtotal = $menu->harga * $item['jumlah'];
                $total += $subtotal;

                $items[] = [
                    'menu' => $menu,
                    'jumlah' => $item['jumlah'],
                    'harga_satuan' => $menu->harga,
                    'subtotal' => $subtotal,
                ];
            }

            // Validasi pembayaran
            if ($request->bayar < $total) {
                return response()->json([
                    'success' => false,
                    'message' => 'Jumlah pembayaran kurang! Total: Rp ' . number_format($total, 0, ',', '.')
                ], 400);
            }

            $kembalian = $request->bayar - $total;

            // Cek apakah user sudah login sebagai kasir
            $kasir = Auth::guard('kasir')->user();
            if (!$kasir) {
                return response()->json([
                    'success' => false,
                    'message' => 'Silakan login terlebih dahulu!'
                ], 401);
            }

            // Simpan transaksi
            $transaksi = Transaksi::create([
                'tanggal' => Carbon::now(),
                'total' => $total,
                'id_kasir' => $kasir->id_kasir,
                'metode_pembayaran' => $request->metode_pembayaran,
                'bayar' => $request->bayar,
                'kembalian' => $kembalian,
                'bukti_pembayaran' => null, // Default null
            ]);

            // Handle file upload jika ada
            if ($request->hasFile('bukti_pembayaran')) {
                $file = $request->file('bukti_pembayaran');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/bukti_pembayaran'), $filename);
                
                $transaksi->update([
                    'bukti_pembayaran' => 'uploads/bukti_pembayaran/' . $filename
                ]);
            }
            // Simpan detail transaksi dan update stok
            foreach ($items as $item) {
                DetailTransaksi::create([
                    'id_transaksi' => $transaksi->id_transaksi,
                    'id_menu' => $item['menu']->id_menu,
                    'jumlah' => $item['jumlah'],
                    'harga_satuan' => $item['harga_satuan'],
                    'subtotal' => $item['subtotal'],
                ]);

                // Update stok
                $item['menu']->decrement('stok', $item['jumlah']);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil!',
                'data' => [
                    'id_transaksi' => $transaksi->id_transaksi,
                    'total' => $total,
                    'bayar' => $request->bayar,
                    'kembalian' => $kembalian,
                ]
            ], 200);

        } catch (\Exception $e) {
            DB::rollback();
            
            // Log error untuk debugging dengan detail lebih lengkap
            Log::error('Transaksi Error: ' . $e->getMessage());
            Log::error('Stack Trace: ' . $e->getTraceAsString());
            Log::error('Request Data: ' . json_encode($request->all()));
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage(),
                'error_detail' => config('app.debug') ? $e->getTraceAsString() : null
            ], 500);
        }
    }

    // Daftar riwayat transaksi
    public function history(Request $request)
    {
        $query = Transaksi::with(['kasir', 'detailTransaksi.menu']);

        // Filter berdasarkan tanggal
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        // Filter berdasarkan metode pembayaran
        if ($request->filled('metode')) {
            $query->where('metode_pembayaran', $request->metode);
        }

        $transaksis = $query->latest()->paginate(15);

        return view('transaksi.history', compact('transaksis'));
    }

    // Detail transaksi
    public function show(Transaksi $transaksi)
    {
        $transaksi->load(['kasir', 'detailTransaksi.menu']);
        return view('transaksi.show', compact('transaksi'));
    }

    // Print struk
    public function printStruk(Transaksi $transaksi)
    {
        $transaksi->load(['kasir', 'detailTransaksi.menu']);
        return view('transaksi.struk', compact('transaksi'));
    }

    // Batalkan transaksi (hanya hari ini)
    public function cancel(Transaksi $transaksi)
    {
        // if (!$transaksi->tanggal->isToday()) {
        //     return back()->with('error', 'Hanya bisa membatalkan transaksi hari ini!');
        // }

        DB::beginTransaction();
        try {
            // Kembalikan stok
            foreach ($transaksi->detailTransaksi as $detail) {
                $detail->menu->increment('stok', $detail->jumlah);
            }

            $transaksi->delete();
            DB::commit();

            return redirect()->route('transaksi.history')
                ->with('success', 'Transaksi berhasil dibatalkan!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal membatalkan transaksi!');
        }
    }
}