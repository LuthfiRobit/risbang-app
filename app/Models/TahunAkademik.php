<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TahunAkademik extends Model
{
    use HasFactory;

    protected $table = 'tahun_akademik';

    protected $primaryKey = 'id_tahun_akademik';

    protected $fillable = ['tahun_awal', 'tahun_akhir', 'nama_tahun_akademik', 'aktif', 'buku', 'haki', 'nilai_baru', 'token_aktifasi_tahun_akademik'];

    protected $casts = [
        'id_tahun_akademik' => 'integer',
        'tahun_awal' => 'integer',
        'tahun_akhir' => 'integer',
        'nama_tahun_akademik' => 'string',
        'aktif' => 'string',
        'buku' => 'string',
        'haki' => 'string',
        'nilai_baru' => 'string',
        'token_aktifasi_tahun_akademik' => 'string',
    ];

    /**
     * Get all of the comments for the TahunAkademik
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function deadlineProposal(): HasMany
    {
        return $this->hasMany(DeadlineProposal::class, 'tahun_akademik_id', 'id_tahun_akademik');
    }

    /**
     * Get all of the comments for the TahunAkademik
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function detailReviewer(): HasMany
    {
        return $this->hasMany(DetailReviewer::class, 'tahun_akademik_id', 'id_tahun_akademik');
    }

    /**
     * Get all of the arsip for the Dosen
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function arsip(): HasMany
    {
        return $this->hasMany(Arsip::class, 'tahun_akademik_id');
    }

    /**
     * Get all of the arsipJurnal for the Dosen
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function arsipJurnal(): HasMany
    {
        return $this->hasMany(ArsipJurnal::class, 'tahun_akademik_id');
    }

    /**
     * Get all of the arsipHaki for the Dosen
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function arsipHaki(): HasMany
    {
        return $this->hasMany(ArsipHaki::class, 'tahun_akademik_id');
    }

    /**
     * Get all of the arsipBuku for the Dosen
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function arsipBuku(): HasMany
    {
        return $this->hasMany(ArsipBuku::class, 'tahun_akademik_id');
    }
}
