<?php

use  App\Filament\Resources\MemberQuizResource\Pages\AnswerQuiz;
use App\Http\Controllers\TenantController;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Central Database routes
Route::group(['prefix' => 'tenants', 'as' => 'tenants.'], function() {
    Route::get('/create', function () {
        return view('tenants.create');
    })->name('create');

    Route::post('/store', 
        [TenantController::class, 'store']
    )->name('store');
});

// Tenant specific custom routes
Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::post(
        '/admin/member-quizzes/{record}/answer', 
        [AnswerQuiz::class, 'submitAnswers']
    )->name('filament.admin.resources.member-quizzes.answer.submit');
});