<?php

namespace App\Models;

use App\Casts\EncryptCast;
use App\Models\Auth\EmailChange;
use App\Models\Auth\PasswordReset;
use App\Models\Core\Answer;
use Dyrynda\Database\Support\BindsOnUuid;
use Dyrynda\Database\Support\GeneratesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, GeneratesUuid, BindsOnUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
        // 'email' => EncryptCast::class,
        // 'name' => EncryptCast::class,
    ];

    /**
     * Relationships
     */

    public function answers() {
        return $this->hasMany(Answer::class);
    }

    public function passwordReset() {
        return $this->hasOne(PasswordReset::class);
    }

    public function emailChange() {
        return $this->hasOne(EmailChange::class);
    }
}
