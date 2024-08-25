<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProposalLuaran extends Model
{
    use HasFactory;

    protected $table        = 'proposal_luaran';

    protected $primaryKey   = 'id_proposal_luaran';

    protected $fillable     = [
        'dosen_id', 'tahun_akademik_id', 'jenis_luaran', 'jenis_publikasi', 'jenis_haki',
        'jenis_buku', 'status', 'status_review', 'judul', 'penerbit'
    ];

    /**
     * Get the proposal that owns the Proposal
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function proposal(): BelongsTo
    {
        return $this->belongsTo(Proposal::class, 'proposal_id', 'id_proposal');
    }


    /**
     * Get all of the historyProposalLuaran for the Proposal
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function historyProposalLuaran(): HasMany
    {
        return $this->hasMany(HistoryProposalLuaran::class, 'id_proposal_luaran', 'proposal_luaran_id');
    }
}
