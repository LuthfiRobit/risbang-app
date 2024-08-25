<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reviewer extends Model
{
    use HasFactory;

    protected $table        = 'reviewer';

    protected $primaryKey   = 'id_reviewer';

    protected $fillable     = ['user_id', 'nama_reviewer', 'aktif'];

    protected $casts = [
        'id_reviewer'      => 'integer',
        'user_id'    => 'integer',
        'nama_reviewer'    => 'string',
        'aktif'             => 'string',
    ];

    /**
     * Get the user that owns the Reviewer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }

    /**
     * Get all of the detailReviewer for the Reviewer
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function detailReviewer(): HasMany
    {
        return $this->hasMany(DetailReviewer::class, 'id_reviewer', 'reviewer_id');
    }
}
