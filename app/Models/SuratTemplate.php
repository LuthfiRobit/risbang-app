<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratTemplate extends Model
{
    use HasFactory;

    protected $table        = 'surat_template';

    protected $primaryKey   = 'id_surat_template';

    protected $fillable     = [
        'status', 'nama_template', 'deskripsi', 'template'
    ];
}
