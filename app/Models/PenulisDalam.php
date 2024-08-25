<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PenulisDalam extends Model
{
    use HasFactory;

    protected $table        = 'penulis_dalam';

    protected $primaryKey   = 'id_penulis_dalam';

    protected $fillable     = [
        'dosen_id', 'arsip_id', 'arsip_jurnal_id', 'arsip_haki_id', 'arsip_buku_id',
        'peran_umum', 'peran_khusus', 'koresponden', 'afiliasi'
    ];

    /**
     * Get the dosen that owns the PenulisDalam
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dosen(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'dosen_id', 'id_dosen');
    }

    /**
     * Get the arsip that owns the PenulisDalam
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function arsip(): BelongsTo
    {
        return $this->belongsTo(Arsip::class, 'arsip_id', 'id_arsip');
    }

    /**
     * Get the arsipJurnal that owns the PenulisDalam
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function arsipJurnal(): BelongsTo
    {
        return $this->belongsTo(ArsipJurnal::class, 'arsip_jurnal_id', 'id_arsip_jurnal');
    }

    /**
     * Get the arsipHaki that owns the PenulisDalam
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function arsipHaki(): BelongsTo
    {
        return $this->belongsTo(ArsipHaki::class, 'arsip_haki_id', 'id_arsip_haki');
    }

    /**
     * Get the arsipBuku that owns the PenulisDalam
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function arsipBuku(): BelongsTo
    {
        return $this->belongsTo(ArsipBuku::class, 'arsip_buku_id', 'id_arsip_buku');
    }
}
