<?php

namespace App\Models\Core;

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
     * Relationships
     */

    public function question() {
        return $this->belongsTo(Question::class);
    }
}
