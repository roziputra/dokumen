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
            self::PERMISSION_VIEW_PENILAIAN => 'Lihat Penilaian',
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
