<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KemajuanProposal extends Model
{
    use HasFactory;

    protected $table        = 'kemajuan_proposal';

    protected $primaryKey   = 'id_kemajuan_proposal';

    protected $fillable     = [
        'proposal_id', 'dosen_id', 'tahun_akademik_id', 'jenis', 'status_review',
        'link_drive', 'file_kemajuan'
    ];

    /**
     * Get the proposal that owns the KemajuanProposal
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function proposal(): BelongsTo
    {
        return $this->belongsTo(Proposal::class, 'proposal_id', 'id_proposal');
    }

    /**
     * Get the dosen that owns the KemajuanProposal
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dosen(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'dosen_id', 'id_dosen');
    }

    /**
     * Get the tahunAkademik that owns the KemajuanProposal
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tahunAkademik(): BelongsTo
    {
        return $this->belongsTo(TahunAkademik::class, 'tahun_akademik_id', 'id_tahun_akademik');
    }

    /**
     * Get all of the historyKemajuan for the KemajuanProposal
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function historyKemajuan(): HasMany
    {
        // return $this->hasMany(HistoryKemajuanProposal::class, 'id_kemajuan_proposal', 'kemajuan_proposal_id');
        return $this->hasMany(HistoryKemajuanProposal::class, 'kemajuan_proposal_id', 'id_kemajuan_proposal'); //gpt
    }

    /**
     * Get all of the reviewKemajuan for the KemajuanProposal
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reviewKemajuan(): HasMany
    {
        // return $this->hasMany(ReviewKemajuanProposal::class, 'id_kemajuan_proposal', 'kemajuan_proposal_id');

        return $this->hasMany(ReviewKemajuanProposal::class, 'kemajuan_proposal_id', 'id_kemajuan_proposal'); //gpt
    }
}
