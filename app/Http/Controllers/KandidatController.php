<?php

namespace App\Http\Controllers;

use App\Models\Kandidat;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class KandidatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kandidat = Kandidat::withCount('votings')->get();
        return view('kandidat.index', compact('kandidat'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kandidat.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string',
            'nim' => 'required|unique:kandidats',
            'visi' => 'required',
            'misi' => 'required',
            'foto' => 'required|image|max:2048'
        ], [
            'nama.required'     => 'Namanya harus diisi.',
            'nim.required'  => 'NIM nya harus diisi.',
            'nim.unique'      => 'NIM sudah ada yang pake',
            'visi.required'   => 'Alamatnya harus diisi.',
            'misi.required'    => 'Email harus diisi.',
            'foto.required'     => 'Foto harus ada'

        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('foto_kandidat', 'public');
        }

        Kandidat::create($validated);
        Alert::success('Berhasil', 'Kandidat berhasil ditambahkan');
        return redirect()->route('kandidat.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kandidats = Kandidat::findOrFail($id);
        return view('kandidat.edit', compact('kandidats'));
    }

    /**
     * Update the specified resource in storage.
     */

public function update(Request $request, Kandidat $kandidat)
{
    $validated = $request->validate([
        'nama' => 'required|string',
        'nim' => [
            'required',
            Rule::unique('kandidats')->ignore($kandidat->id),
        ],
        'visi' => 'required',
        'misi' => 'required',
        'foto' => 'nullable|image|max:2048'
    ], [
        'nama.required'     => 'Namanya harus diisi.',
        'nim.required'      => 'NIM-nya harus diisi.',
        'nim.unique'        => 'NIM sudah ada yang pakai.',
        'visi.required'     => 'Visi harus diisi.',
        'misi.required'     => 'Misi harus diisi.',
        'foto.image'        => 'File harus berupa gambar.',
        'foto.max'          => 'Ukuran gambar maksimal 2MB.'
    ]);

    if ($request->hasFile('foto')) {
        $validated['foto'] = $request->file('foto')->store('foto_kandidat', 'public');
    }

    $kandidat->update($validated);

    Alert::success('Berhasil', 'Data kandidat diperbarui');
    return redirect()->route('kandidat.index');
}




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kandidat = Kandidat::find($id);

        if ($kandidat->foto != null) {
            Storage::disk('public')->delete($kandidat->foto);
        }

        $kandidat->delete();
        toast( 'Data Kandidat Berhasil Dihapus.', 'success');
        return redirect()->route('kandidat.index');
    }
}
