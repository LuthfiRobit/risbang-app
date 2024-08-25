<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistoryAkhirProposal extends Model
{
    use HasFactory;

    protected $table        = 'history_akhir_proposal';

    protected $primaryKey   = 'id_history_akhir_proposal';

    protected $fillable     = [
        'akhir_proposal_id', 'status_review', 'keaslian', 'link_drive', 'file_akhir'
    ];

    /**
     * Get the akhirProposal that owns the HistoryAkhirProposal
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function akhirProposal(): BelongsTo
    {
        return $this->belongsTo(AkhirProposal::class, 'akhir_proposal_id', 'id_akhir_proposal');
    }
}
