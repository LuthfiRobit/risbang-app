<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Proposal extends Model
{
    use HasFactory;

    protected $table        = 'proposal';

    protected $primaryKey   = 'id_proposal';

    protected $fillable     = [
        'dosen_id', 'tahun_akademik_id', 'jenis', 'status', 'status_review',
        'jenis_penelitian', 'jenis_pengabdian', 'dana', 'judul', 'abstrak',
        'kata_kunci', 'latar_belakang', 'metode', 'rencana', 'dapus', 'file_proposal'
    ];

    /**
     * Get the dosen that owns the Proposal
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dosen(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'dosen_id', 'id_dosen');
    }

    /**
     * Get the detailReviewer that owns the Proposal
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function detailReviewer(): BelongsTo
    {
        return $this->belongsTo(DetailReviewer::class, 'detail_reviewer_id', 'id_detail_reviewer');
    }

    /**
     * Get all of the reviewProposal for the Proposal
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reviewProposal(): HasMany
    {
        return $this->hasMany(ReviewProposal::class, 'id_proposal', 'proposal_id');
    }

    /**
     * Get all of the historyProposal for the Proposal
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function historyProposal(): HasMany
    {
        return $this->hasMany(HistoryProposal::class, 'id_proposal', 'proposal_id');
    }

    /**
     * Get the kemajuanProposal associated with the Proposal
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function kemajuanProposal(): HasOne
    {
        return $this->hasOne(KemajuanProposal::class, 'proposal_id');
    }

    /**
     * Get the akhirProposal associated with the Proposal
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function akhirProposal(): HasOne
    {
        return $this->hasOne(AkhirProposal::class, 'proposal_id');
    }

    /**
     * Get the luaranProposal associated with the Proposal
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function luaranProposal(): HasOne
    {
        return $this->hasOne(LuaranProposal::class, 'proposal_id');
    }

    /**
     * Get the arsip associated with the Proposal
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function arsip(): HasOne
    {
        return $this->hasOne(Arsip::class, 'proposal_id');
    }

    /**
     * Get the arsipJurnal associated with the Proposal
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function arsipJurnal(): HasOne
    {
        return $this->hasOne(ArsipJurnal::class, 'proposal_id');
    }

    /**
     * Get the arsipHaki associated with the Proposal
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function arsipHaki(): HasOne
    {
        return $this->hasOne(ArsipHaki::class, 'proposal_id');
    }

    /**
     * Get the arsipBuku associated with the Proposal
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function arsipBuku(): HasOne
    {
        return $this->hasOne(ArsipBuku::class, 'proposal_id');
    }
}
