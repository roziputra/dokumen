<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    const TYPE_ADMIN = 'admin';
    const TYPE_USER = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function getAllTypes(): array
    {
        return [
            self::TYPE_ADMIN => 'Admin',
            self::TYPE_USER => 'User',
        ];
    }

    public function adminlte_image()
    {
        return 'https://picsum.photos/160';
    }

    public function adminlte_desc()
    {
        $currentUser = Auth::user();

        return $currentUser->name;
    }

    public function adminlte_profile_url()
    {
        return 'user/profile';
    }
}
