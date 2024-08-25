<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArsipProduk extends Model
{
    use HasFactory;
    protected $table        = 'arsip_produk';

    protected $primaryKey   = 'id_arsip_produk';

    protected $fillable     = [
        'arsip_id',
        'dosen_id',
        'tahun_akademik_id',
        'jenis',
        'publish',
        'judul',
        'tkt',
        'level',
        'tahun_pelaksanaan',
        'link',
        'mitra',
        'jenis_mitra',
        'negara_mitra',
        'deskripsi',
        'file_arsip_produk',
        'cover_arsip_produk',
        'created_by'
    ];

    /**
     * Get the dosen that owns the Arsip
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dosen(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'dosen_id', 'id_dosen');
    }

    /**
     * Get the tahunAkademik that owns the Arsip
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tahunAkademik(): BelongsTo
    {
        return $this->belongsTo(TahunAkademik::class, 'tahun_akademik_id', 'id_tahun_akademik');
    }

    /**
     * Get the arsip that owns the Arsip
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function arsip(): BelongsTo
    {
        return $this->belongsTo(Arsip::class, 'arsip_id', 'id_arsip');
    }
}
