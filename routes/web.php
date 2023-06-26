<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistrasiController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ClassHistoryController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DatabaseController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\MenuAccessController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\SubMenuAccessController;
use App\Http\Controllers\SubMenuController;
use App\Http\Controllers\UserController;
use Carbon\Carbon;

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
Auth::routes(['verify' => true]);

Route::get('/buat_storage', function () {
    Artisan::call('storage:link');
    dd("Storage Berhasil Di Buat");
});

Route::get('/clear-cache-all', function() {
    Artisan::call('cache:clear');
    dd("Cache Clear All");
});

if (file_exists(app_path('Http/Controllers/LocalizationController.php')))
{
    Route::get('lang/{locale}', [App\Http\Controllers\LocalizationController::class , 'lang']);
}

// Route::get('/', function () {
//     return view('auth.login');
// });

Route::get('/', [LoginController::class, 'index']);

Route::post('/login_w', [LoginController::class, 'authenticate']);
Route::get('registrasi_w', [RegistrasiController::class, 'registrasi']);
Route::post('registrasi_w', [RegistrasiController::class, 'store']);
Route::post('/logout-sistem', [LoginController::class, 'logout']);

Route::get('/dashboard', [HomeController::class, 'index'])->middleware('verified');
Route::get('/user/edit_profil/{user}', [UserController::class, 'edit_profil'])->middleware('verified');
Route::put('/user/edit_profil/{user}', [UserController::class, 'update_profil'])->middleware('verified');

Route::get('database',[DatabaseController::class, 'index']);
Route::post('import_database',[DatabaseController::class, 'store']);
Route::get('/backup_database', function() {
    Artisan::call('database:backup');
    return response()->download(public_path().'/db_backup/eduk-backup-' . Carbon::now()->format('Y-m-d') . '.sql');
});

// Route::middleware(['user_access','verified'])->group(function () {
    
    ## Pegawai
    Route::get('/employee', [EmployeeController::class, 'index']);
    Route::get('/employee/search', [EmployeeController::class, 'search']);
    Route::get('/employee/create', [EmployeeController::class, 'create']);
    Route::post('/employee', [EmployeeController::class, 'store']);
    Route::get('/employee/edit/{employee}', [EmployeeController::class, 'edit']);
    Route::put('/employee/edit/{employee}', [EmployeeController::class, 'update']);
    Route::get('/employee/hapus/{employee}',[EmployeeController::class, 'delete']);
    Route::get('/employee/sync', [EmployeeController::class, 'sync']);

    ## Pendidikan
    Route::get('/education', [EducationController::class, 'index']);
    Route::get('/education/search', [EducationController::class, 'search']);
    Route::get('/education/sync', [EducationController::class, 'sync']);
    Route::post('/get_education', [EducationController::class, 'get_education'])->name('getEducation');

    ## Golongan
    Route::get('/class', [ClassController::class, 'index']);
    Route::get('/class/search', [ClassController::class, 'search']);
    Route::get('/class/sync', [ClassController::class, 'sync']);

    ## Jabatan
    Route::get('/position', [PositionController::class, 'index']);
    Route::get('/position/search', [PositionController::class, 'search']);
    Route::get('/position/sync', [PositionController::class, 'sync']);

    ## Unor
    Route::get('/unit', [UnitController::class, 'index']);
    Route::get('/unit/search', [UnitController::class, 'search']);
    Route::get('/unit/sync', [UnitController::class, 'sync']);

    ## Opd
    Route::get('/slider', [SliderController::class, 'index']);
    Route::get('/slider/search', [SliderController::class, 'search']);
    Route::get('/slider/create', [SliderController::class, 'create']);
    Route::post('/slider', [SliderController::class, 'store']);
    Route::get('/slider/edit/{slider}', [SliderController::class, 'edit']);
    Route::put('/slider/edit/{slider}', [SliderController::class, 'update']);
    Route::get('/slider/hapus/{slider}',[SliderController::class, 'delete']);

    ## Opd
    Route::get('/office', [OfficeController::class, 'index']);
    Route::get('/office/search', [OfficeController::class, 'search']);
    Route::get('/office/create', [OfficeController::class, 'create']);
    Route::post('/office', [OfficeController::class, 'store']);
    Route::get('/office/edit/{office}', [OfficeController::class, 'edit']);
    Route::put('/office/edit/{office}', [OfficeController::class, 'update']);
    Route::get('/office/hapus/{office}',[OfficeController::class, 'delete']);

    ## Group
    Route::get('/group', [GroupController::class, 'index']);
    Route::get('/group/search', [GroupController::class, 'search']);
    Route::get('/group/create', [GroupController::class, 'create']);
    Route::post('/group', [GroupController::class, 'store']);
    Route::get('/group/edit/{group}', [GroupController::class, 'edit']);
    Route::put('/group/edit/{group}', [GroupController::class, 'update']);
    Route::get('/group/hapus/{group}',[GroupController::class, 'delete']);

    ## Menu
    Route::get('/menu/', [MenuController::class, 'index']);
    Route::get('/menu/search', [MenuController::class, 'search']);
    Route::get('/menu/create', [MenuController::class, 'create']);
    Route::post('/menu', [MenuController::class, 'store']);
    Route::get('/menu/edit/{menu}', [MenuController::class, 'edit']);
    Route::put('/menu/edit/{menu}', [MenuController::class, 'update']);
    Route::get('/menu/hapus/{menu}',[MenuController::class, 'delete']);

    ## User
    Route::get('/user', [UserController::class, 'index']);
    Route::get('/user/search', [UserController::class, 'search']);
    Route::get('/user/create', [UserController::class, 'create']);
    Route::post('/user', [UserController::class, 'store']);
    Route::get('/user/edit/{user}', [UserController::class, 'edit']);
    Route::put('/user/edit/{user}', [UserController::class, 'update']);
    Route::get('/user/hapus/{user}',[UserController::class, 'delete']);

    ## Log Activity
    Route::get('/log', [LogController::class, 'index']);
    Route::get('/log/search', [LogController::class, 'search']);

