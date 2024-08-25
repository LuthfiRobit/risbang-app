<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BidangIlmu extends Model
{
    use HasFactory;

    protected $table = 'bidang_ilmu';

    protected $primaryKey = 'id_bidang_ilmu';

    protected $fillable = ['nama_bidang_ilmu', 'aktif'];

    protected $casts = [
        'id_bidang_ilmu' => 'integer',
        'nama_bidang_ilmu' => 'string',
        'aktif' => 'string',
    ];

    /**
     * Get all of the comments for the BidangIlmu
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function kepakaran(): HasMany
    {
        return $this->hasMany(Kepakaran::class, 'bidang_ilmu_id', 'id_bidang_ilmu');
    }
}
