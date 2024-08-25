<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DetailReviewer extends Model
{
    use HasFactory;


    protected $table        = 'detail_reviewer';

    protected $primaryKey   = 'id_detail_reviewer';

    protected $fillable     = [
        'tahun_akademik_id', 'reviewer_id', 'dosen_id', 'keterangan'
    ];

    /**
     * Get the user that owns the DetailReviewer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(Reviewer::class, 'reviewer_id', 'id_reviewer');
    }

    /**
     * Get the user that owns the DetailReviewer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tahunAkademik(): BelongsTo
    {
        return $this->belongsTo(TahunAkademik::class, 'tahun_akademik_id', 'id_tahun_akademik');
    }
}
