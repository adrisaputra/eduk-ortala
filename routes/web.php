<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistrasiController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\DukController;
use App\Http\Controllers\ParentUnitController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ClassHistoryController;
use App\Http\Controllers\EducationHistoryController;
use App\Http\Controllers\PositionHistoryController;
// use App\Http\Controllers\PunishmentHistoryController;
use App\Http\Controllers\AbsenceHistoryController;
use App\Http\Controllers\LeaveHistoryController;
use App\Http\Controllers\FamilyHistoryController;
use App\Http\Controllers\TrainingHistoryController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DatabaseController;
use App\Http\Controllers\PromotionFileController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ConstitutionController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\SalaryIncreaseController;
use App\Http\Controllers\SalaryIncreaseFileController;
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
// Auth::routes(['verify' => true]);

Route::get('/buat_storage', function () {
    Artisan::call('storage:link');
    dd("Storage Berhasil Di Buat");
});

Route::get('/clear-cache-all', function() {
    Artisan::call('cache:clear');
    Artisan::call('route:cache');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('config:cache');
    dd("Cache Clear All");
});

if (file_exists(app_path('Http/Controllers/LocalizationController.php')))
{
    Route::get('lang/{locale}', [App\Http\Controllers\LocalizationController::class , 'lang']);
}

Route::get('/', [LoginController::class, 'index']);
Route::post('/login_w', [LoginController::class, 'authenticate']);
Route::post('/logout-sistem', [LoginController::class, 'logout']);

