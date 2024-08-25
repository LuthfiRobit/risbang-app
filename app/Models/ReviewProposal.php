<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReviewProposal extends Model
{
    use HasFactory;

    protected $table        = 'review_proposal';

    protected $primaryKey   = 'id_review_proposal';

    protected $fillable     = [
        'reviewer_id', 'dosen_id', 'proposal_id',
        'komen_judul', 'nilai_judul',
        'komen_abstrak', 'nilai_abstrak',
        'komen_kata_kunci', 'nilai_kata_kunci',
        'komen_latar_belakang', 'nilai_latar_belakang',
        'komen_metode', 'nilai_metode',
        'komen_rencana', 'nilai_rencana',
        'komen_dapus', 'nilai_dapus'
    ];

    /**
     * Get the user that owns the ReviewProposal
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function proposal(): BelongsTo
    {
        return $this->belongsTo(Proposal::class, 'proposal_id', 'id_proposal');
    }
}
