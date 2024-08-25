<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DosenLain extends Model
{
    use HasFactory;
    protected $table        = 'dosen_lain';

    protected $primaryKey   = 'id_dosen_lain';

    protected $fillable     = [
        'nik', 'nama', 'alamat', 'jk', 'pendidikan_terakhir',
        'no_tlpn', 'created_by'
    ];

    /**
     * Get all of the penulisLain for the DosenLain
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function penulisLain(): HasMany
    {
        return $this->hasMany(PenulisLain::class, 'dosen_lain_id');
    }
}
