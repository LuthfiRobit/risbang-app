<?php

use App\Http\Controllers\Akun\AkunAdminController;
use App\Http\Controllers\Akun\AkunController;
use App\Http\Controllers\Akun\AkunDosenController;
use App\Http\Controllers\Akun\AkunReviewerController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Cms\BeritaController;
use App\Http\Controllers\Cms\PengumumanController;
use App\Http\Controllers\Cms\ProfilController;
use App\Http\Controllers\DosenManagementController;
use App\Http\Controllers\LandPage\LandPageController;
use App\Http\Controllers\Laporan\LaporanPenelitianController;
use App\Http\Controllers\Laporan\LaporanPengabdianController;
use App\Http\Controllers\Laporan\LuaranPenelitianController;
use App\Http\Controllers\Laporan\LuaranPengabdianController;
use App\Http\Controllers\Laporan\PenulisController;
use App\Http\Controllers\Master\BidangIlmuController;
use App\Http\Controllers\Master\DeadlineProposalController;
use App\Http\Controllers\Master\DosenController;
use App\Http\Controllers\Master\DosenLainController;
use App\Http\Controllers\Master\DosenLuarController;
use App\Http\Controllers\Master\FakultasController;
use App\Http\Controllers\Master\KepakaranController;
use App\Http\Controllers\Master\PlotingReviewerController;
use App\Http\Controllers\Master\ProdiController;
use App\Http\Controllers\Master\RentanWaktuController;
use App\Http\Controllers\Master\ReviewerController;
use App\Http\Controllers\Master\TahunAkademikController;
use App\Http\Controllers\Proposal\AkhirProposalController;
use App\Http\Controllers\Proposal\KemajuanProposalController;
use App\Http\Controllers\Proposal\LuaranProposalController;
use App\Http\Controllers\Proposal\PelaksanaanProposalController;
use App\Http\Controllers\Proposal\ProposalController;
use App\Http\Controllers\Proposal\ProposalLuaranController;
use App\Http\Controllers\Proposal\ProposalPenelitianController;
use App\Http\Controllers\Proposal\ProposalPengabdianController;
use App\Http\Controllers\Report\ReportAkhirController;
use App\Http\Controllers\Report\ReportArsipBukuController;
use App\Http\Controllers\Report\ReportArsipController;
use App\Http\Controllers\Report\ReportArsipHakiController;
use App\Http\Controllers\Report\ReportArsipJurnalController;
use App\Http\Controllers\Report\ReportArsipProdukController;
use App\Http\Controllers\Report\ReportArsipPrototypeController;
use App\Http\Controllers\Report\ReportKemajuanController;
use App\Http\Controllers\Report\ReportLuaranController;
use App\Http\Controllers\Report\ReportPelaksanaanController;
use App\Http\Controllers\Report\ReportProposalController;
use App\Http\Controllers\Review\ReviewAkhirController;
use App\Http\Controllers\Review\ReviewKemajuanController;
use App\Http\Controllers\Review\ReviewLuaranController;
use App\Http\Controllers\Review\ReviewProposalController;
use App\Http\Controllers\Roadmap\RoadmapDosenController;
use App\Http\Controllers\Roadmap\RoadmapProdiController;
use App\Http\Controllers\Surat\SuratMoaController;
use App\Http\Controllers\Surat\SuratTugasController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'loginPost'])->name('login.post');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('unauthorized', [AuthController::class, 'unauthorized'])->name('unauthorized');


Route::get('/', function () {
    return view('landpage.home.index');
})->middleware(['guest'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard.admin');
})->middleware(['auth'])->name('dashboard');

Route::middleware('guest')->prefix('landpage')->name('landpage.')->group(function () {
    Route::get('chart-pie-dosen', [LandPageController::class, 'chartPieDosen'])->name('chart.pie.dosen');
    Route::get('chart-bar-dosen', [LandPageController::class, 'chartBarDosen'])->name('chart.bar.dosen');

    Route::prefix('profil')->name('profil.')->group(function () {
        Route::get('/show', [LandPageController::class, 'showProfil'])->name('show');
        Route::get('/list-anggota', [LandPageController::class, 'listAnggota'])->name('list.anggota');
    });

    Route::prefix('dosen')->name('dosen.')->group(function () {
        Route::get('/', [LandPageController::class, 'indexDosen'])->name('index');
        Route::get('/list', [LandPageController::class, 'listDosen'])->name('list');
    });

    Route::prefix('berita')->name('berita.')->group(function () {
        Route::get('/', [LandPageController::class, 'indexBerita'])->name('index');
        Route::get('detail/{slug}', [LandPageController::class, 'detailBerita'])->name('detail');
        Route::get('show/{slug}', [LandPageController::class, 'showBerita'])->name('show');
        Route::get('/list', [LandPageController::class, 'listBerita'])->name('list');
        Route::get('/list-terbaru', [LandPageController::class, 'listBeritaTerbaru'])->name('list.terbaru');
        Route::get('list-utama', [LandPageController::class, 'listBeritaUtama'])->name('list.utama');
    });

    Route::prefix('pengumuman')->name('pengumuman.')->group(function () {
        Route::get('/', [LandPageController::class, 'indexPengumuman'])->name('index');
        Route::get('/list', [LandPageController::class, 'listPengumuman'])->name('list');
        Route::get('/list-utama', [LandPageController::class, 'listPengumumanUtama'])->name('list.utama');
    });
});

