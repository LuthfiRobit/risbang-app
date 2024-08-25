<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistoryKemajuanProposal extends Model
{
    use HasFactory;

    protected $table        = 'history_kemajuan_proposal';

    protected $primaryKey   = 'id_history_kemajuan_proposal';

    protected $fillable     = [
        'kemajuan_proposal_id', 'status_review', 'link_drive', 'file_kemajuan'
    ];

    /**
     * Get the kemajuanProposal that owns the HistoryKemajuanProposal
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kemajuanProposal(): BelongsTo
    {
        return $this->belongsTo(KemajuanProposal::class, 'kemajuan_proposal_id', 'id_kemajuan_proposal');
    }
}
