<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    use HasFactory;

    protected $table        = 'surat';

    protected $primaryKey   = 'id_surat';

    protected $fillable     = [
        'surat_template_id', 'user_id', 'dosen_id', 'nomor_surat', 'data',
        'status'
    ];
}
