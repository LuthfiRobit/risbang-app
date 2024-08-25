<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LuaranProposal extends Model
{
    use HasFactory;

    protected $table        = 'luaran_proposal';

    protected $primaryKey   = 'id_luaran_proposal';

    protected $fillable     = [
        'proposal_id', 'dosen_id', 'tahun_akademik_id', 'jenis', 'status_review',
        'jenis_publikasi', 'judul', 'penerbit', 'tahun_pelaksanaan', 'volume',
        'nomor', 'link', 'issn', 'file_luaran'
    ];

    /**
     * Get the proposal that owns the LuaranProposal
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function proposal(): BelongsTo
    {
        return $this->belongsTo(Proposal::class, 'proposal_id', 'id_proposal');
    }

    /**
     * Get the dosen that owns the LuaranProposal
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dosen(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'dosen_id', 'id_dosen');
    }

    /**
     * Get the tahunAkademik that owns the LuaranProposal
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tahunAkademik(): BelongsTo
    {
        return $this->belongsTo(TahunAkademik::class, 'tahun_akademik_id', 'id_tahun_akademik');
    }


    /**
     * Get all of the historyLuaran for the LuaranProposal
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function historyLuaran(): HasMany
    {
        return $this->hasMany(HistoryLuaranProposal::class, 'id_luaran_proposal', 'luaran_proposal_id');
    }

    /**
     * Get all of the reviewLuaran for the LuaranProposal
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reviewLuaran(): HasMany
    {
        return $this->hasMany(ReviewLuaranProposal::class, 'id_luaran_proposal', 'luaran_proposal_id');
    }
}
