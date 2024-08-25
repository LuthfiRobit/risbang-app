<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DosenLuar extends Model
{
    use HasFactory;

    protected $table        = 'dosen_luar';

    protected $primaryKey   = 'id_dosen_luar';

    protected $fillable     = [
        'nidn', 'nama', 'kampus', 'alamat_kampus', 'jk',
        'pendidikan_terakhir', 'no_tlpn', 'created_by'
    ];

    /**
     * Get all of the penulisLuar for the DosenLuar
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function penulisLuar(): HasMany
    {
        return $this->hasMany(PenulisLuar::class, 'dosen_luar_id');
    }
}
