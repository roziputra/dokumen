<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Penilaian extends Model
{
    use HasFactory;

    const STATUS_KELENGKAPAN_ADA = 'Ada';
    const STATUS_KELENGKAPAN_TIDAK_ADA = 'Tidak Ada';

    const STATUS_TINGKAT_KELENGKAPAN_LENGKAP = 'Lengkap';
    const STATUS_TINGKAT_KELENGKAPAN_KURANG_LENGKAP = 'Kurang Lengkap';
    const STATUS_TINGKAT_KELENGKAPAN_TIDAK_LENGKAP = 'Tidak Lengkap';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'satker_penilaian_id',
        'grup_penilaian',
        'sub_grup_penilaian',
        'item_penilaian_id',
        'item_penilaian_judul',
        'kelengkapan',
        'tingkat_kelengkapan',
        'keterangan',
    ];

    public static function getGrupPenilaian(): array
    {
        return [
            '',
            'Manajemen Perubahan',
            'Penataan Tatalaksana',
            'Penataan Sistem Manajemen SDM',
            'Penguatan Akuntabilitas',
            'Penguatan Pengawasan',
            'Peningkatan Kualitas Pelayanan Publik (10)',
            '',
        ];
    }

    public static function getSubGrupPenilaian(): array
    {
        return [
            '',
            'Tim Kerja',
            'Rencana Pembangunan Zona Integritas',
            'Pemantauan dan Evaluasi Pembangunan WBK/WBBM',
            'Perubahan pola pikir dan budaya kerja',
            'prosedur operasional tetap (SOP) kegiatan utama',
            'E-Office',
            'Keterbukaan Informasi Publik',
            'Perencanaan kebutuhan pegawai sesuai dengan kebutuhan organisasi',
            'Pola Mutasi Internal',
            'Pengembangan pegawai berbasis kompetensi',
            'Penetapan kinerja individu',
            'Penegakan aturan disiplin/kode etik/kode perilaku pegawai',
            'Sistem Informasi Kepegawaian',
            'Keterlibatan pimpinan',
	        'Pengelolaan Akuntabilitas Kinerja',
            'Pengendalian Gratifikasi',
            'Penerapan SPIP',
            'Pengaduan Masyarakat',
            'Whistle-Blowing System',
            'Penanganan Benturan Kepentingan',
            'Standar Pelayanan',
            'Budaya Pelayanan Prima',
            'Penilaian kepuasan terhadap pelayanan',
            'PEMERINTAH YANG BERSIH DAN BEBAS KKN',
            'KUALITAS PELAYANAN PUBLIK',
        ];
    }

    public static function getItemPenilaian(): array
    {
        return [
            [
                'grup'=> 0,
                'subgrup'=> 0,
                'judul' => '',
            ],
            [
                'grup'=> 1,
                'subgrup'=> 1,
                'judul' => 'SK Tim ZI',
            ],
            [
                'grup'=> 1,
                'subgrup'=> 1,
                'judul' => 'makanisme penentuan anggota Tim',
            ],
            [
                'grup'=> 1,
                'subgrup'=> 2,
                'judul' => 'dokumen rencana pembangunan ZI',
            ],
            [
                'grup'=> 1,
                'subgrup'=> 2,
                'judul' => 'media sosialisasi pembangunan ZI',
            ],
            [
                'grup'=> 1,
                'subgrup'=> 2,
                'judul' => 'laporan sosialisasi pembangunan ZI',
            ],
            [
                'grup'=> 1,
                'subgrup'=> 3,
                'judul' => 'laporan pelaksanaan pembangunan ZI',
            ],
            [
                'grup'=> 1,
                'subgrup'=> 3,
                'judul' => 'laporan monev pembangunan ZI',
            ],
            [
                'grup'=> 1,
                'subgrup'=> 3,
                'judul' => 'laporan hasil tindak lanjut monev pembangunan ZI',
            ],
            [
                'grup'=> 1,
                'subgrup'=> 4,
                'judul' => 'bukti pimpinan datang tepat waktu',
            ],
            [
                'grup'=> 1,
                'subgrup'=> 4,
                'judul' => 'SK pembentukan agen perubahan',
            ],
            [
                'grup'=> 1,
                'subgrup'=> 4,
                'judul' => 'agenda pembangunan budaya kerja dan pola pikir',
            ],
            [
                'grup'=> 1,
                'subgrup'=> 4,
                'judul' => 'notulen rapat pembangunan ZI',
            ],
            [
                'grup'=> 2,
                'subgrup'=> 5,
                'judul' => 'peta proses bisnis utama',
            ],
            [
                'grup'=> 2,
                'subgrup'=> 5,
                'judul' => 'daftar SOP',
            ],
            [
                'grup'=> 2,
                'subgrup'=> 5,
                'judul' => 'laporan evaluasi pelaksanaan SOP',
            ],
            [
                'grup'=> 2,
                'subgrup'=> 6,
                'judul' => 'laporan monitoring dan evaluasi terhadap pemanfaatan teknologi informasi dalam pengukuran kinerja unit, operasionalisasi SDM, dan pemberian layanan kepada publik',
            ],
            [
                'grup'=> 2,
                'subgrup'=> 7,
                'judul' => 'kebijakan keterbukaan informasi',
            ],
            [
                'grup'=> 2,
                'subgrup'=> 7,
                'judul' => 'laporan evaluasi pelaksanaan kebijakan keterbukaan informasi publik',
            ],
            [
                'grup'=> 3,
                'subgrup'=> 8,
                'judul' => 'dokumen rencana kebutuhan pegawai',
            ],
            [
                'grup'=> 3,
                'subgrup'=> 8,
                'judul' => 'laporan monev penempatan pegawai',
            ],
            [
                'grup'=> 3,
                'subgrup'=> 9,
                'judul' => 'dokumen pola rotasi',
            ],
            [
                'grup'=> 3,
                'subgrup'=> 9,
                'judul' => 'SK rotasi terakhir',
            ],
            [
                'grup'=> 3,
                'subgrup'=> 9,
                'judul' => 'laporan evaluasi kegiatan mutasi',
            ],
            [
                'grup'=> 3,
                'subgrup'=> 10,
                'judul' => 'kebijakan pengembangan kompetensi',
            ],
            [
                'grup'=> 3,
                'subgrup'=> 10,
                'judul' => 'notulen pelatihan',
            ],
            [
                'grup'=> 3,
                'subgrup'=> 11,
                'judul' => 'SKP',
            ],
            [
                'grup'=> 3,
                'subgrup'=> 11,
                'judul' => 'sasaran organisasi',
            ],
            [
                'grup'=> 3,
                'subgrup'=> 12,
                'judul' => 'laporan pelaksanaan penegakan disiplin/kode etik/kode perilaku',
            ],
            [
                'grup'=> 3,
                'subgrup'=> 13,
                'judul' => 'jadwal pemutahiran data informasi kepegawaian',
            ],
            [
                'grup'=> 4,
                'subgrup'=> 14,
                'judul' => 'notulen penyusunan perencanaan',
            ],
            [
                'grup'=> 4,
                'subgrup'=> 14,
                'judul' => 'notulen penyusunan penetapan kinerja',
            ],
            [
                'grup'=> 4,
                'subgrup'=> 14,
                'judul' => 'jadwal pemantauan dan laporan pemantauan',
            ],
            [
                'grup'=> 4,
                'subgrup'=> 15,
                'judul' => 'dokumen perencanaan',
            ],
            [
                'grup'=> 4,
                'subgrup'=> 15,
                'judul' => 'IKU',
            ],
            [
                'grup'=> 4,
                'subgrup'=> 15,
                'judul' => 'laporan kinerja',
            ],
            [
                'grup'=> 4,
                'subgrup'=> 15,
                'judul' => 'upaya peningkatan kapasitas SDM perencanaan',
            ],
            [
                'grup'=> 5,
                'subgrup'=> 16,
                'judul' => 'metode sosialisasi pengendalian gratifikasi',
            ],
            [
                'grup'=> 5,
                'subgrup'=> 16,
                'judul' => 'media informasi pengendalian gratifikasi',
            ],
            [
                'grup'=> 5,
                'subgrup'=> 16,
                'judul' => 'laporan tahunan penanganan gratifikasi',
            ],
            [
                'grup'=> 5,
                'subgrup'=> 17,
                'judul' => 'upaya pengendalian',
            ],
            [
                'grup'=> 5,
                'subgrup'=> 17,
                'judul' => 'peta risiko',
            ],
            [
                'grup'=> 5,
                'subgrup'=> 17,
                'judul' => 'kegiatan meminimalisir risiko',
            ],
            [
                'grup'=> 5,
                'subgrup'=> 17,
                'judul' => 'media informasi SPI',
            ],
            [
                'grup'=> 5,
                'subgrup'=> 18,
                'judul' => 'kebijakan pengaduan masyarakat',
            ],
            [
                'grup'=> 5,
                'subgrup'=> 18,
                'judul' => 'unit pengelola pengaduan masyarakat',
            ],
            [
                'grup'=> 5,
                'subgrup'=> 18,
                'judul' => 'laporan monev pengaduan masyarakat',
            ],
            [
                'grup'=> 5,
                'subgrup'=> 18,
                'judul' => 'laporan tindak lanjut pengaduan masyarakat',
            ],
            [
                'grup'=> 5,
                'subgrup'=> 19,
                'judul' => 'metode internalisasi WBS',
            ],
            [
                'grup'=> 5,
                'subgrup'=> 19,
                'judul' => 'media informasi internalisasi WBS',
            ],
            [
                'grup'=> 5,
                'subgrup'=> 19,
                'judul' => 'kebijakan WBS',
            ],
            [
                'grup'=> 5,
                'subgrup'=> 19,
                'judul' => 'unit pengelola WBS',
            ],
            [
                'grup'=> 5,
                'subgrup'=> 19,
                'judul' => 'laporan monev WBS',
            ],
            [
                'grup'=> 5,
                'subgrup'=> 19,
                'judul' => 'laporan tindak lanjut WBS',
            ],
            [
                'grup'=> 5,
                'subgrup'=> 20,
                'judul' => 'kebijakan benturan kepentingan',
            ],
            [
                'grup'=> 5,
                'subgrup'=> 20,
                'judul' => 'media informasi penanganan benturan kepentingan',
            ],
            [
                'grup'=> 5,
                'subgrup'=> 20,
                'judul' => 'notulen sosialisasi penanganan benturan kepentingan',
            ],
            [
                'grup'=> 5,
                'subgrup'=> 20,
                'judul' => 'prosedur pelaporan benturan kepentungan',
            ],
            [
                'grup'=> 5,
                'subgrup'=> 20,
                'judul' => 'laporan monev benturan kepentingan',
            ],
            [
                'grup'=> 5,
                'subgrup'=> 20,
                'judul' => 'laporan tindak lanjut benturan kepentingan',
            ],
            [
                'grup'=> 6,
                'subgrup'=> 21,
                'judul' => 'standar pelayanan',
            ],
            [
                'grup'=> 6,
                'subgrup'=> 21,
                'judul' => 'media pengumuman standar pelayanan',
            ],
            [
                'grup'=> 6,
                'subgrup'=> 21,
                'judul' => 'SOP pelayanan',
            ],
            [
                'grup'=> 6,
                'subgrup'=> 21,
                'judul' => 'laporan review SOP',
            ],
            [
                'grup'=> 6,
                'subgrup'=> 22,
                'judul' => 'notulen sosialisasi/pelatihan budaya pelayana prima',
            ],
            [
                'grup'=> 6,
                'subgrup'=> 22,
                'judul' => 'media informasi layanan',
            ],
            [
                'grup'=> 6,
                'subgrup'=> 22,
                'judul' => 'sistem reward and punishment',
            ],
            [
                'grup'=> 6,
                'subgrup'=> 22,
                'judul' => 'inovasi pelayanan',
            ],
            [
                'grup'=> 6,
                'subgrup'=> 23,
                'judul' => 'hasil survey kepuasan masyarakat',
            ],
            [
                'grup'=> 6,
                'subgrup'=> 23,
                'judul' => 'tindak lanjut dari hasil survey kepuasan masyarakat',
            ],
            [
                'grup'=> 7,
                'subgrup'=> 24,
                'judul' => 'Hasil survei persepsi korupsi',
            ],
            [
                'grup'=> 7,
                'subgrup'=> 25,
                'judul' => 'Hasil survei persepsi kualitas pelayanan',
            ],
        ];
    }

    public static function getAllKelengkapan(): array
    {
        return [
            self::STATUS_KELENGKAPAN_ADA,
            self::STATUS_KELENGKAPAN_TIDAK_ADA,
        ];
    }

    public static function getAllTingkatKelengkapan(): array
    {
        return [
            self::STATUS_TINGKAT_KELENGKAPAN_LENGKAP,
            self::STATUS_TINGKAT_KELENGKAPAN_KURANG_LENGKAP,
            self::STATUS_TINGKAT_KELENGKAPAN_TIDAK_LENGKAP,
        ];
    }

    public static function getItemPenilaianSatker(int $penilaian)
    {
        return self::orderBy('grup_penilaian', 'asc')
            ->orderBy('sub_grup_penilaian', 'asc')
            ->orderBy('id', 'asc')
            ->select('penilaians.*')
            ->where('penilaians.satker_penilaian_id', $penilaian)
            ->get();
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('privilege', function (Builder $builder) {
            $currentUser = Auth::user();
            if ($currentUser && $currentUser->type !== User::TYPE_ADMIN) {
                /*$builder->rightJoin('users.type', $currentUser->type)
                        ->where('users.company_id', $currentUser->company_id);*/
            }
        });
    }
}
