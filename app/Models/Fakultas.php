<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Fakultas extends Model
{
    use HasFactory;

    protected $table = 'fakultas';

    protected $primaryKey = 'id_fakultas';

    protected $fillable = ['user_id', 'nama_fakultas', 'singkatan', 'nama_dekan', 'image', 'urut', 'aktif', 'token_aktifasi_fakultas'];

    protected $casts = [
        'id_fakultas' => 'integer',
        'user_id' => 'integer',
        'nama_fakultas' => 'string',
        'singkatan' => 'string',
        'nama_dekan' => 'string',
        'image' => 'string',
        'urut' => 'integer',
        'aktif' => 'string',
        'token_aktifasi_fakultas' => 'string',
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
