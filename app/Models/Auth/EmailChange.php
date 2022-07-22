<?php

namespace App\Models\Auth;

use App\Models\User;
use Dyrynda\Database\Support\GeneratesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailChange extends Model
{
    use HasFactory, GeneratesUuid;

    public $incrementing = false;

    protected $primary_key = 'token';

    protected $keyType = 'string';

    const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'new_email',
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
