<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoadMap extends Model
{
    use HasFactory;

    protected $table        = 'roadmap';

    protected $primaryKey   = 'id_roadmap';

    protected $fillable     = [
        'dosen_id', 'prodi_id', 'rentan_waktu_id', 'jenis', 'nama_roadmap',
        'berkas', 'status', 'tanggal_upload', 'komentar'
    ];
}
