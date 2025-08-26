<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudyResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'study_plan_id','grade','score','notes'
    ];

    protected $casts = [
        'score' => 'float',
    ];

    public function studyPlan(): BelongsTo
    {
        return $this->belongsTo(StudyPlan::class);
    }
}
