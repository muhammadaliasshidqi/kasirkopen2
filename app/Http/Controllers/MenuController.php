<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    // Menampilkan daftar menu
    public function index(Request $request)
    {
        $query = Menu::query();

        // Filter berdasarkan kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Search
        if ($request->filled('search')) {
            $query->where('nama_menu', 'like', '%' . $request->search . '%');
        }

        $menus = $query->latest()->paginate(12);
        $kategoris = Menu::distinct()->pluck('kategori');

        return view('menu.index', compact('menus', 'kategoris'));
    }

    // Menampilkan form tambah menu
    public function create()
    {
        $kategoris = Menu::distinct()->pluck('kategori');
        return view('menu.create', compact('kategoris'));
    }

    // Menyimpan menu baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_menu' => 'required|string|max:100',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'kategori' => 'required|string|max:50',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('menu', 'public');
        }

        Menu::create($validated);

        return redirect()->route('menu.index')
            ->with('success', 'Menu berhasil ditambahkan!');
    }

    // Menampilkan detail menu
    public function show(Menu $menu)
    {
        return view('menu.show', compact('menu'));
    }

    // Menampilkan form edit menu
    public function edit(Menu $menu)
    {
        $kategoris = Menu::distinct()->pluck('kategori');
        return view('menu.edit', compact('menu', 'kategoris'));
    }

    // Update menu
    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'nama_menu' => 'required|string|max:100',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'kategori' => 'required|string|max:50',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama
            if ($menu->gambar) {
                Storage::disk('public')->delete($menu->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('menu', 'public');
        }

        $menu->update($validated);

        return redirect()->route('menu.index')
            ->with('success', 'Menu berhasil diupdate!');
    }

    // Hapus menu
    public function destroy(Menu $menu)
    {
        // Hapus gambar jika ada
        if ($menu->gambar) {
            Storage::disk('public')->delete($menu->gambar);
        }

        $menu->delete();

        return redirect()->route('menu.index')
            ->with('success', 'Menu berhasil dihapus!');
    }

    // Update stok
    public function updateStok(Request $request, Menu $menu)
    {
        $request->validate([
            'stok' => 'required|integer|min:0',
        ]);

        $menu->update(['stok' => $request->stok]);

        return back()->with('success', 'Stok berhasil diupdate!');
    }
}