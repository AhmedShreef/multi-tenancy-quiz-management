<?php

namespace App\Filament\Resources\MemberQuizResource\Pages;

use App\Filament\Resources\MemberQuizResource;
use App\Models\Question;
use App\Models\Quiz;
use App\Services\EmailService;
use Filament\Resources\Pages\Page;
use Illuminate\Http\Request;
class AnswerQuiz extends Page
{
    public $quiz;
    protected $emailService;

    protected static string $resource = MemberQuizResource::class;
    protected static string $view = 'filament.resources.member-quiz-resource.pages.answer-quiz';
    
    public function __construct(){
        $this->emailService = new EmailService();
    }

    public function mount($record)
    {
        // Eager load questions/options and find quiz object by id.
        $this->quiz = Quiz::with('questions.options')->findOrFail($record);
    }

    public function submitAnswers(Request $request, $record)
    {
        $validated = $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'exists:options,id',
        ]);
        
        // Find quiz object by id.
        $quiz = Quiz::findOrFail($record);

        // get questions with correct answers to compare against.
        $questionsWithCorrectAnswers = Question::whereIn('questions.id', array_keys($validated['answers']))
                                            ->selectRaw('questions.id AS question_id, options.id AS option_id')
                                            ->join('options', function ($join){
                                                $join->on('options.question_id', '=', 'questions.id');
                                                $join->where('options.is_correct', true);
                                            })
                                            ->pluck('option_id', 'question_id')
                                            ->toArray();

        $memberScore = 0;
        $TotalScore = count($questionsWithCorrectAnswers);  // simply number of questions represents the total score
    
        $submission = $quiz->submissions()->create([]);

        foreach ($validated['answers'] as $questionId => $optionId) {
            $submission->answers()->create([
                'question_id'           => $questionId,
                'selected_option_id'    => $optionId,
            ]);

            // If answer is correct, increase score
            if(isset($questionsWithCorrectAnswers[$questionId]) && $optionId == $questionsWithCorrectAnswers[$questionId])  
                $memberScore++;
        }

        // Save member score in submissions table
        $this->saveQuizScore($submission, $memberScore);

        // Send mail containing member score
        $this->emailService->sendQuizScoreToMember([
            'member_name'   => auth()->user()->name,
            'member_email'  => auth()->user()->email,
            'quiz_title'    => $quiz->title,
            'member_score'  => $memberScore,
            'total_score'   => $TotalScore,
        ]);
        
        session()->flash('success', 'Quiz submitted successfully, your score will be sent to your mail shortly.');
        return redirect()->route('filament.admin.resources.member-quizzes.index');
    }

    protected function saveQuizScore($submission, $memberScore)
    {
        $submission->update(['score' => $memberScore]);
    }
}
