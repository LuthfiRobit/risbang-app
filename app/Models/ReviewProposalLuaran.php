<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReviewProposalLuaran extends Model
{
    use HasFactory;

    protected $table        = 'review_proposal_luaran';

    protected $primaryKey   = 'id_review_proposal_luaran';

    protected $fillable     = [
        'reviewer_id', 'dosen_id', 'proposal_luaran_id',
        'komen', 'nilai',
    ];

    /**
     * Get the user that owns the ReviewProposal
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function proposalLuaran(): BelongsTo
    {
        return $this->belongsTo(ProposalLuaran::class, 'proposal_luaran_id', 'id_proposal_luaran');
    }
}
