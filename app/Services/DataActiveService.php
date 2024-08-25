<?php

namespace App\Services;

use App\Models\Proposal;
use App\Models\TahunAkademik;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Throwable;

class DataActiveService
{
    public function tahunAkademik()
    {
        $ta = TahunAkademik::where('aktif', 'y')->first();
        return $ta ? $ta->id_tahun_akademik : null;
    }

    public function proposalPenelitian($taId, $dosenId)
    {
        $penelitian = Proposal::where([['jenis', 'Penelitian'], ['tahun_akademik_id', $taId], ['dosen_id', $dosenId]])->first();
        return $penelitian ? $penelitian->id_proposal : null;
    }

    public function proposalPengabdian($taId, $dosenId)
    {
        $pengabdian = Proposal::where([['jenis', 'Pengabdian'], ['tahun_akademik_id', $taId], ['dosen_id', $dosenId]])->first();
        return $pengabdian ? $pengabdian->id_proposal : null;
    }
}
