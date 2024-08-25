<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AkhirProposal extends Model
{
    use HasFactory;

    protected $table        = 'akhir_proposal';

    protected $primaryKey   = 'id_akhir_proposal';

    protected $fillable     = [
        'proposal_id', 'dosen_id', 'tahun_akademik_id', 'jenis', 'status_review',
        'keaslian', 'link_drive', 'file_akhir'
    ];

    /**
     * Get the proposal that owns the AkhirProposal
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function proposal(): BelongsTo
    {
        return $this->belongsTo(Proposal::class, 'proposal_id', 'id_proposal');
    }

    /**
     * Get the dosen that owns the AkhirProposal
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dosen(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'dosen_id', 'id_dosen');
    }

    /**
     * Get the tahunAkademik that owns the AkhirProposal
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tahunAkademik(): BelongsTo
    {
        return $this->belongsTo(TahunAkademik::class, 'tahun_akademik_id', 'id_tahun_akademik');
    }


    /**
     * Get all of the historyAkhir for the AkhirProposal
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function historyAkhir(): HasMany
    {
        return $this->hasMany(HistoryAkhirProposal::class, 'id_akhir_proposal', 'akhir_proposal_id');
    }

    /**
     * Get all of the reviewAkhir for the AkhirProposal
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reviewAkhir(): HasMany
    {
        return $this->hasMany(ReviewAkhirProposal::class, 'id_akhir_proposal', 'akhir_proposal_id');
    }
}
