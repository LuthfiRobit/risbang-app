<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dosen extends Model
{
    use HasFactory;

    protected $table        = 'dosen';

    protected $primaryKey   = 'id_dosen';

    protected $fillable     = [
        'user_id', 'prodi_id', 'bidang_ilmu_id', 'kepakaran_id', 'nidn',
        'nik', 'no_tlpn', 'email', 'nama_dosen', 'jk',
        'kode_pos', 'alamat', 'status_dosen', 'jabatan', 'status_serdos',
        'pendidikan_terakhir', 'instansi_pendidikan_terakhir', 'rekening', 'namabank_kantorcabang', 'nama_akunbank',
        'link_google_scholar', 'link_sinta', 'link_scopus', 'link_orcid', 'link_publons',
        'link_garuda', 'no_npwp', 'file_ktp', 'file_sk_dosen', 'file_npwp',
        'img_ttd', 'img_profil', 'token_aktifasi_dosen'
    ];

    protected $casts = [
        'user_id' => 'integer',
        'prodi_id' => 'integer',
        'bidang_ilmu_id' => 'integer',
        'kepakaran_id' => 'integer',
        'nidn' => 'string',
        'nik' => 'string',
        'no_tlpn' => 'string',
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
     * Get the prodi that owns the Dosen
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function prodi(): BelongsTo
    {
        return $this->belongsTo(Prodi::class, 'prodi_id', 'id_prodi');
    }

    /**
     * Get all of the arsip for the Dosen
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function arsip(): HasMany
    {
        return $this->hasMany(Arsip::class, 'dosen_id');
    }

    /**
     * Get all of the arsipJurnal for the Dosen
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function arsipJurnal(): HasMany
    {
        return $this->hasMany(ArsipJurnal::class, 'dosen_id');
    }

    /**
     * Get all of the arsipHaki for the Dosen
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function arsipHaki(): HasMany
    {
        return $this->hasMany(ArsipHaki::class, 'dosen_id');
    }

    /**
     * Get all of the arsipBuku for the Dosen
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function arsipBuku(): HasMany
    {
        return $this->hasMany(ArsipBuku::class, 'dosen_id');
    }

    /**
     * Get all of the penulisDalam for the Dosen
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function penulisDalam(): HasMany
    {
        return $this->hasMany(PenulisDalam::class, 'dosen_id');
    }
}
