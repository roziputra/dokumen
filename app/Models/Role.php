<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    const PERMISSION_VIEW_USER = 'lihat-semua-user';
    const PERMISSION_CREATE_USER = 'buat-user';
    const PERMISSION_EDIT_USER = 'edit-user';
    const PERMISSION_DELETE_USER = 'hapus-user';

    const PERMISSION_VIEW_PENILAIAN = 'lihat-semua-penilaian';
    const PERMISSION_CREATE_PENILAIAN = 'buat-penilaian';
    const PERMISSION_SHOW_PENILAIAN = 'lihat-penilaian';
    const PERMISSION_EDIT_PENILAIAN = 'edit-penilaian';
    const PERMISSION_DELETE_PENILAIAN = 'hapus-penilaian';

    const PERMISSION_ADD_ITEM_PENILAIAN = 'tambah-item-penilaian';
    const PERMISSION_EDIT_ITEM_PENILAIAN = 'edit-item-penilaian';
    const PERMISSION_DELETE_ITEM_PENILAIAN = 'hapus-item-penilaian';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'user_id', 'permissions',
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

    public static function getAdminPermissionMapping(): array
    {
        return [
            self::PERMISSION_VIEW_USER => 'Lihat Semua User',
            self::PERMISSION_CREATE_USER => 'Buat User',
            self::PERMISSION_EDIT_USER => 'Edit User',
            self::PERMISSION_DELETE_USER => 'Hapus User',
            self::PERMISSION_VIEW_PENILAIAN => 'Lihat Semua Penilaian',
            self::PERMISSION_CREATE_PENILAIAN => 'Buat Penilaian',
            self::PERMISSION_SHOW_PENILAIAN => 'Lihat Penilaian',
            self::PERMISSION_EDIT_PENILAIAN => 'Edit Penilaian',
            self::PERMISSION_DELETE_PENILAIAN => 'Hapus Penilaian',
            self::PERMISSION_ADD_ITEM_PENILAIAN => 'Tambah Item Penilaian',
            self::PERMISSION_EDIT_ITEM_PENILAIAN => 'Edit Item Penilaian',
            self::PERMISSION_DELETE_ITEM_PENILAIAN => 'Hapus Item Penilaian',
        ];
    }

    public static function getUserPermissionMapping(): array
    {
        return [
            self::PERMISSION_SHOW_PENILAIAN => 'Lihat Penilaian',
        ];
    }

    public static function getPermissionMapping(): array
    {
        return array_merge(self::getAdminPermissionMapping(), self::getUserPermissionMapping());
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public static function getPermissions(int $userId)
    {
        $data = self::find($userId);
        if (!$data) {
            return null;
        }

        return json_decode($data->permissions, true);
    }
}
