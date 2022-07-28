<?php

namespace App\Models\Core;

use Dyrynda\Database\Support\BindsOnUuid;
use Dyrynda\Database\Support\GeneratesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Waitlister extends Model
{
    use HasFactory, GeneratesUuid, BindsOnUuid;

    protected $fillable = [
        'question_id',
        'email',
    ];

    CONST CREATED_AT = null;
    CONST UPDATED_AT = null;

    /**
     * Relationships
     */

    public function question() {
        return $this->belongsTo(Question::class);
    }
}
