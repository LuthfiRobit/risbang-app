<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratTugas extends Model
{
    use HasFactory;

    protected $table        = 'surat_tugas_proposal';

    protected $primaryKey   = 'id_surat_tugas_proposal';

    protected $fillable     = [
        'proposal_id',
        'dosen_id',
        'tahun_akademik_id',
        'jenis',
        'tempat',
        'tanggal',
        'file_surat'
    ];
}
