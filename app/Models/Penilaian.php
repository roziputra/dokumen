<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
