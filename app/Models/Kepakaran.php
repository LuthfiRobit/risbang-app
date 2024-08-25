<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kepakaran extends Model
{
    use HasFactory;

    protected $table        = 'kepakaran';

    protected $primaryKey   = 'id_kepakaran';

    protected $fillable     = ['bidang_ilmu_id', 'nama_kepakaran', 'aktif'];

    protected $casts = [
        'id_kepakaran'      => 'integer',
        'bidang_ilmu_id'    => 'integer',
        'nama_kepakaran'    => 'string',
        'aktif'             => 'string',
    ];

    /**
     * Get all of the comments for the BidangIlmu
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bidangIlmu(): BelongsTo
    {
        return $this->belongsTo(BidangIlmu::class, 'bidang_ilmu_id', 'id_bidang_ilmu');
    }
}
