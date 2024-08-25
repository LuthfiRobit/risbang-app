<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistoryLuaranProposal extends Model
{
    use HasFactory;

    protected $table        = 'history_luaran_proposal';

    protected $primaryKey   = 'id_history_luaran_proposal';

    protected $fillable     = [
        'luaran_proposal_id', 'status_review', 'jenis_publikasi', 'judul', 'penerbit',
        'tahun_pelaksanaan', 'volume', 'nomor', 'link', 'issn',
        'file_luaran'
    ];

    /**
     * Get the luaranProposal that owns the HistoryLuaranProposal
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function luaranProposal(): BelongsTo
    {
        return $this->belongsTo(LuaranProposal::class, 'luaran_proposal_id', 'id_luaran_proposal');
    }
}
