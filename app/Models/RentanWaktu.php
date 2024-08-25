<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentanWaktu extends Model
{
    use HasFactory;

    protected $table = 'rentan_waktu';

    protected $primaryKey = 'id_rentan_waktu';

    protected $fillable = ['tahun_awal', 'tahun_akhir', 'nama_rentan_waktu', 'aktif'];

    protected $casts = [
        'id_rentan_waktu' => 'integer',
        'tahun_awal' => 'integer',
        'tahun_akhir' => 'integer',
        'nama_rentan_waktu' => 'string',
        'aktif' => 'string',
    ];
}
