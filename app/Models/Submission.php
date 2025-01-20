<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Quiz;
use App\Models\Answer;
use App\Models\User;
class Submission extends Model
{
    use HasFactory;
    protected $fillable = ['quiz_id', 'user_id', 'score', 'submitted_at'];

    protected static function booted()
    {
        static::creating(function ($submission) {
            $submission->user_id = \Auth::id();
            $submission->submitted_at = now();
        });
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function member()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