Route::middleware(['auth', 'user.role:admin'])->prefix('master')->name('master.')->group(function () {

    Route::prefix('bidangIlmu')->name('bidang.ilmu.')->group(function () {
        Route::get('/', [BidangIlmuController::class, 'index'])->name('index');
        Route::get('/list', [BidangIlmuController::class, 'list'])->name('list');
        Route::get('/{id}', [BidangIlmuController::class, 'show'])->name('show');
        Route::post('/store', [BidangIlmuController::class, 'store'])->name('store');
        Route::put('/{id}/update', [BidangIlmuController::class, 'update'])->name('update');
        Route::post('/update/multiple', [BidangIlmuController::class, 'updateMultiple'])->name('update.multiple');
    });

    Route::prefix('kepakaran')->name('kepakaran.')->group(function () {
        Route::get('/', [KepakaranController::class, 'index'])->name('index');
        Route::get('/list', [KepakaranController::class, 'list'])->name('list');
        Route::get('/{id}', [KepakaranController::class, 'show'])->name('show');
        Route::post('/store', [KepakaranController::class, 'store'])->name('store');
        Route::put('/{id}/update', [KepakaranController::class, 'update'])->name('update');
        Route::post('/update/multiple', [KepakaranController::class, 'updateMultiple'])->name('update.multiple');
    });

    Route::prefix('rentanwaktu')->name('rentan.waktu.')->group(function () {
        Route::get('/', [RentanWaktuController::class, 'index'])->name('index');
        Route::get('/list', [RentanWaktuController::class, 'list'])->name('list');
        Route::get('/{id}', [RentanWaktuController::class, 'show'])->name('show');
        Route::post('/store', [RentanWaktuController::class, 'store'])->name('store');
        Route::put('/{id}/update', [RentanWaktuController::class, 'update'])->name('update');
        Route::post('/update/multiple', [RentanWaktuController::class, 'updateMultiple'])->name('update.multiple');
    });

    Route::prefix('reviewer')->name('reviewer.')->group(function () {
        Route::get('/', [ReviewerController::class, 'index'])->name('index');
        Route::get('/list', [ReviewerController::class, 'list'])->name('list');
        Route::get('/{id}', [ReviewerController::class, 'show'])->name('show');
        Route::post('/store', [ReviewerController::class, 'store'])->name('store');
        Route::put('/{id}/update', [ReviewerController::class, 'update'])->name('update');
        Route::post('/update/multiple', [ReviewerController::class, 'updateMultiple'])->name('update.multiple');
    });
});

Route::middleware(['auth', 'user.role:admin'])->prefix('tendik')->name('tendik.')->group(function () {

    Route::prefix('tahunakademik')->name('tahun.akademik.')->group(function () {
        Route::get('/', [TahunAkademikController::class, 'index'])->name('index');
        Route::get('/list', [TahunAkademikController::class, 'list'])->name('list');
        Route::get('/list/json', [TahunAkademikController::class, 'listJson'])->name('list.json');
        Route::get('/{id}', [TahunAkademikController::class, 'show'])->name('show');
        Route::post('/store', [TahunAkademikController::class, 'store'])->name('store');
        Route::put('/{id}/update', [TahunAkademikController::class, 'update'])->name('update');
        Route::post('/update/multiple', [TahunAkademikController::class, 'updateMultiple'])->name('update.multiple');
    });

    Route::prefix('fakultas')->name('fakultas.')->group(function () {
        Route::get('/', [FakultasController::class, 'index'])->name('index');
        Route::get('/list', [FakultasController::class, 'list'])->name('list');
        Route::get('/list/json', [FakultasController::class, 'listJson'])->name('list.json');
        Route::get('/{id}', [FakultasController::class, 'show'])->name('show');
        Route::post('/store', [FakultasController::class, 'store'])->name('store');
        Route::put('/{id}/update', [FakultasController::class, 'update'])->name('update');
        Route::post('/update/multiple', [FakultasController::class, 'updateMultiple'])->name('update.multiple');
    });

    Route::prefix('prodi')->name('prodi.')->group(function () {
        Route::get('/', [ProdiController::class, 'index'])->name('index');
        Route::get('/list', [ProdiController::class, 'list'])->name('list');
        Route::get('/{id}', [ProdiController::class, 'show'])->name('show');
        Route::post('/store', [ProdiController::class, 'store'])->name('store');
        Route::put('/{id}/update', [ProdiController::class, 'update'])->name('update');
        Route::post('/update/multiple', [ProdiController::class, 'updateMultiple'])->name('update.multiple');
        Route::get('/byfakultas/{id}', [ProdiController::class, 'byFakultas'])->name('by.fakultas');
        Route::post('/import-excel', [ProdiController::class, 'importExcel'])->name('import.excel');
        Route::get('/export/excel', [ProdiController::class, 'exportExcel'])->name('export.excel');
    });

    Route::prefix('dosen')->name('dosen.')->group(function () {
        Route::get('/', [DosenController::class, 'index'])->name('index');
        Route::get('/list', [DosenController::class, 'list'])->name('list');
        Route::get('/{id}', [DosenController::class, 'show'])->name('show');
        Route::post('/store', [DosenController::class, 'store'])->name('store');
        Route::put('/{id}/update', [DosenController::class, 'update'])->name('update');
        Route::post('/update/multiple', [DosenController::class, 'updateMultiple'])->name('update.multiple');
        Route::post('/import-excel', [DosenController::class, 'importExcel'])->name('import.excel');
    });
});

