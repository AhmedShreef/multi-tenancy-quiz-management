<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Question;
use App\Models\Submission;
use App\Models\User;
use Auth;
class Quiz extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description' ,'created_by'];

    protected static function booted()
    {
        static::creating(function ($quiz) {
            $quiz->created_by = Auth::id();
        });
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    public function creator(){
        return $this->belongsTo(User::class, 'created_by');
    }
}
