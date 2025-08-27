<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentRequest extends Model
{
    protected $fillable = [
        'student_id','type','reason','status','extra','submitted_at',
        'processed_by','processed_at','note'
    ];
    protected $casts = [
        'submitted_at'=>'datetime', 'processed_at'=>'datetime',
    ];
    public function student(){ return $this->belongsTo(User::class,'student_id'); }
}
