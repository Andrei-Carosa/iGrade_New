<?php

use App\Http\Controllers\DataController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ViewController;
use Illuminate\Support\Facades\Route;

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
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group(['prefix'=>'college','middleware'=>['auth','isFaculty','PreventBackHistory']], function(){

    Route::get('/my-class', [ViewController::class, 'my_class'])->name('college.my_class');
    Route::post('/my-class-fetch', [DataController::class, 'my_class_fetch'])->name('college.my_class_fetch');

    Route::post('/frs', [DataController::class, 'frs'])->name('college.frs');
    Route::post('/frs-fetch', [DataController::class, 'frs_fetch'])->name('college.frs_fetch');
    Route::post('/frs-student-inc', [DataController::class, 'frs_student_inc'])->name('college.frs_student_inc');

    Route::post('/class-record-term', [DataController::class, 'class_record_term'])->name('college.class_record_term');
    Route::post('/class-record-tbl', [DataController::class, 'class_record_tbl'])->name('college.class_record_tbl');

    Route::post('/class-grading-sheet', [DataController::class, 'class_grading_sheet'])->name('college.class_grading_sheet');
    Route::post('/tbl-grading-sheet', [DataController::class, 'tbl_grading_sheet'])->name('college.tbl_grading_sheet');

    Route::post('/add-activity', [DataController::class, 'add_activity'])->name('college.add_activity');
    Route::post('/save-added-activity', [DataController::class, 'save_added_activity'])->name('college.save_added_activity');
    Route::post('/remove-activity', [DataController::class, 'remove_activity'])->name('college.remove_activity');

    // Route::post('/add-column', [DataController::class, 'add_column'])->name('college.add_column');
    // Route::post('/remove-column', [DataController::class, 'remove_column'])->name('college.remove_column');


});

require __DIR__.'/auth.php';
