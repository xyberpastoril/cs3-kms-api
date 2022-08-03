<?php

namespace App\Models\Core;

use App\Casts\EncryptCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'name' => EncryptCast::class,
        'description' => EncryptCast::class,
    ];

    /**
     * Relationships
     */

    public function questions() {
        return $this->hasMany(Question::class);
    }
}
