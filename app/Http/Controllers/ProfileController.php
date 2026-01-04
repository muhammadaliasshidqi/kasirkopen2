<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Kasir;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('kasir.auth');
    }

    /**
     * Update akun kasir (Admin only)
     */
    public function updateAccount(Request $request, $id)
    {
        $currentUser = Auth::guard('kasir')->user();
        if (!$currentUser || !$currentUser->isAdmin()) {
            return redirect()->route('login')->withErrors(['error' => 'Akses ditolak']);
        }

        $kasirToUpdate = Kasir::findOrFail($id);

        $rules = [
            'nama_kasir' => 'required|string|min:3',
            'username' => [
                'required', 'string', 'min:3',
                Rule::unique('kasir', 'username')->ignore($kasirToUpdate->id_kasir, 'id_kasir'),
            ],
        ];

        // Validasi password hanya jika diisi
        if ($request->filled('password')) {
            $rules['password'] = 'required|string|min:6';
        }

        $request->validate($rules, [
            'nama_kasir.required' => 'Nama kasir wajib diisi',
            'username.unique' => 'Username sudah digunakan',
        ]);

        $kasirToUpdate->nama_kasir = $request->nama_kasir;
        $kasirToUpdate->username = $request->username;
        
        if ($request->filled('password')) {
            $kasirToUpdate->password = Hash::make($request->password);
        }

        $kasirToUpdate->save();

        return redirect()->route('profile.index')
            ->with('success', 'Data akun kasir berhasil diperbarui!');
    }

    /**
     * Tampilkan halaman profile
     */
    public function index()
    {
        $kasir = Auth::guard('kasir')->user();
        if (!$kasir) {
            return redirect()->route('login')->withErrors(['error' => 'Silakan login terlebih dahulu']);
        }

        // Ambil semua akun kasir
        $allKasir = Kasir::orderBy('nama_kasir', 'asc')->get();

        return view('profile.index', compact('kasir', 'allKasir'));
    }

    /**
     * Tambah akun kasir baru
     */
    public function createAccount(Request $request)
    {
        $kasir = Auth::guard('kasir')->user();
        if (!$kasir) {
            return redirect()->route('login')->withErrors(['error' => 'Silakan login terlebih dahulu']);
        }

        // Validasi input
        $request->validate([
            'nama_kasir' => 'required|string|min:3',
            'username' => 'required|string|min:3|unique:kasir,username',
            'password' => 'required|string|min:6',
        ], [
            'nama_kasir.required' => 'Nama kasir wajib diisi',
            'nama_kasir.min' => 'Nama kasir minimal 3 karakter',
            'username.required' => 'Username wajib diisi',
            'username.min' => 'Username minimal 3 karakter',
            'username.unique' => 'Username sudah digunakan',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
        ]);

        // Buat akun kasir baru
        Kasir::create([
            'nama_kasir' => $request->nama_kasir,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('profile.index')
            ->with('success', 'Akun kasir baru berhasil ditambahkan!');
    }

    /**
     * Hapus akun kasir
     */
    public function deleteAccount($id)
    {
        $kasir = Auth::guard('kasir')->user();
        if (!$kasir) {
            return redirect()->route('login')->withErrors(['error' => 'Silakan login terlebih dahulu']);
        }

        // Cari kasir yang akan dihapus
        $kasirToDelete = Kasir::find($id);
        
        if (!$kasirToDelete) {
            return redirect()->route('profile.index')
                ->withErrors(['error' => 'Akun kasir tidak ditemukan']);
        }

        // Tidak boleh menghapus akun sendiri
        if ($kasirToDelete->id_kasir === $kasir->id_kasir) {
            return redirect()->route('profile.index')
                ->withErrors(['error' => 'Tidak dapat menghapus akun yang sedang login']);
        }

        // Hapus akun
        $kasirToDelete->delete();

        return redirect()->route('profile.index')
            ->with('success', 'Akun kasir berhasil dihapus!');
    }

    /**
     * Update username
     */
    public function updateUsername(Request $request)
    {
        $kasir = Auth::guard('kasir')->user();
        if (!$kasir) {
            return redirect()->route('login')->withErrors(['error' => 'Silakan login terlebih dahulu']);
        }
        
        // Hanya admin yang boleh ganti username
        if (!$kasir->isAdmin()) {
             return redirect()->route('profile.index')->withErrors(['error' => 'Hanya Admin yang dapat mengubah profil']);
        }

        // Validasi input
        $request->validate([
            'username' => [
                'required', 'string', 'min:3',
                Rule::unique('kasir', 'username')->ignore($kasir->getKey(), $kasir->getKeyName()),
            ],
        ], [
            'username.required' => 'Username wajib diisi',
            'username.min' => 'Username minimal 3 karakter',
            'username.unique' => 'Username sudah digunakan kasir lain',
        ]);

        // Update username
        $kasir->username = $request->username;
        $kasir->save();

        return redirect()->route('profile.index')
            ->with('success', 'Username berhasil diperbarui!');
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        $kasir = Auth::guard('kasir')->user();
        if (!$kasir) {
            return redirect()->route('login')->withErrors(['error' => 'Silakan login terlebih dahulu']);
        }

        // Hanya admin yang boleh ganti password
        if (!$kasir->isAdmin()) {
             return redirect()->route('profile.index')->withErrors(['error' => 'Hanya Admin yang dapat mengubah profil']);
        }

        // Validasi input
        $request->validate([
            'password_lama' => 'required|string|min:6',
            'password_baru' => 'required|string|min:6|confirmed',
        ], [
            'password_lama.required' => 'Password lama wajib diisi',
            'password_baru.required' => 'Password baru wajib diisi',
            'password_baru.min' => 'Password baru minimal 6 karakter',
            'password_baru.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        // Cek password lama
        if (!Hash::check($request->password_lama, $kasir->password)) {
            return back()->withErrors(['password_lama' => 'Password lama tidak sesuai']);
        }

        // Update password
        $kasir->password = Hash::make($request->password_baru);
        $kasir->save();

        return redirect()->route('profile.index')
            ->with('success', 'Password berhasil diperbarui!');
    }

    /**
     * Update nama kasir
     */
    public function updateNamaKasir(Request $request)
    {
        $kasir = Auth::guard('kasir')->user();
        if (!$kasir) {
            return redirect()->route('login')->withErrors(['error' => 'Silakan login terlebih dahulu']);
        }

        // Hanya admin yang boleh ganti nama
        if (!$kasir->isAdmin()) {
             return redirect()->route('profile.index')->withErrors(['error' => 'Hanya Admin yang dapat mengubah profil']);
        }

        // Validasi input
        $request->validate([
            'nama_kasir' => 'required|string|min:3',
        ], [
            'nama_kasir.required' => 'Nama kasir wajib diisi',
            'nama_kasir.min' => 'Nama kasir minimal 3 karakter',
        ]);

        // Update nama kasir
        $kasir->nama_kasir = $request->nama_kasir;
        $kasir->save();

        return redirect()->route('profile.index')
            ->with('success', 'Nama kasir berhasil diperbarui!');
    }
}

