<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PelaksanaanProposal extends Model
{
    use HasFactory;

    protected $table        = 'pelaksanaan_proposal';

    protected $primaryKey   = 'id_pelaksanaan_proposal';

    protected $fillable     = [
        'proposal_id',
        'dosen_id',
        'tahun_akademik_id',
        'jenis',
        'nama_kegiatan',
        'tempat_kegiatan',
        'keterangan',
        'tanggal'
    ];

    /**
     * Get the proposal that owns the PelaksanaanProposal
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function proposal(): BelongsTo
    {
        return $this->belongsTo(Proposal::class, 'proposal_id', 'id_proposal');
    }

    /**
     * Get the dosen that owns the PelaksanaanProposal
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dosen(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'dosen_id', 'id_dosen');
    }

    /**
     * Get the tahunAkademik that owns the PelaksanaanProposal
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tahunAkademik(): BelongsTo
    {
        return $this->belongsTo(TahunAkademik::class, 'tahun_akademik_id', 'id_tahun_akademik');
    }


    /**
     * Get all of the historyPelaksanaan for the PelaksanaanProposal
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function historyPelaksanaan(): HasMany
    {
        return $this->hasMany(HistoryPelaksanaanProposal::class, 'id_pelaksanaan_proposal', 'pelaksanaan_proposal_id');
    }
}
