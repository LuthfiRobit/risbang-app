<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReviewKemajuanProposal extends Model
{
    use HasFactory;

    protected $table        = 'review_kemajuan_proposal';

    protected $primaryKey   = 'id_review_kemajuan_proposal';

    protected $fillable     = [
        'kemajuan_proposal_id', 'reviewer_id', 'komen', 'skor_publikasi', 'skor_pemakalah',
        'skor_bahan', 'skor_ttg', 'nilai'
    ];

    /**
     * Get the kemajuanProposal that owns the ReviewKemajuanProposal
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kemajuanProposal(): BelongsTo
    {
        return $this->belongsTo(KemajuanProposal::class, 'kemajuan_proposal_id', 'id_kemajuan_proposal');
    }
}
