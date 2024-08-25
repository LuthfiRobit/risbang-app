<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profil extends Model
{
    use HasFactory;

    protected $table        = 'profil';

    protected $primaryKey   = 'id_profil';

    protected $fillable     = [
        'visi',
        'misi',
        'tujuan',
        'tentang',
        'alamat',
        'email',
        'no_tlpn',
        'whatsap',
        'instagram',
        'twitter',
        'facebook',
        'linkedin',
        'web1',
        'web2',
        'web3',
        'logo1',
        'logo2',
        'logo3'
    ];
}
