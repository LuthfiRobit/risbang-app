<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    protected $primaryKey = 'id_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_user',
        'email',
        'email_verified_at',
        'username',
        'password',
        'phone_number',
        'user_role',
        'dosen_role',
        'active',
        'profile_pict'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the user associated with the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function reviewer(): HasOne
    {
        return $this->hasOne(Reviewer::class, 'user_id', 'id_user');
    }

    /**
     * Get the user associated with the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function dosen(): HasOne
    {
        return $this->hasOne(Dosen::class, 'user_id', 'id_user');
    }

    /**
     * Get the kaprodi associated with the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function kaprodi(): HasOne
    {
        return $this->hasOne(Prodi::class, 'user_id', 'id_user');
    }

    /**
     * Get the dekan associated with the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function dekan(): HasOne
    {
        return $this->hasOne(Fakultas::class, 'user_id', 'id_user');
    }
}
