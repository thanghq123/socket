<?php

use App\Events\TestEvent;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redis;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::get('/test', function () {
//    event(new App\Events\TestEvent('Hello, world!'));
    Event::dispatch(new TestEvent('123'));
    return 'Event has been sent!';
});

Route::get('result', function () {
    return view('result');
});

Route::get('get-result/{code}', function (Request $request, $code) {
    $results = \App\Models\QuizExamResult::with('user')
        ->select(['id', 'results', 'point', 'total_time', 'user_id'])
        ->where('quiz_exam_id', 1)
        ->orderBy('created_at', 'desc')
        ->get();

//    $data = \App\Models\TmpQuizResult::query()
//        ->selectRaw('tmp_quiz_results.user_id, users.name, SUM(time) as total_time, SUM(point) as total_point')
//        ->join('users', 'users.id', '=', 'tmp_quiz_results.user_id')
//        ->where('code', $code)
//        ->groupBy('user_id')
//        ->get();

//    return $data;
    return $results;
})->name('get-result');

Route::get('live-score', function () {
    $randomScore = random_int(1, 10);
    \App\Models\QuizExamResult::query()->find(3772)->update(['point' => $randomScore]);

    \event(new \App\Events\ResultLiveScoreEvent(true));

    return 'success';
});
