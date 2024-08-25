<?php

namespace App\Services;

use App\Models\AkhirProposal;
use App\Models\DeadlineProposal;
use App\Models\KemajuanProposal;
use App\Models\LuaranProposal;
use App\Models\Proposal;
use App\Models\TahunAkademik;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Throwable;

class ProposalValidationService
{
    public function validate($jenis, $kegiatan)
    {
        $dosen = Auth::user()->user_role == 'dosen' ? Auth::user()->dosen->id_dosen : null;
        $currentDate = Carbon::now();
        //ganti dengan query get tahun akademik yang aktif tahun_akademik_id
        // $academicYearId = session('academic_year_id'); // Assuming the academic year is stored in the session
        $academicYearId = TahunAkademik::select('id_tahun_akademik')->where('aktif', 'y')->first();

        $deadline = DeadlineProposal::where('tahun_akademik_id', $academicYearId->id_tahun_akademik)
            ->where('jenis', $jenis)
            ->where('keterangan', $kegiatan)
            ->where('aktif', 'y')
            ->first();

        if (!$deadline) {
            return ['success' => false, 'message' => 'Deadline ' . $kegiatan . ' ' . $jenis . ' tidak ditemukan.'];
            // return response()->json(['success' => true, 'message' => $message, 'data' => $data], $statusCode);
        }

        if ($currentDate->gt(Carbon::parse($deadline->tanggal_akhir))) {
            return ['success' => false, 'message' => 'Deadline ' . $kegiatan . ' ' . $jenis . ' sudah berlalu.'];
        }

        $proposal = Proposal::where('dosen_id', $dosen)
            ->where('tahun_akademik_id', $academicYearId->id_tahun_akademik)
            ->where('jenis', $jenis)
            // ->where('jenis_kegiatan', $jenis_kegiatan)
            ->latest()
            ->first();

        if ($kegiatan == 'Proposal') {
            if ($proposal && in_array($proposal->status_review, ['Diterima', 'Ditolak'])) {
                return ['success' => false, 'message' => 'Anda tidak dapat mengajukan atau mengedit proposal ' . $jenis . ' yang sudah diterima atau ditolak.'];
            }
        } elseif ($kegiatan == 'Kemajuan') {
            if (!$proposal || $proposal->status_review != 'Diterima') {
                return ['success' => false, 'message' => 'Anda tidak dapat mengajukan atau mengedit kemajuan ' . $jenis . ' jika proposal belum diterima.'];
            }

            // $kemajuan = $proposal->kemajuan()->where('jenis_kegiatan', $jenis_kegiatan)->latest()->first();
            $kemajuan = $proposal->kemajuanProposal()->latest()->first();
            if ($kemajuan && in_array($kemajuan->status_review, ['Diterima', 'Ditolak'])) {
                return ['success' => false, 'message' => 'Anda tidak dapat mengajukan atau mengedit kemajuan ' . $jenis . ' yang sudah diterima atau ditolak.'];
            }
        } elseif ($kegiatan == 'Akhir') {
            if (!$proposal || $proposal->status_review != 'Diterima') {
                return ['success' => false, 'message' => 'Anda tidak dapat mengajukan atau mengedit akhir ' . $jenis . ' jika proposal belum diterima.'];
            }

            // $akhir = $proposal->akhirProposal()->where('jenis_kegiatan', $jenis_kegiatan)->latest()->first();
            $kemajuan = $proposal->kemajuanProposal()->latest()->first();
            if (!$kemajuan || $kemajuan->status_review != 'Diterima') {
                return ['success' => false, 'message' => 'Anda tidak dapat mengajukan atau mengedit akhir ' . $jenis . ' jika kemajuan belum diterima'];
            }

            // $akhir = $proposal->akhirProposal()->where('jenis_kegiatan', $jenis_kegiatan)->latest()->first();
            $akhir = $proposal->akhirProposal()->latest()->first();
            if ($akhir && in_array($akhir->status_review, ['Diterima', 'Ditolak'])) {
                return ['success' => false, 'message' => 'Anda tidak dapat mengajukan atau mengedit akhir ' . $jenis . ' yang sudah diterima atau ditolak.'];
            }
        } elseif ($kegiatan == 'Luaran') {
            if (!$proposal || $proposal->status_review != 'Diterima') {
                return ['success' => false, 'message' => 'Anda tidak dapat mengajukan atau mengedit luaran ' . $jenis . ' jika proposal belum diterima.'];
            }

            // $akhir = $proposal->akhirProposal()->where('jenis_kegiatan', $jenis_kegiatan)->latest()->first();
            $akhir = $proposal->akhirProposal()->latest()->first();
            if (!$akhir || $akhir->status_review != 'Diterima') {
                return ['success' => false, 'message' => 'Anda tidak dapat mengajukan atau mengedit luaran ' . $jenis . ' jika akhir belum diterima.'];
            }

            // $luaran = $proposal->luaranProposal()->where('jenis_kegiatan', $jenis_kegiatan)->latest()->first();
            $luaran = $proposal->luaranProposal()->latest()->first();
            if ($luaran && in_array($luaran->status_review, ['Diterima', 'Ditolak'])) {
                return ['success' => false, 'message' => 'Anda tidak dapat mengajukan atau mengedit luaran ' . $jenis . ' yang sudah diterima atau ditolak.'];
            }
        }

        return ['success' => true];
    }
}
