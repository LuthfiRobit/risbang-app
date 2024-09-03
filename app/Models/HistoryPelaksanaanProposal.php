<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistoryPelaksanaanProposal extends Model
{
    use HasFactory;

    protected $table        = 'history_pelaksanaan_proposal';

    protected $primaryKey   = 'id_history_pelaksanaan_proposal';

    protected $fillable     = [
        'pelaksanaan_proposal_id',
        'nama_kegiatan',
        'tempat_kegiatan',
        'keterangan',
        'tanggal'
    ];

    /**
     * Get the pelaksanaanProposal that owns the HistoryPelaksanaanProposal
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pelaksanaanProposal(): BelongsTo
    {
        return $this->belongsTo(PelaksanaanProposal::class, 'pelaksanaan_proposal_id', 'id_pelaksanaan_proposal');
    }
}
