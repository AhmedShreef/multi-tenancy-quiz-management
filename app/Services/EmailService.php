<?php 
namespace App\Services;

use App\Jobs\SendQuizScoreEmail;
use App\Jobs\SendUserRegistrationEmail;
use App\Models\User;

class EmailService
{
    public function sendClientAdminLoginCredentials($data)
    {
        SendUserRegistrationEmail::dispatch($data);         // Dispatch the queue job
    }

    public function sendQuizScoreToMember($quizScoreData)
    {
        SendQuizScoreEmail::dispatch($quizScoreData);         // Dispatch the queue job
    }
}