<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class ProfileController extends Controller
{

    public function index()
{
    $user = Auth::user();

    // Ambil semua kandidat + jumlah suara mereka
    $rekap = \App\Models\Kandidat::withCount('votings')->get();

    // Jika admin, tampilkan rekap suara dan data voting
    if ($user->role->role_name == 'admin') {
        $votings = \App\Models\Voting::with('user', 'kandidat')->get();
        return view('voting.index', compact('rekap', 'votings'));
    }

    // Jika user biasa
    // Cek apakah profil lengkap
    $profilLengkap = $user->nim && $user->kelas && $user->jurusan;

    return view('profile.index', compact('rekap', 'profilLengkap'));
}

    public function update(Request $request)
{
    $request->validate([
        'nim' => 'required',
        'kelas' => 'required',
        'jurusan' => 'required',
    ], [
        'nim.required' => 'NIM harus diisi.',
        'kelas.required' => 'Kelas harus diisi.',
        'jurusan.required' => 'Jurusan harus diisi.'
    ]);

    $user = \App\Models\User::findOrFail(Auth::id());


    // === CEK NIM SUDAH DIPAKAI USER LAIN ===
    $isNimUsedByOtherUser = \App\Models\User::where('nim', $request->nim)
        ->where('id', '!=', $user->id)
        ->exists();

    if ($isNimUsedByOtherUser) {
        return back()->withErrors(['nim' => 'NIM ini sudah digunakan oleh user lain.'])->withInput();
    }

    // === CEK NIM ADALAH NIM KANDIDAT ===
    $isNimUsedByKandidat = \App\Models\Kandidat::where('nim', $request->nim)->exists();

    if ($isNimUsedByKandidat) {
        return back()->withErrors(['nim' => 'NIM ini milik kandidat dan tidak boleh digunakan.'])->withInput();
    }

    // === UPDATE USER PROFILE ===
    $user->update([
        'nim' => $request->nim,
        'kelas' => $request->kelas,
        'jurusan' => $request->jurusan,
    ], [
        'nim.required' => 'NIM harus diisi.',
        'kelas.required' => 'Kelas harus diisi.',
        'jurusan.required' => 'Jurusan harus diisi.'
    ]);

    // === BUAT RECORD VOTING KOSONG JIKA BELUM ADA ===
    if (!$user->voting) {
        \App\Models\Voting::create([
            'user_id'     => $user->id,
            'nim'         => $request->nim,
            'kelas'       => $request->kelas,
            'jurusan'     => $request->jurusan,
            'kandidat_id' => null,
        ]);
    }

    Alert::success('Berhasil', 'Data Profile berhasil di tambahkan');
    return redirect()->route('profile.index');
}



}
