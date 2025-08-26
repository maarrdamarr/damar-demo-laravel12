<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['code','name','credits','program_id'];

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function classes(): HasMany
    {
        return $this->hasMany(CourseClass::class);
    }
}
