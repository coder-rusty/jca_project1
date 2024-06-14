<?php

use App\Http\Controllers\RankingCtrl;
use App\Http\Controllers\SemJudgeCtrl;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\JudgeController;
use App\Http\Controllers\ContestantController;
use App\Http\Controllers\JudgesAuth;
use App\Http\Controllers\ScoreBoardController;
use App\Http\Controllers\PreliminaryController;
use App\Http\Controllers\PreliminaryAdminCtrl;
use App\Http\Controllers\AdminAuthentication;
use App\Http\Controllers\FinalCtrl;
use App\Http\Controllers\GownAdminCtrl;
use App\Http\Controllers\GownCtrl;
use App\Http\Controllers\SemifinalCtrl;
use App\Http\Controllers\SemisContestantCtrl;
use App\Http\Controllers\SwimwearAdminCtrl;
use App\Http\Controllers\SwimwearCtrl;

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

//admin authentication


Route::get('/', function () {
    return view('facilitator.authentication.login');
});

Route::post('/', [AdminAuthentication::class, 'login'])->name('admin.login');
Route::post('/login',[AdminAuthentication::class, 'login']);


Route::get('/admin/logout', [AdminAuthentication::class, 'logout'])->name('admin.logout');


Route::get('/jca', [EventController::class, 'index'])->name('event.index');

Route::post('/jca/create', [EventController::class, 'store'])->name('event.create');
Route::delete('/jca/{event}/delete', [EventController::class, 'destroy'])->name('event.delete');

Route::put('/jca/{eventID}/update', [EventController::class, 'update'])->name('event.update');


Route::get('/jca/{event}/show', [EventController::class, 'show'])->name('eventShow.show');

Route::post('/jca/judges/create', [JudgeController::class, 'store'])->name('judges.create');
Route::put('/jca/judges/{event}/{judge}/edit', [JudgeController::class, 'update'])->name('judge.edit');

Route::delete('/jca/judges/{event}/{judge}/delete', [JudgeController::class, 'destroy'])->name('judge.delete');


Route::post('/jca/{event}/login', [JudgesAuth::class, 'login'])->name('judges.login');


Route::get('/jca/dash/login', [EventController::class, 'judgeIndex'])->name('judging.index');

Route::get('/jca/logout', [JudgesAuth::class, 'logout'])->name('judge.logout');


//contestant


//To do
Route::get('/jca/contestant/{event}/new', function () {
  return "<h1>Add new contestant page</h1>";
});


Route::get('/jca/contestant/{event}/index', [ContestantController::class, 'index'])->name('contestant.index');

Route::post('/jca/contestant/create', [ContestantController::class, 'store'])->name('contestant.create');
Route::delete('/jca/contestant/{event}/{contestant}/delete', [ContestantController::class, 'destroy'])->name('contestant.delete');

Route::put('/jca/contestant/{contestantID}/update', [ContestantController::class, 'update'])->name('contestant.update');

Route::get('/jca/contestant/{event}/add-new', [ContestantController::class, 'addNew'])->name('contestant.add-new-form');

// Route::get(, function () {
//     return view("facilitator.singleEvent.contestants.addContestant");
// });

//Rating

Route::get('jca/preliminary/{event}/index', [PreliminaryAdminCtrl::class,'index'])->name('preliminaryRatings.index');

Route::post('/preliminaryScore', [PreliminaryController::class,'store']);




//JUDGING SYSTEM
Route::get('/jca/judges/{event}/{category}/{accessCode}', [JudgeController::class, 'index'])->name('judges.index');

Route::get('/jca/judges/scoreboard/preliminary', [PreliminaryController::class, 'index'])->name('preliminary.index');

//SEMI FINAL
Route::get('jca/judges/semifinal/scoreboard', [SemifinalCtrl::class,'indexJudges'])->name('semifinal.index');

Route::post('/semiScore', [SemJudgeCtrl::class,'store']);


//FINAL
Route::get('jca/judges/crown-final/scoreboard', [FinalCtrl::class,'indexJudges'])->name('finalJudge.index');
Route::post('/finalScore', [FinalCtrl::class,'store']);


Route::get('jca/final-round/{event}/index', [FinalCtrl::class,'indexAdmin'])->name('finalRatings.index');

//ADMIN SEMINFINAL
Route::get('/jca/semifinal/{event}/index', [SemifinalCtrl::class,'index'])->name('semifinalAdmin.index');

//GOWN

Route::get('/jca/judges/final/scoreboard', [GownCtrl::class, 'index'])->name('final.index');
Route::post('/gownScore', [GownCtrl::class,'store']);

Route::get('jca/gown/{event}/index', [GownAdminCtrl::class,'index'])->name('gownRatings.index');


//SWIMWEAR
Route::get('/jca/judges/scoreboard/swimwear', [SwimwearCtrl::class, 'index'])->name('swimwear.index');
Route::post('/swimwearScore', [SwimwearCtrl::class,'store']);


Route::get('jca/swimwear/{event}/index', [SwimwearAdminCtrl::class,'index'])->name('swimwearRatings.index');


Route::get('/jca/judges/scoreboard/criteria/gown', function () {
    return view('jcaJudges.pages.gown.index');
});

Route::get('/jca/judges/scoreboard/criteria/final', function () {
    return view('jcaJudges.pages.final.index');
});


//RANKING

Route::get("/jca/ranking/{event}/index", [RankingCtrl::class, 'index'])->name('ranking.index');


Route::post("/semiContestantAdd/{event}", [SemisContestantCtrl::class, 'store']);