// });

// Route::middleware(['cek_status'])->group(function () {
    Route::get('/report',[ReportController::class, 'index']);

    ## Sub Menu
    Route::get('/sub_menu/{id}', [SubMenuController::class, 'index']);
    Route::get('/sub_menu/search/{id}', [SubMenuController::class, 'search']);
    Route::get('/sub_menu/create/{id}', [SubMenuController::class, 'create']);
    Route::post('/sub_menu/{id}', [SubMenuController::class, 'store']);
    Route::get('/sub_menu/edit/{id}/{sub_menu}', [SubMenuController::class, 'edit']);
    Route::put('/sub_menu/edit/{id}/{sub_menu}', [SubMenuController::class, 'update']);
    Route::get('/sub_menu/hapus/{id}/{sub_menu}',[SubMenuController::class, 'delete']);

    ## Menu Akses
    Route::get('/menu_akses/{group}', [MenuAccessController::class, 'index']);
    Route::get('/menu_akses/search/{group}', [MenuAccessController::class, 'search']);
    Route::get('/menu_akses/create/{group}', [MenuAccessController::class, 'create']);
    Route::post('/menu_akses/{group}', [MenuAccessController::class, 'store']);
    Route::get('/menu_akses/edit/{group}/{menu_access}', [MenuAccessController::class, 'edit']);
    Route::put('/menu_akses/edit/{group}/{menu_access}', [MenuAccessController::class, 'update']);
    Route::get('/menu_akses/hapus/{group}/{menu_access}',[MenuAccessController::class, 'delete']);

    ## Sub Menu Akses
    Route::get('/sub_menu_akses/{group}/{menu}', [SubMenuAccessController::class, 'index']);
    Route::get('/sub_menu_akses/search/{group}/{menu}', [SubMenuAccessController::class, 'search']);
    Route::get('/sub_menu_akses/create/{group}/{menu}', [SubMenuAccessController::class, 'create']);
    Route::post('/sub_menu_akses/{group}/{menu}', [SubMenuAccessController::class, 'store']);
    Route::get('/sub_menu_akses/edit/{group}/{menu}/{sub_menu_access}', [SubMenuAccessController::class, 'edit']);
    Route::put('/sub_menu_akses/edit/{group}/{menu}/{sub_menu_access}', [SubMenuAccessController::class, 'update']);
    Route::get('/sub_menu_akses/hapus/{group}/{menu}/{sub_menu_access}',[SubMenuAccessController::class, 'delete']);

    ## Setting
    Route::get('/setting', [SettingController::class, 'index']);
    Route::put('/setting/edit/{setting}', [SettingController::class, 'update']);

    
    # Riwayat Golongan
    Route::get('/class_employee', [EmployeeController::class, 'index']);
    Route::get('/class_employee/search', [EmployeeController::class, 'search']);
    Route::get('/class_history/{employee}', [ClassHistoryController::class, 'index']);
    Route::get('/class_history/search/{employee}', [ClassHistoryController::class, 'search']);
    Route::get('/class_history_sync_all', [ClassHistoryController::class, 'sync_all']);
    Route::get('/class_history/sync/{employee}', [ClassHistoryController::class, 'sync']);

// });

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('verified');