Route::middleware(['all_admin'])->group(function () {
        
    Route::get('/dashboard', [HomeController::class, 'index'])->middleware('verified');
    Route::get('/user/edit_profil/{user}', [UserController::class, 'edit_profil'])->middleware('verified');
    Route::put('/user/edit_profil/{user}', [UserController::class, 'update_profil'])->middleware('verified');

    ## Statistik
    Route::get('/statistic_number_of_employees', [StatisticController::class, 'number_of_employees']);
    Route::get('/statistic_number_of_class', [StatisticController::class, 'number_of_class']);

    ## DUK
    Route::get('/duk', [DukController::class, 'index']);
    Route::get('/duk/search', [DukController::class, 'search']);
    Route::post('/duk/print', [DukController::class, 'print']);

    ## Pegawai
    Route::get('/employee', [EmployeeController::class, 'index']);
    Route::get('/employee/search', [EmployeeController::class, 'search']);
    Route::get('/employee/create', [EmployeeController::class, 'create']);
    Route::post('/employee', [EmployeeController::class, 'store']);
    Route::get('/employee/edit/{employee}', [EmployeeController::class, 'edit']);
    Route::put('/employee/edit/{employee}', [EmployeeController::class, 'update']);
    Route::get('/employee/hapus/{employee}',[EmployeeController::class, 'delete']);
    Route::get('/employee/sync', [EmployeeController::class, 'sync']);
    Route::get('/employee/refresh', [EmployeeController::class, 'refresh']);
    Route::get('/employee/get_class/{employee}', [EmployeeController::class, 'get_class']);

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

    ## Report
    Route::get('/report',[ReportController::class, 'index']);

    # Riwayat Golongan
    Route::get('/class_employee', [EmployeeController::class, 'index']);
    Route::get('/class_employee/search', [EmployeeController::class, 'search']);
    Route::get('/class_employee/refresh', [EmployeeController::class, 'refresh']);
    Route::get('/class_history/{employee}', [ClassHistoryController::class, 'index']);
    Route::get('/class_history/search/{employee}', [ClassHistoryController::class, 'search']);
    Route::get('/class_history_sync_all', [ClassHistoryController::class, 'sync_all']);
    Route::get('/class_history/sync/{employee}', [ClassHistoryController::class, 'sync']);

    # Riwayat Pendidikan
    Route::get('/education_employee', [EmployeeController::class, 'index']);
    Route::get('/education_employee/search', [EmployeeController::class, 'search']);
    Route::get('/education_employee/refresh', [EmployeeController::class, 'refresh']);
    Route::get('/education_history/{employee}', [EducationHistoryController::class, 'index']);
    Route::get('/education_history/search/{employee}', [EducationHistoryController::class, 'search']);
    Route::get('/education_history_sync_all', [EducationHistoryController::class, 'sync_all']);
    Route::get('/education_history/sync/{employee}', [EducationHistoryController::class, 'sync']);

    # Riwayat Jabatan
    Route::get('/position_employee', [EmployeeController::class, 'index']);
    Route::get('/position_employee/search', [EmployeeController::class, 'search']);
    Route::get('/position_employee/refresh', [EmployeeController::class, 'refresh']);
    Route::get('/position_history/{employee}', [PositionHistoryController::class, 'index']);
    Route::get('/position_history/search/{employee}', [PositionHistoryController::class, 'search']);
    Route::get('/position_history_sync_all', [PositionHistoryController::class, 'sync_all']);
    Route::get('/position_history/sync/{employee}', [PositionHistoryController::class, 'sync']);

    // # Riwayat Hukuman
    // Route::get('/punishment_employee', [EmployeeController::class, 'index']);
    // Route::get('/punishment_employee/search', [EmployeeController::class, 'search']);
    // Route::get('/punishment_employee/refresh', [EmployeeController::class, 'refresh']);
    // Route::get('/punishment_history/{employee}', [PunishmentHistoryController::class, 'index']);
    // Route::get('/punishment_history/search/{employee}', [PunishmentHistoryController::class, 'search']);
    // Route::get('/punishment_history_sync_all', [PunishmentHistoryController::class, 'sync_all']);
    // Route::get('/punishment_history/sync/{employee}', [PunishmentHistoryController::class, 'sync']);

    # Riwayat Absensi
    Route::get('/absence_employee', [EmployeeController::class, 'index']);
    Route::get('/absence_employee/search', [EmployeeController::class, 'search']);
    Route::get('/absence_employee/refresh', [EmployeeController::class, 'refresh']);
    Route::get('/absence_history/{employee}', [AbsenceHistoryController::class, 'index']);
    Route::get('/absence_history/search/{employee}', [AbsenceHistoryController::class, 'search']);
    Route::post('/absence_history_sync_all', [AbsenceHistoryController::class, 'sync_all']);
    Route::post('/absence_history/sync/{employee}', [AbsenceHistoryController::class, 'sync']);

    # Riwayat Cuti
    Route::get('/leave_employee', [EmployeeController::class, 'index']);
    Route::get('/leave_employee/search', [EmployeeController::class, 'search']);
    Route::get('/leave_employee/refresh', [EmployeeController::class, 'refresh']);
    Route::get('/leave_history/{employee}', [LeaveHistoryController::class, 'index']);
    Route::get('/leave_history/search/{employee}', [LeaveHistoryController::class, 'search']);
    Route::get('/leave_history_sync_all', [LeaveHistoryController::class, 'sync_all']);
    Route::get('/leave_history/sync/{employee}', [LeaveHistoryController::class, 'sync']);

    # Riwayat Keluarga
    Route::get('/family_employee', [EmployeeController::class, 'index']);
    Route::get('/family_employee/search', [EmployeeController::class, 'search']);
    Route::get('/family_employee/refresh', [EmployeeController::class, 'refresh']);
    Route::get('/family_history/{employee}', [FamilyHistoryController::class, 'index']);
    Route::get('/family_history/search/{employee}', [FamilyHistoryController::class, 'search']);
    Route::get('/family_history_sync_all', [FamilyHistoryController::class, 'sync_all']);
    Route::get('/family_history/sync/{employee}', [FamilyHistoryController::class, 'sync']);

    # Riwayat Diklat
    Route::get('/training_employee', [EmployeeController::class, 'index']);
    Route::get('/training_employee/search', [EmployeeController::class, 'search']);
    Route::get('/training_employee/refresh', [EmployeeController::class, 'refresh']);
    Route::get('/training_history/{employee}', [TrainingHistoryController::class, 'index']);
    Route::get('/training_history/search/{employee}', [TrainingHistoryController::class, 'search']);
    Route::get('/training_history_sync_all', [TrainingHistoryController::class, 'sync_all']);
    Route::get('/training_history/sync/{employee}', [TrainingHistoryController::class, 'sync']);
        
    ## Naik Pangkat
    Route::get('/promotion', [PromotionController::class, 'index']);
    Route::get('/promotion/search', [PromotionController::class, 'search']);
    Route::get('/promotion/delete/{promotion}',[PromotionController::class, 'delete']);

    ## File Naik Pangkat
    Route::get('/promotion_file/{promotion}', [PromotionFileController::class, 'index']);
    Route::get('/promotion_file/{promotion}/search', [PromotionFileController::class, 'search']);
    Route::get('/promotion_file/{promotion}/create', [PromotionFileController::class, 'create']);
    Route::post('/promotion_file/{promotion}', [PromotionFileController::class, 'store']);
    Route::get('/promotion_file/edit/{promotion}/{promotion_file}', [PromotionFileController::class, 'edit']);
    Route::put('/promotion_file/edit/{promotion}/{promotion_file}', [PromotionFileController::class, 'update']);
    Route::get('/promotion_file/delete/{promotion_file}',[PromotionFileController::class, 'delete']);

    ## KGB
    Route::get('/salary_increase', [SalaryIncreaseController::class, 'index']);
    Route::get('/salary_increase/search', [SalaryIncreaseController::class, 'search']);

    ## File KGB
    Route::get('/salary_increase_file/{salary_increase}', [SalaryIncreaseFileController::class, 'index']);
    Route::get('/salary_increase_file/{salary_increase}/search', [SalaryIncreaseFileController::class, 'search']);
    Route::get('/salary_increase_file/{salary_increase}/create', [SalaryIncreaseFileController::class, 'create']);
    Route::post('/salary_increase_file/{salary_increase}', [SalaryIncreaseFileController::class, 'store']);
    Route::get('/salary_increase_file/edit/{salary_increase}/{salary_increase_file}', [SalaryIncreaseFileController::class, 'edit']);
    Route::put('/salary_increase_file/edit/{salary_increase}/{salary_increase_file}', [SalaryIncreaseFileController::class, 'update']);
    Route::get('/salary_increase_file/delete/{salary_increase_file}',[SalaryIncreaseFileController::class, 'delete']);

    ## Edit Profil
    Route::get('/edit_profil/{user}',[UserController::class, 'edit_profil']);
    Route::put('/edit_profil/{user}',[UserController::class, 'update_profil']);

});

