<?php

namespace App\Models\Auth;

use App\Casts\EncryptCast;
use Dyrynda\Database\Support\GeneratesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    use HasFactory, GeneratesUuid;

    public $incrementing = false;

    protected $primaryKey = 'token';

    protected $keyType = 'string';

    const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
    ];

    public function uuidColumn(): string
    {
        return 'token';
    }

    /**
     * The attributes that should be cast.
     * ! TO BE TESTED LATER
     *
     * @var array<string, string>
     */
    protected $casts = [
        'token' => EncryptCast::class,
    ];

    /**
     * Relationships
     */

    public function user() {
        return $this->belongsTo(User::class);
    }
}
