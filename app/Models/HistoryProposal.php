<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistoryProposal extends Model
{
    use HasFactory;

    protected $table        = 'history_proposal';

    protected $primaryKey   = 'id_history_proposal';

    protected $fillable     = [
        'proposal_id', 'dana', 'judul', 'abstrak', 'kata_kunci',
        'latar_belakang', 'metode', 'rencana', 'dapus', 'file_proposal'
    ];

    /**
     * Get the user that owns the Proposal
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function proposal(): BelongsTo
    {
        return $this->belongsTo(Proposal::class, 'proposal_id', 'id_proposal');
    }
}
