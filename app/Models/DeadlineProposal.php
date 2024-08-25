<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeadlineProposal extends Model
{
    use HasFactory;
    protected $table = 'deadline_proposal';

    protected $primaryKey = 'id_deadline_proposal';

    protected $fillable = [
        'id_deadline_proposal',
        'tahun_akademik_id',
        'tanggal_mulai',
        'tanggal_akhir',
        'nama_deadline_proposal',
        'jenis',
        'keterangan',
        'deskripsi',
        'aktif'
    ];

    protected $casts = [
        'id_deadline_proposal' => 'integer',
        'nama_deadline_proposal' => 'string',
        'aktif' => 'string',
    ];

    /**
     * Get the user that owns the DeadlineProposal
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tahunAkademik(): BelongsTo
    {
        return $this->belongsTo(TahunAkademik::class, 'tahun_akademik_id', 'id_tahun_akademik');
    }
}
