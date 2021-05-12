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

    const STATUS_KELENGKAPAN_ADA = 'ada';
    const STATUS_KELENGKAPAN_TIDAK_ADA = 'tidak-ada';

    const STATUS_TINGKAT_KELENGKAPAN_LENGKAP = 'lengkap';
    const STATUS_TINGKAT_KELENGKAPAN_KURANG_LENGKAP = 'kurang-lengkap';
    const STATUS_TINGKAT_KELENGKAPAN_TIDAK_LENGKAP = 'tidak-lengkap';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'satker_penilaian_id',
        'grup_penilaian',
        'sub_grup_penilaian',
        'judul_penilaian',
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
            'Hasil Survey',
        ];
    }

    public static function getSubGrupPenilaian(): array
    {
        return [
            [
                'grup' => 0,
                'judul' => '',
            ],
            [
                'grup' => 1,
                'judul' => 'Tim Kerja',
            ],
            [
                'grup' => 1,
                'judul' => 'Rencana Pembangunan Zona Integritas',
            ],
            [
                'grup' => 1,
                'judul' => 'Pemantauan dan Evaluasi Pembangunan WBK/WBBM',
            ],
            [
                'grup' => 1,
                'judul' => 'Perubahan pola pikir dan budaya kerja',
            ],
            [
                'grup' => 2,
                'judul' => 'Prosedur operasional tetap (SOP) kegiatan utama',
            ],
            [
                'grup' => 2,
                'judul' => 'E-Office',
            ],
            [
                'grup' => 2,
                'judul' => 'Keterbukaan Informasi Publik',
            ],
            [
                'grup' => 3,
                'judul' => 'Perencanaan kebutuhan pegawai sesuai dengan kebutuhan organisasi',
            ],
            [
                'grup' => 3,
                'judul' => 'Pola Mutasi Internal',
            ],
            [
                'grup' => 3,
                'judul' => 'Pengembangan pegawai berbasis kompetensi',
            ],
            [
                'grup' => 3,
                'judul' => 'Penetapan kinerja individu',
            ],
            [
                'grup' => 3,
                'judul' => 'Penegakan aturan disiplin/kode etik/kode prilaku pegawai',
            ],
            [
                'grup' => 3,
                'judul' => 'Sistem Informasi Kepegawaian',
            ],
            [
                'grup' => 4,
                'judul' => 'Keterlibatan pimpinan',
            ],
            [
                'grup' => 4,
                'judul' => 'Pengelolaan Akuntabilitas Kinerja',
            ],
            [
                'grup' => 5,
                'judul' => 'Pengendalian Gratifikasi',
            ],
            [
                'grup' => 5,
                'judul' => 'Penerapan SPIP',
            ],
            [
                'grup' => 5,
                'judul' => 'Pengaduan Masyarakat',
            ],
            [
                'grup' => 5,
                'judul' => 'Whistle Blowing System',
            ],
            [
                'grup' => 5,
                'judul' => 'Penanganan Benturan Kepentingan',
            ],
            [
                'grup' => 6,
                'judul' => 'Standar Pelayanan',
            ],
            [
                'grup' => 6,
                'judul' => 'Budaya Pelayanan Prima',
            ],
            [
                'grup' => 6,
                'judul' => 'Penilaian kepuasan terhadap pelayanan',
            ],
            [
                'grup' => 7,
                'judul' => 'PEMERINTAH YANG BERSIH DAN BEBAS KKN',
            ],
            [
                'grup' => 7,
                'judul' => 'KUALITAS PELAYANAN PUBLIK',
            ],
        ];
    }

    public static function getAllKelengkapan(): array
    {
        return [
            self::STATUS_KELENGKAPAN_ADA => 'Ada',
            self::STATUS_KELENGKAPAN_TIDAK_ADA => 'Tidak ada',
        ];
    }

    public static function getAllTingkatKelengkapan(): array
    {
        return [
            self::STATUS_TINGKAT_KELENGKAPAN_LENGKAP => 'Ada',
            self::STATUS_TINGKAT_KELENGKAPAN_KURANG_LENGKAP => 'Kurang Lengkap',
            self::STATUS_TINGKAT_KELENGKAPAN_TIDAK_LENGKAP => 'Tidak Lengkap',
        ];
    }

    public static function getItemPenilaian($penilaian)
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
