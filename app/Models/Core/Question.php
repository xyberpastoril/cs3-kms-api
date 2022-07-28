<?php

namespace App\Models\Core;

use App\Models\Scopes\WithTrashedScope;
use Dyrynda\Database\Support\BindsOnUuid;
use Dyrynda\Database\Support\GeneratesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Question extends Model
{
    use HasFactory, GeneratesUuid, BindsOnUuid, SoftDeletes;

    protected $fillable = [
        'category_id',
        'parent_answer_id',
        'content',
    ];

    public function uuidColumn(): string
    {
        return 'uuid';
    }

    public function uuidColumns(): array
    {
        return ['uuid', 'update_token'];
    }

    /**
     * Relationships
     */

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function tags() {
        return $this->hasMany(Tag::class);
    }

    public function answers() {
        if(Auth::guard('api')->check()) {
            return $this->hasMany(Answer::class)->withTrashed();
        }
        return $this->hasMany(Answer::class);
    }

    /**
     * TODO: Recheck if relationship is correct.
     */
    public function fromAnswer() {
        return $this->belongsTo(Answer::class, 'parent_answer_id', 'id');
    }

    public function waitlisters() {
        return $this->hasMany(Waitlister::class);
    }
}
