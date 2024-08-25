<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistoryProposalLuaran extends Model
{
    use HasFactory;

    protected $table        = 'history_proposal_luaran';

    protected $primaryKey   = 'id_history_proposal_luaran';

    protected $fillable     = [
        'proposal_luaran_id', 'judul', 'penerbit'
    ];

    /**
     * Get the user that owns the Proposal
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function proposalLuaran(): BelongsTo
    {
        return $this->belongsTo(ProposalLuaran::class, 'proposal_luaran_id', 'id_proposal_luaran');
    }
}
