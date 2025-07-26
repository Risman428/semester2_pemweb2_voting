<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kandidat extends Model
{
    protected $fillable = ['nama', 'nim', 'visi', 'misi', 'foto'];
    public function votings()
    {
        return $this->hasMany(Voting::class);
    }

}
