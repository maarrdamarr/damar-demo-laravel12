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
    public const TYPES = ['cuti','pengunduran','dispensasi','lainnya'];
    public const STATUSES = ['submitted','approved','rejected'];

    public function scopeSubmitted($q){ return $q->where('status','submitted'); }
    public function scopeType($q,$t){ return $q->where('type',$t); }
    public function scopeOwned($q,$uid){ return $q->where('student_id',$uid); }

    public function processor(){ return $this->belongsTo(User::class,'processed_by'); }

}
