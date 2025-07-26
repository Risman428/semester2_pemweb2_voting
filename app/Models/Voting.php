<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voting extends Model
{
    protected $fillable = ['user_id', 'nim', 'kelas', 'jurusan', 'kandidat_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kandidat()
    {
        return $this->belongsTo(Kandidat::class);
    }
}


