<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;

    protected $table        = 'berita';

    protected $primaryKey   = 'id_berita';

    protected $fillable     = ['publish', 'judul', 'slug', 'deskripsi', 'img_berita', 'created_by'];
}