Route::middleware(['admin_biro'])->group(function () {
    
    ## Naik Pangkat
    Route::get('/promotion/create', [PromotionController::class, 'create']);
    Route::post('/promotion', [PromotionController::class, 'store']);
    Route::get('/promotion/edit/{promotion}', [PromotionController::class, 'edit']);
    Route::put('/promotion/edit/{promotion}', [PromotionController::class, 'update']);
    Route::get('/promotion/delete/{promotion}',[PromotionController::class, 'delete']);
    Route::get('/promotion/send/{year}/{period}',[PromotionController::class, 'send']);
    
    ## KGB
    Route::get('/salary_increase/create', [SalaryIncreaseController::class, 'create']);
    Route::post('/salary_increase', [SalaryIncreaseController::class, 'store']);
    Route::get('/salary_increase/edit/{salary_increase}', [SalaryIncreaseController::class, 'edit']);
    Route::put('/salary_increase/edit/{salary_increase}', [SalaryIncreaseController::class, 'update']);
    Route::get('/salary_increase/delete/{salary_increase}',[SalaryIncreaseController::class, 'delete']);
    Route::get('/salary_increase/send/{salary_increase}',[SalaryIncreaseController::class, 'send']);
    
});

Route::middleware(['administrator'])->group(function () {

    ## Setting
    Route::get('/setting', [SettingController::class, 'index']);
    Route::put('/setting/edit/{setting}', [SettingController::class, 'update']);

    ## Log Activity
    Route::get('/log', [LogController::class, 'index']);
    Route::get('/log/search', [LogController::class, 'search']);

    ## Undang-undang
    Route::get('/constitution', [ConstitutionController::class, 'index']);
    Route::get('/constitution/search', [ConstitutionController::class, 'search']);
    Route::get('/constitution/create', [ConstitutionController::class, 'create']);
    Route::post('/constitution', [ConstitutionController::class, 'store']);
    Route::get('/constitution/edit/{constitution}', [ConstitutionController::class, 'edit']);
    Route::put('/constitution/edit/{constitution}', [ConstitutionController::class, 'update']);
    Route::get('/constitution/delete/{constitution}',[ConstitutionController::class, 'delete']);
     
    ## Kenaikan Pangkat
    Route::get('/parent_unit_promotion', [ParentUnitController::class, 'index']);
    Route::get('/parent_unit_promotion/search', [ParentUnitController::class, 'search']);
    Route::get('/promotion/{parent_unit}', [PromotionController::class, 'index_admin']);
    Route::get('/promotion/search/{parent_unit}', [PromotionController::class, 'search_admin']);
    Route::get('/promotion/accept/{promotion}',[PromotionController::class, 'process']);
    Route::get('/promotion/reject/{promotion}',[PromotionController::class, 'process']);
    Route::post('/promotion/fix_document/{promotion}',[PromotionController::class, 'fix_document']);
    Route::get('/promotion/print_letter/{promotion}/{year}/{periode}',[PromotionController::class, 'print_letter']);
    Route::get('/promotion/print_attachment/{promotion}/{year}/{periode}',[PromotionController::class, 'print_attachment']);

    ## KGB
    Route::get('/parent_unit_salary_increase', [ParentUnitController::class, 'index']);
    Route::get('/parent_unit_salary_increase/search', [ParentUnitController::class, 'search']);
    Route::get('/salary_increase/{parent_unit}', [SalaryIncreaseController::class, 'index_admin']);
    Route::get('/salary_increase/search/{parent_unit}', [SalaryIncreaseController::class, 'search_admin']);
    Route::get('/salary_increase/accept/{salary_increase}',[SalaryIncreaseController::class, 'process']);
    Route::get('/salary_increase/reject/{salary_increase}',[SalaryIncreaseController::class, 'process']);
    Route::post('/salary_increase/fix_document/{salary_increase}',[SalaryIncreaseController::class, 'fix_document']);
    Route::get('/salary_increase/print_letter/{salary_increase}/{year}/{periode}',[SalaryIncreaseController::class, 'print_letter']);
    Route::get('/salary_increase/print_attachment/{salary_increase}/{year}/{periode}',[SalaryIncreaseController::class, 'print_attachment']);

    ## User
    Route::get('/user', [UserController::class, 'index']);
    Route::get('/user/search', [UserController::class, 'search']);
    Route::get('/user/create', [UserController::class, 'create']);
    Route::post('/user', [UserController::class, 'store']);
    Route::get('/user/edit/{user}', [UserController::class, 'edit']);
    Route::put('/user/edit/{user}', [UserController::class, 'update']);
    Route::get('/user/hapus/{user}',[UserController::class, 'delete']);
    
    Route::get('database',[DatabaseController::class, 'index']);
    Route::post('import_database',[DatabaseController::class, 'store']);
    Route::get('/backup_database', function() {
        Artisan::call('database:backup');
        return response()->download(public_path().'/db_backup/eduk-backup-' . Carbon::now()->format('Y-m-d') . '.sql');
    });

});

