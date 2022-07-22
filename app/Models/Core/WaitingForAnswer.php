<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaitingForAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'email',
    ];

    /**
     * Relationships
     */

    public function question() {
        return $this->belongsTo(Question::class);
    }
}
