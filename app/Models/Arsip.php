<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Arsip extends Model
{
    use HasFactory;

    protected $table        = 'arsip';

    protected $primaryKey   = 'id_arsip';

    protected $fillable     = [
        'proposal_id', 'dosen_id', 'tahun_akademik_id', 'jenis', 'publish',
        'judul', 'tahun_pelaksanaan', 'sumber_dana', 'jumlah_dana', 'file_arsip',
        'abstrak', 'created_by'
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
     * Get the proposal that owns the Arsip
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function proposal(): BelongsTo
    {
        return $this->belongsTo(Proposal::class, 'proposal_id', 'id_proposal');
    }

    /**
     * Get all of the penulisDalam for the Arsip
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function penulisDalam(): HasMany
    {
        return $this->hasMany(PenulisDalam::class, 'arsip_id');
    }

    /**
     * Get all of the penulisLuar for the Arsip
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function penulisLuar(): HasMany
    {
        return $this->hasMany(PenulisLuar::class, 'arsip_id');
    }

    /**
     * Get all of the penulisLain for the Arsip
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function penulisLain(): HasMany
    {
        return $this->hasMany(PenulisLain::class, 'arsip_id');
    }
}
