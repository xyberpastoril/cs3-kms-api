<?php

namespace App\Models\Core;

use App\Casts\EncryptCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'name',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'name' => EncryptCast::class,
    ];

    /**
     * Relationships
     */

    public function question() {
        return $this->belongsTo(Question::class);
    }
}
