<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Prodi extends Model
{
    use HasFactory;

    protected $table = 'prodi';

    protected $primaryKey = 'id_prodi';

    protected $fillable = ['user_id', 'fakultas_id', 'nama_prodi', 'singkatan', 'nama_kaprodi', 'image', 'urut', 'aktif', 'token_aktifasi_prodi'];

    protected $casts = [
        'id_prodi' => 'integer',
        'user_id' => 'integer',
        'fakultas_id' => 'integer',
        'nama_prodi' => 'string',
        'singkatan' => 'string',
        'nama_kaprodi' => 'string',
        'image' => 'string',
        'urut' => 'integer',
        'aktif' => 'string',
        'token_aktifasi_prodi' => 'string',
    ];

    /**
     * Get the user that owns the Prodi
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }
}
