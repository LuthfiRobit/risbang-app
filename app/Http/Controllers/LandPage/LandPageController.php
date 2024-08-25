<?php

namespace App\Http\Controllers\LandPage;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\Berita;
use App\Models\Dosen;
use App\Models\Fakultas;
use App\Models\Pengumuman;
use App\Models\Profil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LandPageController extends Controller
{
    public function chartPieDosen(Request $request)
    {
        $dosenPerFakultas = DB::table('dosen')
            ->join('prodi', 'dosen.prodi_id', '=', 'prodi.id_prodi')
            ->join('fakultas', 'prodi.fakultas_id', '=', 'fakultas.id_fakultas')
            ->select(
                'fakultas.singkatan as nama_fakultas',
                DB::raw('COUNT(dosen.id_dosen) as jumlah_dosen')
            )
            ->groupBy('fakultas.singkatan')
            ->get();

        $totalDosen = DB::table('dosen')->count();

        $dosenPerFakultas->transform(function ($item) use ($totalDosen) {
            $item->presentase = ($item->jumlah_dosen / $totalDosen) * 100;
            return $item;
        });

        return response()->json($dosenPerFakultas);
    }

    public function chartBarDosen(Request $request)
    {
        $results = DB::table('dosen')
            ->join('prodi', 'dosen.prodi_id', '=', 'prodi.id_prodi')
            ->join('fakultas', 'prodi.fakultas_id', '=', 'fakultas.id_fakultas')
            ->select('fakultas.singkatan as nama_fakultas', 'dosen.jabatan', DB::raw('COUNT(dosen.id_dosen) as jumlah'))
            ->groupBy('fakultas.singkatan', 'dosen.jabatan')
            ->get();

        $data = [];
        foreach ($results as $result) {
            $data[$result->nama_fakultas][$result->jabatan] = $result->jumlah;
        }

        // Format JSON yang sesuai untuk ApexCharts
        $response = [];
        foreach ($data as $fakultas => $jabatanData) {
            $response[] = [
                'fakultas' => $fakultas,
                'lecture' => $jabatanData['lecture'] ?? 0,
                'asisten ahli' => $jabatanData['asisten ahli'] ?? 0,
                'lektor' => $jabatanData['lektor'] ?? 0,
                'lektor kepala' => $jabatanData['lektor kepala'] ?? 0,
                'guru besar' => $jabatanData['guru besar'] ?? 0,
            ];
        }

        return response()->json($response);
    }

    /** Begin:Dosen Section */

    public function indexDosen()
    {
        $fakultas = Fakultas::select('id_fakultas', 'nama_fakultas')->where('aktif', 'y')->get();
        return view('landpage.dosen.index', compact('fakultas'));
    }

    public function listDosen(Request $request)
    {
        $query = Dosen::select(
            'dosen.id_dosen',
            'users.id_user',
            'users.username',
            'users.profile_pict',
            'fakultas.singkatan as fakultas',
            'prodi.singkatan as prodi',
            'dosen.email',
            'dosen.nama_dosen',
            'dosen.nidn',
            'dosen.jabatan',
            'dosen.link_google_scholar',
            'dosen.link_sinta',
            'dosen.link_scopus',
        )
            ->leftJoin('users', 'users.id_user', '=', 'dosen.user_id')
            ->leftJoin('prodi', 'prodi.id_prodi', '=', 'dosen.prodi_id')
            ->leftJoin('fakultas', 'fakultas.id_fakultas', '=', 'prodi.fakultas_id')
            ->orderBy('dosen.created_at', 'DESC');

        if ($request->jafung) {
            $query->where('dosen.jabatan', $request->jafung);
        }

        if ($request->filter_fakultas) {
            $query->where('fakultas.id_fakultas', $request->filter_fakultas);
        }

        if ($request->filter_prodi) {
            $query->where('dosen.prodi_id', $request->filter_prodi);
        }

        // Tentukan jumlah item per halaman
        $itemsPerPage = 8;

        // Dapatkan halaman saat ini dari request
        $page = $request->input('page', 1);

        // Paginasi query
        $result = $query->paginate($itemsPerPage, ['*'], 'page', $page);

        return response()->json([
            'success' => $result->total() > 0 ? true : false,
            'message' => $result->total() > 0 ? 'data tersedia' : 'data tidak ditemukan',
            'data' => $result
        ], 200);
    }
    /** End:Dosen Section */

    /** Begin:Profil Section */
    public function showProfil()
    {
        $query = Profil::first();

        if ($query) {
            // Convert the query result to an array
            $data = $query->toArray();

            // List of keys to remove from the array
            $keysToRemove = ['id_profil', 'instagram', 'twitter', 'facebook', 'linkedin', 'web1', 'web2', 'web3', 'logo1', 'logo2', 'logo3'];

            // Remove the specified keys from the array
            foreach ($keysToRemove as $key) {
                unset($data[$key]);
            }

            return response()->json([
                'success' => true,
                'message' => 'data tersedia',
                'data' => $data
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'data tidak ditemukan',
                'data' => null
            ], 400);
        }
    }

    public function listAnggota()
    {
        $query = Anggota::select('nama', 'jabatan', 'img_anggota')
            ->orderBy('urutan', 'ASC');
        if ($query) {
            $result = $query->get()
                ->map(function ($q) {
                    return [
                        'profil' => asset('imgs/anggota') . '/' . $q->img_anggota,
                        'nama' => $q->nama,
                        'jabatan' => $q->jabatan
                    ];
                });
            return response()->json([
                'success' => true,
                'message' => 'data tersedia',
                'data' => $result
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'data tidak ditemukan',
                'data' => $query
            ], 400);
        }
    }
    /** End:Profil Section */

    /** Begin:Berita Section */
    public function indexBerita()
    {
        return view('landpage.berita.index');
    }

    public function detailBerita($slug)
    {
        return view('landpage.berita.detail');
    }

    public function showBerita($slug)
    {
        // Mengambil data berita berdasarkan slug
        $berita = Berita::where('slug', $slug)
            ->where('publish', 'y') // Pastikan berita sudah dipublikasikan
            ->first();

        // Jika berita ditemukan
        if ($berita) {
            return response()->json([
                'success' => true,
                'message' => 'Data ditemukan',
                'data' => [
                    'judul' => $berita->judul,
                    'created_at' => $berita->created_at->format('d F Y H:i'),
                    'slug' => $berita->slug,
                    'img_berita' => $berita->img_berita,
                    'deskripsi' => $berita->deskripsi
                ]
            ], 200);
        }

        // Jika berita tidak ditemukan
        return response()->json([
            'success' => false,
            'message' => 'Data tidak ditemukan',
        ], 404);
    }

    public function listBerita(Request $request)
    {
        $query = Berita::select('judul', 'slug', 'deskripsi', 'img_berita', 'created_at')
            ->where('publish', 'y')
            ->orderBy('created_at', 'DESC');

        // Jika filter terisi
        if ($request->filter_judul) {
            $query->where('judul', 'LIKE', '%' . $request->filter_judul . '%');
        }

        // Tentukan jumlah item per halaman
        $itemsPerPage = 6;

        // Dapatkan halaman saat ini dari request
        $page = $request->input('page', 1);

        // Paginasi query
        $result = $query->paginate($itemsPerPage, ['*'], 'page', $page);

        // Format data
        $formattedData = $result->getCollection()->map(function ($item) {
            return [
                'judul' => $this->limitWords($item->judul, 5), // Batasi judul dengan 5 kata
                'deskripsi' => $this->limitWords($item->deskripsi, 10), // Batasi deskripsi dengan 10 kata
                'created_at' => $item->created_at->format('d F Y H:i'), // Format tanggal
                'slug' => $item->slug,
                'img_berita' => $item->img_berita
            ];
        });

        // Replace the collection in the paginated result
        $result->setCollection($formattedData);

        return response()->json([
            'success' => $result->total() > 0 ? true : false,
            'message' => $result->total() > 0 ? 'data tersedia' : 'data tidak ditemukan',
            'data' => $result
        ], 200);
    }

    public function listBeritaTerbaru()
    {
        // Ambil 4 data terbaru
        $beritaTerbaru = Berita::select('judul', 'slug', 'deskripsi', 'img_berita', 'created_at')
            ->where('publish', 'y') // Pastikan berita sudah dipublikasikan
            ->orderBy('created_at', 'DESC') // Urutkan berdasarkan tanggal terbaru
            ->take(4) // Ambil hanya 4 data
            ->get();

        // Ambil berita utama (berita pertama)
        $beritaUtama = $beritaTerbaru->first();

        if ($beritaUtama) {
            // Format data untuk berita utama
            $beritaUtamaFormatted = [
                'judul' => $beritaUtama->judul, // Batasi judul dengan 5 kata
                'created_at' => $beritaUtama->created_at->format('d F Y H:i'), // Format tanggal
                'slug' => $beritaUtama->slug,
                'img_berita' => $beritaUtama->img_berita,
                'deskripsi' => $this->limitWords($beritaUtama->deskripsi, 100) // Batasi deskripsi dengan 100 kata
            ];

            // Format data untuk berita lainnya (jika ada)
            $beritaLainnyaFormatted = $beritaTerbaru->skip(1)->map(function ($item) {
                return [
                    'judul' => $this->limitWords($item->judul, 5), // Batasi judul dengan 5 kata
                    'created_at' => $item->created_at->format('d F Y H:i'), // Format tanggal
                    'slug' => $item->slug,
                    'img_berita' => $item->img_berita
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'data tersedia',
                'data' => [
                    'utama' => $beritaUtamaFormatted,
                    'lainnya' => $beritaLainnyaFormatted
                ]
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'data tidak ditemukan',
            'data' => []
        ], 404);
    }

    public function listBeritaUtama()
    {
        // Ambil 4 data terbaru
        $beritaTerbaru = Berita::select('judul', 'slug', 'deskripsi', 'img_berita', 'created_at')
            ->where('publish', 'y') // Pastikan berita sudah dipublikasikan
            ->orderBy('created_at', 'DESC') // Urutkan berdasarkan tanggal terbaru
            ->take(3) // Ambil hanya 4 data
            ->get();

        if ($beritaTerbaru->count() > 0) {
            $formattedData = $beritaTerbaru->map(function ($item) {
                return [
                    'judul' => $item->judul, // Batasi judul dengan 5 kata
                    'deskripsi' => $this->limitWords($item->deskripsi, 30), // Batasi deskripsi dengan 10 kata
                    'created_at' => $item->created_at->format('d F Y H:i'), // Format tanggal
                    'slug' => $item->slug,
                    'img_berita' => asset('imgs/berita') . '/' . $item->img_berita
                ];
            });
            return response()->json(['success' => true, 'message' => 'data tersedia', 'data' => $formattedData], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'data tidak ditemukan', 'data' => $beritaTerbaru], 400);
        }
    }
    /** End:Berita Section */

    /** Begin:Pengumuman Section */
    public function indexPengumuman()
    {
        return view('landpage.pengumuman.index');
    }

    public function listPengumuman(Request $request)
    {
        $query = Pengumuman::select('jenis', 'judul', 'url', 'deskripsi', 'file_pengumuman', 'created_at')
            ->where('publish', 'y')
            ->orderBy('created_at', 'DESC');

        if ($request->filter_jenis) {
            $query->where('jenis', $request->filter_jenis);
        }

        // Tentukan jumlah item per halaman
        $itemsPerPage = 5;

        // Dapatkan halaman saat ini dari request
        $page = $request->input('page', 1);

        // Paginasi query
        $result = $query->paginate($itemsPerPage, ['*'], 'page', $page);

        return response()->json([
            'success' => $result->total() > 0 ? true : false,
            'message' => $result->total() > 0 ? 'data tersedia' : 'data tidak ditemukan',
            'data' => $result
        ], 200);
    }

    public function listPengumumanUtama()
    {
        // Ambil 2 data untuk jenis Pengumuman
        $pengumumanData = Pengumuman::select('jenis', 'judul', 'url', 'deskripsi', 'file_pengumuman', 'created_at')
            ->where('publish', 'y')
            ->where('jenis', 'Pengumuman')
            ->orderBy('created_at', 'DESC')
            ->limit(2)
            ->get();

        // Ambil 2 data untuk jenis Pedoman
        $pedomanData = Pengumuman::select('jenis', 'judul', 'url', 'deskripsi', 'file_pengumuman', 'created_at')
            ->where('publish', 'y')
            ->where('jenis', 'Pedoman')
            ->orderBy('created_at', 'DESC')
            ->limit(2)
            ->get();

        // Format data untuk respons JSON
        return response()->json([
            'success' => $pengumumanData->isNotEmpty() || $pedomanData->isNotEmpty(),
            'message' => ($pengumumanData->isNotEmpty() || $pedomanData->isNotEmpty()) ? 'data tersedia' : 'data tidak ditemukan',
            'pengumuman' => $pengumumanData,
            'pedoman' => $pedomanData,
        ], 200);
    }
    /** End:Pengumuman Section */

    /**
     * Batasi jumlah kata dalam string
     *
     * @param string $text
     * @param int $wordLimit
     * @return string
     */
    private function limitWords($text, $wordLimit)
    {
        $words = explode(' ', $text);
        if (count($words) > $wordLimit) {
            $words = array_slice($words, 0, $wordLimit);
            $text = implode(' ', $words) . '...'; // Tambahkan '...' jika melebihi batas
        }
        return $text;
    }
}
