<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    use HasFactory;

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
     * Relationships
     */

    public function user() {
        return $this->belongsTo(User::class);
    }
}
