<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReviewAkhirProposal extends Model
{
    use HasFactory;

    protected $table        = 'review_akhir_proposal';

    protected $primaryKey   = 'id_review_akhir_proposal';

    protected $fillable     = [
        'akhir_proposal_id', 'reviewer_id', 'komen', 'nilai'
    ];

    /**
     * Get the akhirProposal that owns the ReviewAkhirProposal
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function akhirProposal(): BelongsTo
    {
        return $this->belongsTo(AkhirProposal::class, 'akhir_proposal_id', 'id_akhir_proposal');
    }
}
