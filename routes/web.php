<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\TestResultController;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\TestResult;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if(Auth::user()->rule == 1) {
        $users = User::orderBy('name')->get();
        return view('users.user-list', ['auth' => Auth::check(), 'rule' => Auth::user()->rule, 'users' => $users]);
    }else{
        $results = DB::table('test_results')
            ->join('tests', 'tests.id', '=', 'test_results.test_id')
            ->select('tests.title', 'test_results.*')
            ->where('test_results.user_id', Auth::user()->id)->get();
        return view('tests.results', ['results' => $results, 'rule' => 0]);
    }
})->middleware('auth');

Auth::routes();

Route::get('/test', [TestController::class, 'index'])->middleware('auth');
Route::get('/new-test-item', [TestController::class, 'newItem'])->middleware('auth');
Route::get('/new-user-item', [UserController::class, 'newItem'])->middleware('auth');
Route::get('/new-test-result-item', [TestResultController::class, 'newItem'])->name('new-test-result-item')->middleware('auth');
Route::post('/save-test', [TestController::class, 'saveTestItem'])->middleware('auth');
Route::post('/save-user', [UserController::class, 'saveUserItem'])->middleware('auth');
Route::post('/save-result-test', [TestResultController::class, 'saveTestResultItem'])->name('save-result-test')->middleware('auth');
Route::get('/edit-test/{id}', [TestController::class, 'editTestItem'])->middleware('auth');
Route::get('/edit-user/{id}', [UserController::class, 'editUserItem'])->middleware('auth');
Route::get('/edit-test-result/{id}', [TestResultController::class, 'editTestResultItem'])->middleware('auth');
Route::get('/delete-test/{id}', [TestController::class, 'deleteTestItem'])->middleware('auth');
Route::get('/delete-user/{id}', [UserController::class, 'deleteUserItem'])->middleware('auth');
Route::get('/delete-test-result/{id}', [TestResultController::class, 'deleteTestResultItem'])->middleware('auth');
