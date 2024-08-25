<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratField extends Model
{
    use HasFactory;

    protected $table        = 'surat_field';

    protected $primaryKey   = 'id_surat_field';

    protected $fillable     = [
        'surat_template_id', 'field_name', 'field_type', 'field_placeholder', 'field_required',
        'status'
    ];
}
