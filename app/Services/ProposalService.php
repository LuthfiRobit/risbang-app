<?php

namespace App\Services;

use App\Models\AkhirProposal;
use App\Models\KemajuanProposal;
use App\Models\LuaranProposal;
use App\Models\PelaksanaanProposal;
use App\Models\Proposal;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Throwable;

class ProposalService
{
    public function proposalAccess($id, $dosenId)
    {
        $penelitian = Proposal::where([['jenis', 'Penelitian'], ['tahun_akademik_id', $id], ['dosen_id', $dosenId]])->first();
        $pengabdian = Proposal::where([['jenis', 'Pengabdian'], ['tahun_akademik_id', $id], ['dosen_id', $dosenId]])->first();
        $kemaPene = KemajuanProposal::where([['jenis', 'Penelitian'], ['tahun_akademik_id', $id], ['dosen_id', $dosenId]])->first();
        $kemaPeng = KemajuanProposal::where([['jenis', 'Pengabdian'], ['tahun_akademik_id', $id], ['dosen_id', $dosenId]])->first();
        $akhirPene = AkhirProposal::where([['jenis', 'Penelitian'], ['tahun_akademik_id', $id], ['dosen_id', $dosenId]])->first();
        $akhirPeng = AkhirProposal::where([['jenis', 'Pengabdian'], ['tahun_akademik_id', $id], ['dosen_id', $dosenId]])->first();
        $luaranPene = LuaranProposal::where([['jenis', 'Penelitian'], ['tahun_akademik_id', $id], ['dosen_id', $dosenId]])->first();
        $luaranPeng = LuaranProposal::where([['jenis', 'Pengabdian'], ['tahun_akademik_id', $id], ['dosen_id', $dosenId]])->first();
        $pelaksanaanPene = PelaksanaanProposal::where([['jenis', 'Penelitian'], ['tahun_akademik_id', $id], ['dosen_id', $dosenId]])->first();
        $pelaksanaanPeng = PelaksanaanProposal::where([['jenis', 'Pengabdian'], ['tahun_akademik_id', $id], ['dosen_id', $dosenId]])->first();

        $accessPengajuan = $penelitian && $pengabdian && $penelitian->status_review == 'Diterima' && $pengabdian->status_review == 'Diterima';
        $accessKemajuan = $kemaPene && $kemaPeng && $kemaPene->status_review == 'Diterima' && $kemaPeng->status_review == 'Diterima';
        $accessAkhir = $akhirPene && $akhirPeng && $akhirPene->status_review == 'Diterima' && $akhirPeng->status_review == 'Diterima';
        $accessLuaran = $luaranPene && $luaranPeng && $luaranPene->status_review == 'Diterima' && $luaranPeng->status_review == 'Diterima';
        $accessPelaksanaan = $pelaksanaanPene && $pelaksanaanPeng && $pelaksanaanPene->status_review == 'Diterima' && $pelaksanaanPeng->status_review == 'Diterima';


        return [
            'access_pengajuan' => $accessPengajuan,
            'access_kemajuan' => $accessKemajuan,
            'access_akhir' => $accessAkhir,
            'access_luaran' => $accessLuaran,
            'access_pelaksanaan' => $accessPelaksanaan,
            'id_pene' => $penelitian ? $penelitian->id_proposal : null,
            'id_peng' => $pengabdian ? $pengabdian->id_proposal : null,
        ];
    }
}
