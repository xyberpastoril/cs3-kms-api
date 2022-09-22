<?php

namespace App\Models\Core;

use App\Casts\EncryptCast;
use Carbon\Carbon;
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

    // protected $casts = [
    //     'email' => EncryptCast::class,
    // ];

    CONST UPDATED_AT = null;

    public function createdSince() {
        
        return Carbon::createFromTimeStamp(strtotime($this->attributes['created_at']) )->diffForHumans();
    }

    /**
     * Relationships
     */

    public function question() {
        return $this->belongsTo(Question::class);
    }
}
