<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    use HasFactory;

    protected $table        = 'anggota';

    protected $primaryKey   = 'id_anggota';

    protected $fillable     = [
        'nama',
        'jabatan',
        'urutan',
        'img_anggota'
    ];
}
