<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReviewLuaranProposal extends Model
{
    use HasFactory;

    protected $table        = 'review_luaran_proposal';

    protected $primaryKey   = 'id_review_luaran_proposal';

    protected $fillable     = [
        'luaran_proposal_id', 'reviewer_id', 'komen', 'nilai'
    ];

    /**
     * Get the luaranProposal that owns the ReviewLuaranProposal
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function luaranProposal(): BelongsTo
    {
        return $this->belongsTo(LuaranProposal::class, 'luaran_proposal_id', 'id_luaran_proposal');
    }
}
