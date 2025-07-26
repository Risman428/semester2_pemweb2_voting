<?php

namespace App\Http\Controllers;

use App\Models\Kandidat;
use App\Models\Voting;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class VotingController extends Controller
{
    public function index()
    {
        $votings = Voting::with('user', 'kandidat')->get();
        $rekap = Kandidat::withCount('votings')->get();
        return view('voting.index', compact('votings', 'rekap'));
    }

    public function store(Request $request)
{
    $request->validate([
        'kandidat_id' => 'required|exists:kandidats,id',
    ]);

    $user = Auth::user();

    // Cek apakah user sudah voting dan sudah memilih
    $voting = Voting::where('user_id', $user->id)->first();
    if ($voting && $voting->kandidat_id !== null) {
        Alert::error('Gagal', 'Anda sudah memilih kandidat.');
        return redirect()->route('voting.index');
    }

    if ($voting) {
        // Update voting dengan kandidat yang dipilih
        $voting->update([
            'kandidat_id' => $request->kandidat_id
        ]);
    } else {
        // Simpan data baru
        Voting::create([
            'user_id'     => $user->id,
            'nim'         => $user->nim,
            'kelas'       => $user->kelas,
            'jurusan'     => $user->jurusan,
            'kandidat_id' => $request->kandidat_id
        ]);
    }

    Alert::success('Berhasil', 'Kandidat berhasil dipilih.');
    return redirect()->route('kandidat.index');
}


    public function destroy($id)
    {
        $voting = Voting::find($id);
        if (!$voting) {
            return redirect()->route('voting.index')->with('error', 'Data tidak ditemukan.');
        }
        // Hapus voting
        $voting->delete();
        // Set flash message
        return response()->json(['success' => true]);

    }





    public function chartData()
    {
        $rekap = Kandidat::withCount('votings')->get();
        return response()->json($rekap);
    }
    public function getVotingData()
    {
        $votings = Voting::with('user')->oldest()->get();
        return response()->json($votings);
    }




}

