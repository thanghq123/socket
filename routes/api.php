<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('live-score', function (Request $request) {

//    if (!empty($request->point_change)) {
//        \App\Models\TmpQuizResult::query()->where('user_id', 24)->update(['point' => $request->point_change]);
//    }


    $data = Cache::get('exam.' . $request->code, []);

//    return $data;
//    if ($request->flag === 'init'):

    $key = 'A' . $request->data['id'];
    $newUser = [
        'user_id' => $request->data['id'],
        'name' => $request->data['name'],
        'total_time' => $request->data['total_time'] ?? 0,
        'total_point' => $request->data['total_point'] ?? 0,
        'errors' => $request->data['errors'] ?? 0,
    ];

    $data[$key] = $newUser;
//    else:
//        $data = $request->data;
//    endif;

    Cache::put('exam.' . $request->code, $data, 2 * 60 * 60);
//    $request->data = array_values($data);
    \event(new \App\Events\ResultLiveScoreEvent($request, array_values($data)));

    return array_values($data);
});

Route::get('get-result/{code}', function (Request $request, $code) {

    $data = Cache::get('exam.' . $code, []);

    return $data;
})->name('get-result');

Route::post('get-result/{code}', function (Request $request, $code) {

    $dataCache = Cache::get('exam.' . $code, []);

    $dataRequest = array_reduce((array)$request->data, function ($carry, $user) {
        $key = 'A' . $user['user_id'];
        $carry[$key] = $user;
        return $carry;
    }, []);

//    Cache::flush();

    $data = array_merge($dataCache, $dataRequest);

    Cache::put('exam.' . $code, $data, 2 * 60 * 60);

    return array_values($data);

})->name('get-result-post');

Route::get('exam/{code}', function (Request $request, $code) {

    $data = \App\Models\QuizExam::query()->where('code', $code)->first();

    if (empty($data)) {
        return [
            'status' => false,
            'message' => 'Exam not found!',
        ];
    }

    Cache::forget('exam.' . $code);
    return [
        'status' => true,
        'data' => $data,
    ];

})->name('exam');