Route::middleware(['auth', 'user.role:admin,developer'])->prefix('setting')->name('setting.')->group(function () {

    Route::prefix('dosenmanagement')->name('dosen.management.')->group(function () {
        Route::get('/', [DosenManagementController::class, 'index'])->name('index');
        Route::get('/list', [DosenManagementController::class, 'list'])->name('list');
        Route::get('/{id}', [DosenManagementController::class, 'show'])->name('show');
        Route::post('/store', [DosenManagementController::class, 'store'])->name('store');
        Route::put('/{id}/update', [DosenManagementController::class, 'update'])->name('update');
        Route::post('/update/multiple', [DosenManagementController::class, 'updateMultiple'])->name('update.multiple');
    });

    Route::prefix('deadlineproposal')->name('deadline.proposal.')->group(function () {
        Route::get('/', [DeadlineProposalController::class, 'index'])->name('index');
        Route::get('/list', [DeadlineProposalController::class, 'list'])->name('list');
        Route::get('/{id}', [DeadlineProposalController::class, 'show'])->name('show');
        Route::post('/store', [DeadlineProposalController::class, 'store'])->name('store');
        Route::put('/{id}/update', [DeadlineProposalController::class, 'update'])->name('update');
        Route::post('/update/multiple', [DeadlineProposalController::class, 'updateMultiple'])->name('update.multiple');
    });

    Route::prefix('ploting-reviewer')->name('ploting.reviewer.')->group(function () {
        Route::get('/', [PlotingReviewerController::class, 'index'])->name('index');
        Route::get('/list', [PlotingReviewerController::class, 'list'])->name('list');
        Route::get('/index-reviewer', [PlotingReviewerController::class, 'indexReviewer'])->name('index.reviewer');
        Route::get('/list-reviewer', [PlotingReviewerController::class, 'listReviewer'])->name('list.reviewer');
        Route::get('/create-ploting', [PlotingReviewerController::class, 'createPloting'])->name('create');
        Route::post('/store-ploting', [PlotingReviewerController::class, 'storePloting'])->name('store');
        Route::get('/list-ploted', [PlotingReviewerController::class, 'listPloted'])->name('list.ploted');
        Route::get('/list-unploted', [PlotingReviewerController::class, 'listUnploted'])->name('list.unploted');
        Route::delete('/destroy-ploted/{id}', [PlotingReviewerController::class, 'destroyPloted'])->name('destroy.ploted');
    });
});

