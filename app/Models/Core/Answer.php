<?php

namespace App\Models\Core;

use App\Models\User;
use Dyrynda\Database\Support\BindsOnUuid;
use Dyrynda\Database\Support\GeneratesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Answer extends Model
{
    use HasFactory, GeneratesUuid, BindsOnUuid, SoftDeletes;

    protected $fillable = [
        'question_id',
        'user_id',
        'content',
    ];

    /**
     * Relationships
     */

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function question() {
        return $this->belongsTo(Question::class);
    }

    /**
     * TODO: Recheck if relationship is correct.
     */
    public function followUpQuestions() {
        return $this->hasMany(Question::class, 'id', 'parent_answer_id');
    }
}
