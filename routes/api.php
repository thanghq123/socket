<?php

use Illuminate\Http\Request;
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

    \event(new \App\Events\ResultLiveScoreEvent($request->code ?? ''));

    return [
        'code' => $request->code ?? '',
        'point_change' => $request->point_change ?? '',
    ];
});