Route::middleware(['auth', 'user.role:admin,developer'])->prefix('cms')->name('cms.')->group(function () {

    Route::prefix('berita')->name('berita.')->group(function () {
        Route::get('/', [BeritaController::class, 'index'])->name('index');
        Route::get('/list', [BeritaController::class, 'list'])->name('list');
        Route::get('/show/{id}', [BeritaController::class, 'show'])->name('show');
        Route::get('/edit/{id}', [BeritaController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [BeritaController::class, 'update'])->name('update');
        Route::get('/create', [BeritaController::class, 'create'])->name('create');
        Route::post('/store', [BeritaController::class, 'store'])->name('store');
    });

    Route::prefix('pengumuman')->name('pengumuman.')->group(function () {
        Route::get('/', [PengumumanController::class, 'index'])->name('index');
        Route::get('/list', [PengumumanController::class, 'list'])->name('list');
        Route::get('/show/{id}', [PengumumanController::class, 'show'])->name('show');
        Route::get('/edit/{id}', [PengumumanController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [PengumumanController::class, 'update'])->name('update');
        Route::get('/create', [PengumumanController::class, 'create'])->name('create');
        Route::post('/store', [PengumumanController::class, 'store'])->name('store');
    });

    Route::prefix('profil')->name('profil.')->group(function () {
        Route::get('/', [ProfilController::class, 'index'])->name('index');
        Route::get('/show-profil', [ProfilController::class, 'showProfil'])->name('show.profil');
        Route::post('/store-profil', [ProfilController::class, 'storeProfil'])->name('store.profil');
        Route::post('/store-anggota', [ProfilController::class, 'storeAnggota'])->name('store.anggota');
        Route::get('/list-anggota', [ProfilController::class, 'listAnggota'])->name('list.anggota');
        Route::get('/show-anggota/{id}', [ProfilController::class, 'showAnggota'])->name('show.anggota');
        Route::put('/update-anggota/{id}', [ProfilController::class, 'updateAnggota'])->name('update.anggota');
    });
});

Route::middleware(['auth', 'user.role:dosen,admin,reviewer'])->prefix('proposal')->name('proposal.')->group(function () {

    Route::prefix('pengajuan')->name('pengajuan.')->group(function () {
        Route::get('/', [ProposalController::class, 'indexPengajuan'])->name('index');
        Route::get('/list', [ProposalController::class, 'listPengajuan'])->name('list');
        Route::get('/overview/{id}', [ProposalController::class, 'overview'])->name('overview');

        Route::prefix('penelitian')->name('penelitian.')->group(function () {
            Route::get('/{id}', [ProposalPenelitianController::class, 'show'])->name('show');
            Route::post('/store', [ProposalPenelitianController::class, 'store'])->name('store');
            Route::get('/surat-tugas/{id}', [ProposalPenelitianController::class, 'suratTugas'])->name('surat.tugas');
            Route::get('/surat-moa/{id}', [ProposalPenelitianController::class, 'suratMoa'])->name('surat.moa');
        });

        Route::prefix('pengabdian')->name('pengabdian.')->group(function () {
            Route::get('/{id}', [ProposalPengabdianController::class, 'show'])->name('show');
            Route::post('/store', [ProposalPengabdianController::class, 'store'])->name('store');
            Route::get('/surat-tugas/{id}', [ProposalPengabdianController::class, 'suratTugas'])->name('surat.tugas');
            Route::get('/surat-moa/{id}', [ProposalPengabdianController::class, 'suratMoa'])->name('surat.moa');
        });

        Route::prefix('luaran')->name('luaran.')->group(function () {
            Route::get('/wajib/{id}', [ProposalLuaranController::class, 'listLuaranWajib'])->name('wajib');
            Route::get('/tambahan/{id}', [ProposalLuaranController::class, 'listLuaranTambahan'])->name('tambahan');
            Route::post('/store', [ProposalLuaranController::class, 'store'])->name('store');
            Route::get('/{id}', [ProposalLuaranController::class, 'show'])->name('show');
            Route::put('/{id}/update', [ProposalLuaranController::class, 'update'])->name('update');
            Route::delete('/{id}/destroy', [ProposalLuaranController::class, 'destroy'])->name('destroy');
        });
    });

    Route::prefix('kemajuan')->name('kemajuan.')->group(function () {
        Route::get('/', [ProposalController::class, 'indexKemajuan'])->name('index');
        Route::get('/list', [ProposalController::class, 'listKemajuan'])->name('list');
        Route::get('/overview/{id}', [ProposalController::class, 'overviewKemajuan'])->name('overview');
        Route::get('/show-all/{id}', [KemajuanProposalController::class, 'showAll'])->name('show.all');
        Route::get('/show/{id}', [KemajuanProposalController::class, 'show'])->name('show');
        Route::post('/store', [KemajuanProposalController::class, 'store'])->name('store');
        Route::get('/deadline/{id}', [KemajuanProposalController::class, 'deadline'])->name('deadline');
        Route::get('/list-review/{id}', [KemajuanProposalController::class, 'listReview'])->name('list.review');
        Route::get('/list-history/{id}', [KemajuanProposalController::class, 'listHistory'])->name('list.history');
    });

    Route::prefix('akhir')->name('akhir.')->group(function () {
        Route::get('/', [ProposalController::class, 'indexAkhir'])->name('index');
        Route::get('/list', [ProposalController::class, 'listAkhir'])->name('list');
        Route::get('/overview/{id}', [ProposalController::class, 'overviewAkhir'])->name('overview');
        Route::get('/show-all/{id}', [AkhirProposalController::class, 'showAll'])->name('show.all');
        Route::get('/show/{id}', [AkhirProposalController::class, 'show'])->name('show');
        Route::post('/store', [AkhirProposalController::class, 'store'])->name('store');
        Route::get('/deadline/{id}', [AkhirProposalController::class, 'deadline'])->name('deadline');
        Route::get('/rekap/{id}', [AkhirProposalController::class, 'rekap'])->name('rekap');
        Route::get('/list-review/{id}', [AkhirProposalController::class, 'listReview'])->name('list.review');
        Route::get('/list-history/{id}', [AkhirProposalController::class, 'listHistory'])->name('list.history');
    });

    Route::prefix('luaran')->name('luaran.')->group(function () {
        Route::get('/', [ProposalController::class, 'indexLuaran'])->name('index');
        Route::get('/list', [ProposalController::class, 'listLuaran'])->name('list');
        Route::get('/overview/{id}', [ProposalController::class, 'overviewLuaran'])->name('overview');
        Route::get('/show-all/{id}', [LuaranProposalController::class, 'showAll'])->name('show.all');
        Route::get('/show/{id}', [LuaranProposalController::class, 'show'])->name('show');
        Route::post('/store', [LuaranProposalController::class, 'store'])->name('store');
        Route::get('/deadline/{id}', [LuaranProposalController::class, 'deadline'])->name('deadline');
        Route::get('/rekap/{id}', [LuaranProposalController::class, 'rekap'])->name('rekap');
    });

    Route::prefix('pelaksanaan')->name('pelaksanaan.')->group(function () {
        Route::get('/', [ProposalController::class, 'indexPelaksanaan'])->name('index');
        Route::get('/list', [ProposalController::class, 'listPelaksanaan'])->name('list');
        Route::get('/overview/{id}', [ProposalController::class, 'overviewPelaksanaan'])->name('overview');
        Route::get('/show-all/{id}', [PelaksanaanProposalController::class, 'showAll'])->name('show.all');
        Route::get('/show/{id}', [PelaksanaanProposalController::class, 'show'])->name('show');
        Route::post('/store', [PelaksanaanProposalController::class, 'store'])->name('store');
        Route::get('/deadline/{id}', [PelaksanaanProposalController::class, 'deadline'])->name('deadline');
        Route::get('/list-history/{id}', [PelaksanaanProposalController::class, 'listHistory'])->name('list.history');
    });
});

Route::middleware(['auth', 'user.role:dosen,admin,reviewer'])->prefix('surat')->name('surat.')->group(
    function () {

        Route::prefix('tugas')->name('tugas.')->group(function () {
            Route::get('download/{id}', [SuratTugasController::class, 'download'])->name('download');
            Route::post('store', [SuratTugasController::class, 'store'])->name('store');
            Route::post('upload', [SuratTugasController::class, 'upload'])->name('upload');
        });

        Route::prefix('moa')->name('moa.')->group(function () {
            Route::post('upload', [SuratMoaController::class, 'upload'])->name('upload');
        });
    }
);

Route::middleware(['auth', 'user.role:dosen,reviewer,admin'])->prefix('review')->name('review.')->group(function () {

    Route::prefix('proposal')->name('proposal.')->group(function () {
        Route::get('/', [ReviewProposalController::class, 'index'])->name('index');
        Route::get('/list', [ReviewProposalController::class, 'list'])->name('list');
        Route::get('/{id}/index-review', [ReviewProposalController::class, 'indexReview'])->name('index.review');
        Route::get('/{id}/list-review', [ReviewProposalController::class, 'listReview'])->name('list.review');
        Route::get('/{id}/overview', [ReviewProposalController::class, 'overview'])->name('overview');
        // Route::get('/{id}/show-review-penelitian', [ReviewProposalController::class, 'showReviewPenelitian'])->name('show.review.penelitian');
        // Route::get('/{id}/show-review-pengabdian', [ReviewProposalController::class, 'showReviewPengabdian'])->name('show.review.pengabdian');
        Route::get('/{id}/show-review-proposal', [ReviewProposalController::class, 'showReviewProposal'])->name('show.review.proposal');
        Route::post('/store-review-proposal', [ReviewProposalController::class, 'storeReviewProposal'])->name('store.review.proposal');
        Route::get('/{id}/show-review-luaran', [ReviewProposalController::class, 'showReviewLuaran'])->name('show.review.luaran');
        Route::post('/store-review-luaran', [ReviewProposalController::class, 'storeReviewLuaran'])->name('store.review.luaran');
        Route::get('/{id}/show-review-luaran-tambahan', [ReviewProposalController::class, 'showReviewLuaranTambahan'])->name('show.review.luaran.tambahan');
    });

    Route::prefix('kemajuan')->name('kemajuan.')->group(function () {
        Route::get('/', [ReviewKemajuanController::class, 'index'])->name('index');
        Route::get('/list-ta', [ReviewKemajuanController::class, 'listTa'])->name('list.ta');
        Route::get('/index-dosen/{id}', [ReviewKemajuanController::class, 'viewDosen'])->name('index.dosen');
        Route::get('/list-dosen/{id}', [ReviewKemajuanController::class, 'listDsn'])->name('list.dosen');
        Route::get('/overview/{id}', [ReviewKemajuanController::class, 'overview'])->name('overview');
        Route::post('/store', [ReviewKemajuanController::class, 'store'])->name('store');
        Route::get('/show/{id}', [ReviewKemajuanController::class, 'show'])->name('show');
    });

    Route::prefix('akhir')->name('akhir.')->group(function () {
        Route::get('/', [ReviewAkhirController::class, 'index'])->name('index');
        Route::get('/list-ta', [ReviewAkhirController::class, 'listTa'])->name('list.ta');
        Route::get('/index-dosen/{id}', [ReviewAkhirController::class, 'viewDosen'])->name('index.dosen');
        Route::get('/list-dosen/{id}', [ReviewAkhirController::class, 'listDsn'])->name('list.dosen');
        Route::get('/overview/{id}', [ReviewAkhirController::class, 'overview'])->name('overview');
        Route::post('/store', [ReviewAkhirController::class, 'store'])->name('store');
        Route::get('/show/{id}', [ReviewAkhirController::class, 'show'])->name('show');
    });

    Route::prefix('luaran')->name('luaran.')->group(function () {
        Route::get('/', [ReviewLuaranController::class, 'index'])->name('index');
        Route::get('/list-ta', [ReviewLuaranController::class, 'listTa'])->name('list.ta');
        Route::get('/index-dosen/{id}', [ReviewLuaranController::class, 'viewDosen'])->name('index.dosen');
        Route::get('/list-dosen/{id}', [ReviewLuaranController::class, 'listDsn'])->name('list.dosen');
        Route::get('/overview/{id}', [ReviewLuaranController::class, 'overview'])->name('overview');
        Route::post('/store', [ReviewLuaranController::class, 'store'])->name('store');
        Route::get('/show/{id}', [ReviewLuaranController::class, 'show'])->name('show');
    });
});

Route::middleware(['auth'])->prefix('laporan')->name('laporan.')->group(function () {

    Route::prefix('penelitian')->name('penelitian.')->group(function () {
        Route::get('/', [LaporanPenelitianController::class, 'index'])->name('index');
        Route::get('/list', [LaporanPenelitianController::class, 'list'])->name('list');
        Route::get('/create', [LaporanPenelitianController::class, 'create'])->name('create');
        Route::post('/store', [LaporanPenelitianController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [LaporanPenelitianController::class, 'edit'])->name('edit');
        Route::get('/show/{id}', [LaporanPenelitianController::class, 'show'])->name('show');
        Route::put('/update/{id}', [LaporanPenelitianController::class, 'update'])->name('update');

        Route::prefix('luaran')->name('luaran.')->group(function () {
            Route::prefix('jurnal')->name('jurnal.')->group(function () {
                Route::get('/', [LuaranPenelitianController::class, 'indexJurnal'])->name('index');
                Route::get('/list', [LuaranPenelitianController::class, 'listJurnal'])->name('list');
                Route::get('/create', [LuaranPenelitianController::class, 'createJurnal'])->name('create');
                Route::get('/edit/{id}', [LuaranPenelitianController::class, 'editJurnal'])->name('edit');
                Route::get('/show/{id}', [LuaranPenelitianController::class, 'showJurnal'])->name('show');
                Route::post('/store', [LuaranPenelitianController::class, 'storeJurnal'])->name('store');
                Route::put('/update/{id}', [LuaranPenelitianController::class, 'updateJurnal'])->name('update');
            });

            Route::prefix('haki')->name('haki.')->group(function () {
                Route::get('/', [LuaranPenelitianController::class, 'indexHaki'])->name('index');
                Route::get('/list', [LuaranPenelitianController::class, 'listHaki'])->name('list');
                Route::get('/create', [LuaranPenelitianController::class, 'createHaki'])->name('create');
                Route::get('/edit/{id}', [LuaranPenelitianController::class, 'editHaki'])->name('edit');
                Route::get('/show/{id}', [LuaranPenelitianController::class, 'showHaki'])->name('show');
                Route::post('/store', [LuaranPenelitianController::class, 'storeHaki'])->name('store');
                Route::put('/update/{id}', [LuaranPenelitianController::class, 'updateHaki'])->name('update');
            });

            Route::prefix('buku')->name('buku.')->group(function () {
                Route::get('/', [LuaranPenelitianController::class, 'indexBuku'])->name('index');
                Route::get('/list', [LuaranPenelitianController::class, 'listBuku'])->name('list');
                Route::get('/create', [LuaranPenelitianController::class, 'createBuku'])->name('create');
                Route::get('/edit/{id}', [LuaranPenelitianController::class, 'editBuku'])->name('edit');
                Route::get('/show/{id}', [LuaranPenelitianController::class, 'showBuku'])->name('show');
                Route::post('/store', [LuaranPenelitianController::class, 'storeBuku'])->name('store');
                Route::put('/update/{id}', [LuaranPenelitianController::class, 'updateBuku'])->name('update');
            });

            Route::prefix('prototype')->name('prototype.')->group(function () {
                Route::get('/', [LuaranPenelitianController::class, 'indexPrototype'])->name('index');
                Route::get('/list', [LuaranPenelitianController::class, 'listPrototype'])->name('list');
                Route::get('/create', [LuaranPenelitianController::class, 'createPrototype'])->name('create');
                Route::get('/edit/{id}', [LuaranPenelitianController::class, 'editPrototype'])->name('edit');
                Route::get('/show/{id}', [LuaranPenelitianController::class, 'showPrototype'])->name('show');
                Route::post('/store', [LuaranPenelitianController::class, 'storePrototype'])->name('store');
                Route::put('/update/{id}', [LuaranPenelitianController::class, 'updatePrototype'])->name('update');
            });

            Route::prefix('produk')->name('produk.')->group(function () {
                Route::get('/', [LuaranPenelitianController::class, 'indexProduk'])->name('index');
                Route::get('/list', [LuaranPenelitianController::class, 'listProduk'])->name('list');
                Route::get('/create', [LuaranPenelitianController::class, 'createProduk'])->name('create');
                Route::get('/edit/{id}', [LuaranPenelitianController::class, 'editProduk'])->name('edit');
                Route::get('/show/{id}', [LuaranPenelitianController::class, 'showProduk'])->name('show');
                Route::post('/store', [LuaranPenelitianController::class, 'storeProduk'])->name('store');
                Route::put('/update/{id}', [LuaranPenelitianController::class, 'updateProduk'])->name('update');
            });
        });
    });

    Route::prefix('pengabdian')->name('pengabdian.')->group(function () {
        Route::get('/', [LaporanPengabdianController::class, 'index'])->name('index');
        Route::get('/list', [LaporanPengabdianController::class, 'list'])->name('list');
        Route::get('/create', [LaporanPengabdianController::class, 'create'])->name('create');
        Route::post('/store', [LaporanPengabdianController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [LaporanPengabdianController::class, 'edit'])->name('edit');
        Route::get('/show/{id}', [LaporanPengabdianController::class, 'show'])->name('show');
        Route::put('/update/{id}', [LaporanPengabdianController::class, 'update'])->name('update');

        Route::prefix('luaran')->name('luaran.')->group(function () {
            Route::prefix('jurnal')->name('jurnal.')->group(function () {
                Route::get('/', [LuaranPengabdianController::class, 'indexJurnal'])->name('index');
                Route::get('/list', [LuaranPengabdianController::class, 'listJurnal'])->name('list');
                Route::get('/create', [LuaranPengabdianController::class, 'createJurnal'])->name('create');
                Route::get('/edit/{id}', [LuaranPengabdianController::class, 'editJurnal'])->name('edit');
                Route::get('/show/{id}', [LuaranPengabdianController::class, 'showJurnal'])->name('show');
                Route::post('/store', [LuaranPengabdianController::class, 'storeJurnal'])->name('store');
                Route::put('/update/{id}', [LuaranPengabdianController::class, 'updateJurnal'])->name('update');
            });

            Route::prefix('haki')->name('haki.')->group(function () {
                Route::get('/', [LuaranPengabdianController::class, 'indexHaki'])->name('index');
                Route::get('/list', [LuaranPengabdianController::class, 'listHaki'])->name('list');
                Route::get('/create', [LuaranPengabdianController::class, 'createHaki'])->name('create');
                Route::get('/edit/{id}', [LuaranPengabdianController::class, 'editHaki'])->name('edit');
                Route::get('/show/{id}', [LuaranPengabdianController::class, 'showHaki'])->name('show');
                Route::post('/store', [LuaranPengabdianController::class, 'storeHaki'])->name('store');
                Route::put('/update/{id}', [LuaranPengabdianController::class, 'updateHaki'])->name('update');
            });

            Route::prefix('buku')->name('buku.')->group(function () {
                Route::get('/', [LuaranPengabdianController::class, 'indexBuku'])->name('index');
                Route::get('/list', [LuaranPengabdianController::class, 'listBuku'])->name('list');
                Route::get('/create', [LuaranPengabdianController::class, 'createBuku'])->name('create');
                Route::get('/edit/{id}', [LuaranPengabdianController::class, 'editBuku'])->name('edit');
                Route::get('/show/{id}', [LuaranPengabdianController::class, 'showBuku'])->name('show');
                Route::post('/store', [LuaranPengabdianController::class, 'storeBuku'])->name('store');
                Route::put('/update/{id}', [LuaranPengabdianController::class, 'updateBuku'])->name('update');
            });

            Route::prefix('prototype')->name('prototype.')->group(function () {
                Route::get('/', [LuaranPengabdianController::class, 'indexPrototype'])->name('index');
                Route::get('/list', [LuaranPengabdianController::class, 'listPrototype'])->name('list');
                Route::get('/create', [LuaranPengabdianController::class, 'createPrototype'])->name('create');
                Route::get('/edit/{id}', [LuaranPengabdianController::class, 'editPrototype'])->name('edit');
                Route::get('/show/{id}', [LuaranPengabdianController::class, 'showPrototype'])->name('show');
                Route::post('/store', [LuaranPengabdianController::class, 'storePrototype'])->name('store');
                Route::put('/update/{id}', [LuaranPengabdianController::class, 'updatePrototype'])->name('update');
            });

            Route::prefix('produk')->name('produk.')->group(function () {
                Route::get('/', [LuaranPengabdianController::class, 'indexProduk'])->name('index');
                Route::get('/list', [LuaranPengabdianController::class, 'listProduk'])->name('list');
                Route::get('/create', [LuaranPengabdianController::class, 'createProduk'])->name('create');
                Route::get('/edit/{id}', [LuaranPengabdianController::class, 'editProduk'])->name('edit');
                Route::get('/show/{id}', [LuaranPengabdianController::class, 'showProduk'])->name('show');
                Route::post('/store', [LuaranPengabdianController::class, 'storeProduk'])->name('store');
                Route::put('/update/{id}', [LuaranPengabdianController::class, 'updateProduk'])->name('update');
            });
        });
    });

    Route::prefix('penulis')->name('penulis.')->group(function () {
        Route::delete('/dalam-destroy/{id}', [PenulisController::class, 'destroyDalam'])->name('dalam.destroy');
        Route::delete('/luar-destroy/{id}', [PenulisController::class, 'destroyLuar'])->name('luar.destroy');
        Route::delete('/lain-destroy/{id}', [PenulisController::class, 'destroyLain'])->name('lain.destroy');
    });
});

Route::middleware(['auth'])->prefix('roadmap')->name('roadmap.')->group(function () {

    Route::prefix('dosen')->name('dosen.')->group(function () {
        Route::get('/', [RoadmapDosenController::class, 'index'])->name('index');
        Route::get('/list', [RoadmapDosenController::class, 'list'])->name('list');
        Route::get('/show/{id}', [RoadmapDosenController::class, 'show'])->name('show');
        Route::post('/store', [RoadmapDosenController::class, 'store'])->name('store');
        Route::put('/update/{id}', [RoadmapDosenController::class, 'update'])->name('update');
        Route::put('/review/{id}', [RoadmapDosenController::class, 'review'])->name('review');
    });

    Route::prefix('prodi')->name('prodi.')->group(function () {
        Route::get('/', [RoadmapProdiController::class, 'index'])->name('index');
        Route::get('/list', [RoadmapProdiController::class, 'list'])->name('list');
        Route::get('/show/{id}', [RoadmapProdiController::class, 'show'])->name('show');
        Route::post('/store', [RoadmapProdiController::class, 'store'])->name('store');
        Route::put('/update/{id}', [RoadmapProdiController::class, 'update'])->name('update');
        Route::put('/review/{id}', [RoadmapProdiController::class, 'review'])->name('review');
    });
});

Route::middleware(['auth'])->prefix('akun')->name('akun.')->group(function () {

    Route::put('/update-password/{id}', [AkunController::class, 'password'])->name('update.password');

    Route::prefix('admin')->name('admin.')->middleware(['user.role:admin,developer'])->group(function () {
        Route::get('/', [AkunAdminController::class, 'index'])->name('index');
        Route::get('/show', [AkunAdminController::class, 'show'])->name('show');
        Route::put('/update', [AkunAdminController::class, 'update'])->name('update');
    });

    Route::prefix('reviewer')->name('reviewer.')->middleware(['user.role:reviewer'])->group(function () {
        Route::get('/', [AkunReviewerController::class, 'index'])->name('index');
        Route::get('/show', [AkunReviewerController::class, 'show'])->name('show');
        Route::put('/update', [AkunReviewerController::class, 'update'])->name('update');
    });

    Route::prefix('dosen')->name('dosen.')->middleware(['user.role:dosen'])->group(function () {
        Route::get('/', [AkunDosenController::class, 'index'])->name('index');
        Route::get('/show', [AkunDosenController::class, 'show'])->name('show');
        Route::put('/update', [AkunDosenController::class, 'update'])->name('update');
        Route::put('/update-bank/{id}', [AkunDosenController::class, 'updateBank'])->name('update.bank');
        Route::put('/update-research/{id}', [AkunDosenController::class, 'updateResearch'])->name('update.research');
        Route::put('/update-file/{id}', [AkunDosenController::class, 'updateFile'])->name('update.file');
    });
});

Route::middleware(['auth'])->prefix('report')->name('report.')->group(function () {

    Route::prefix('publikasi')->name('publikasi.')->group(function () {
        Route::get('/', [ReportArsipController::class, 'index'])->name('index');
        Route::get('/list', [ReportArsipController::class, 'list'])->name('list');
        Route::get('/show/{id}', [ReportArsipController::class, 'show'])->name('show');
        Route::get('/report', [ReportArsipController::class, 'getReportData'])->name('by.ta');

        Route::prefix('luaran')->name('luaran.')->group(function () {

            Route::prefix('jurnal')->name('jurnal.')->group(function () {
                Route::get('/', [ReportArsipJurnalController::class, 'index'])->name('index');
                Route::get('/list', [ReportArsipJurnalController::class, 'list'])->name('list');
                Route::get('/show/{id}', [ReportArsipJurnalController::class, 'show'])->name('show');
                Route::get('/report', [ReportArsipJurnalController::class, 'getReportData'])->name('by.ta');
            });

            Route::prefix('buku')->name('buku.')->group(function () {
                Route::get('/', [ReportArsipBukuController::class, 'index'])->name('index');
                Route::get('/list', [ReportArsipBukuController::class, 'list'])->name('list');
                Route::get('/show/{id}', [ReportArsipBukuController::class, 'show'])->name('show');
                Route::get('/report', [ReportArsipBukuController::class, 'getReportData'])->name('by.ta');
            });

            Route::prefix('haki')->name('haki.')->group(function () {
                Route::get('/', [ReportArsipHakiController::class, 'index'])->name('index');
                Route::get('/list', [ReportArsipHakiController::class, 'list'])->name('list');
                Route::get('/show/{id}', [ReportArsipHakiController::class, 'show'])->name('show');
                Route::get('/report', [ReportArsipHakiController::class, 'getReportData'])->name('by.ta');
            });

            Route::prefix('produk')->name('produk.')->group(function () {
                Route::get('/', [ReportArsipProdukController::class, 'index'])->name('index');
                Route::get('/list', [ReportArsipProdukController::class, 'list'])->name('list');
                Route::get('/show/{id}', [ReportArsipProdukController::class, 'show'])->name('show');
                Route::get('/report', [ReportArsipProdukController::class, 'getReportData'])->name('by.ta');
            });

            Route::prefix('prototype')->name('prototype.')->group(function () {
                Route::get('/', [ReportArsipPrototypeController::class, 'index'])->name('index');
                Route::get('/list', [ReportArsipPrototypeController::class, 'list'])->name('list');
                Route::get('/show/{id}', [ReportArsipPrototypeController::class, 'show'])->name('show');
                Route::get('/report', [ReportArsipPrototypeController::class, 'getReportData'])->name('by.ta');
            });
        });
    });

    Route::prefix('proposal')->name('proposal.')->group(function () {

        Route::prefix('pengajuan')->name('pengajuan.')->group(function () {
            Route::get('/', [ReportProposalController::class, 'index'])->name('index');
            Route::get('/list', [ReportProposalController::class, 'list'])->name('list');
            Route::get('/show/{id}', [ReportProposalController::class, 'show'])->name('show');
            Route::get('/kelengkapan/{id}', [ReportProposalController::class, 'kelengkapan'])->name('kelengkapan');
            Route::get('/report', [ReportProposalController::class, 'getReportData'])->name('by.ta');
        });

        Route::prefix('kemajuan')->name('kemajuan.')->group(function () {
            Route::get('/', [ReportKemajuanController::class, 'index'])->name('index');
            Route::get('/list', [ReportKemajuanController::class, 'list'])->name('list');
            Route::get('/show/{id}', [ReportKemajuanController::class, 'show'])->name('show');
        });

        Route::prefix('akhir')->name('akhir.')->group(function () {
            Route::get('/', [ReportAkhirController::class, 'index'])->name('index');
            Route::get('/list', [ReportAkhirController::class, 'list'])->name('list');
            Route::get('/show/{id}', [ReportAkhirController::class, 'show'])->name('show');
        });

        Route::prefix('luaran')->name('luaran.')->group(function () {
            Route::get('/', [ReportLuaranController::class, 'index'])->name('index');
            Route::get('/list', [ReportLuaranController::class, 'list'])->name('list');
            Route::get('/show/{id}', [ReportLuaranController::class, 'show'])->name('show');
        });

        Route::prefix('pelaksanaan')->name('pelaksanaan.')->group(function () {
            Route::get('/', [ReportPelaksanaanController::class, 'index'])->name('index');
            Route::get('/list', [ReportPelaksanaanController::class, 'list'])->name('list');
            Route::get('/show/{id}', [ReportPelaksanaanController::class, 'show'])->name('show');
        });
    });
});

Route::prefix('dosen-luar')->name('dosen.luar.')->group(function () {
    Route::get('/list-public', [DosenLuarController::class, 'listPublic'])->name('list.public');
    Route::post('/store', [DosenLuarController::class, 'store'])->name('store');
});

Route::prefix('dosen-lain')->name('dosen.lain.')->group(function () {
    Route::get('/list-public', [DosenLainController::class, 'listPublic'])->name('list.public');
    Route::post('/store', [DosenLainController::class, 'store'])->name('store');
});

Route::prefix('global')->name('global.')->group(function () {
    Route::get('tahun-akademik/list-json', [TahunAkademikController::class, 'listJson'])->name('tahun.akademik.list.json');
    Route::get('fakultas/list-json', [FakultasController::class, 'listJson'])->name('fakultas.list.json');
    Route::get('prodi/by-fakultas/{id}', [ProdiController::class, 'byFakultas'])->name('prodi.by.fakultas');
    Route::get('dosen-has-proposal-pene', [DosenController::class, 'listPublicHasProposalPene'])->name('dosen.has.proposal.pene');
    Route::get('dosen-has-proposal-peng', [DosenController::class, 'listPublicHasProposalPeng'])->name('dosen.has.proposal.peng');
    Route::get('arsip-pene/list-json', [LaporanPenelitianController::class, 'listArsipPene'])->name('arsip.pene.list.json');
    Route::get('arsip-peng/list-json', [LaporanPengabdianController::class, 'listArsipPeng'])->name('arsip.peng.list.json');
    Route::get('penulis/by-arsip/{id}', [PenulisController::class, 'penulisByArsip'])->name('penulis.by.arsip');
});

Route::get('dosen/list-public', [DosenController::class, 'listPublic'])->name('dosen.list.public')->middleware('auth');
Route::get('bidangIlmu/list/json', [BidangIlmuController::class, 'listJson'])->name('bidang.ilmu.list.json')->middleware('auth');
Route::get('kepakaran/list/json/{id}', [KepakaranController::class, 'listJson'])->name('kepakaran.list.json')->middleware('auth');
