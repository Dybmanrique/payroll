<?php

use App\Http\Controllers\AfpController;
use App\Http\Controllers\BudgetaryObjectiveController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\FundingResourceController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\IdentityTypeController;
use App\Http\Controllers\JobPositionController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\PayrollTypeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkerAuthController;
use App\Http\Controllers\CheckBallotsController;
use Illuminate\Support\Facades\Route;


// Route::get('/', function () {
//     return view('welcome'); // Vista para empleados
// })->middleware(['web'])->name('welcome');

Route::middleware(['web'])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard.index');
Route::get('/dashboard/estadisticas-pagos', [DashboardController::class, 'get_statistics_payments'])->middleware(['auth', 'verified'])->name('dashboard.get_statistics_payments');

Route::middleware('auth')->group(function () {
    Route::get('/afps', [AfpController::class, 'index'])->name('afps.index');
    Route::get('/afps/data', [AfpController::class, 'data'])->name('afps.data');
    Route::get('/afps/crear', [AfpController::class, 'create'])->name('afps.create');
    Route::get('/afps/{afp}/editar', [AfpController::class, 'edit'])->name('afps.edit');
    Route::post('/afps/eliminar', [AfpController::class, 'destroy'])->name('afps.destroy');
    Route::get('/afps/permisos', [AfpController::class, 'get_permissions'])->name('afps.get_permissions');
    
    Route::get('/metas-presupuestales', [BudgetaryObjectiveController::class, 'index'])->name('budgetary_objectives.index');
    Route::get('/metas-presupuestales/data', [BudgetaryObjectiveController::class, 'data'])->name('budgetary_objectives.data');
    Route::get('/metas-presupuestales/crear', [BudgetaryObjectiveController::class, 'create'])->name('budgetary_objectives.create');
    Route::get('/metas-presupuestales/{budgetary_objective}/editar', [BudgetaryObjectiveController::class, 'edit'])->name('budgetary_objectives.edit');
    Route::post('/metas-presupuestales/eliminar', [BudgetaryObjectiveController::class, 'destroy'])->name('budgetary_objectives.destroy');
    Route::get('/metas-presupuestales/permisos', [BudgetaryObjectiveController::class, 'get_permissions'])->name('budgetary_objectives.get_permissions');
    
    Route::get('/grupos', [GroupController::class, 'index'])->name('groups.index');
    Route::get('/grupos/data', [GroupController::class, 'data'])->name('groups.data');
    Route::get('/grupos/crear', [GroupController::class, 'create'])->name('groups.create');
    Route::get('/grupos/{group}/editar', [GroupController::class, 'edit'])->name('groups.edit');
    Route::post('/grupos/eliminar', [GroupController::class, 'destroy'])->name('groups.destroy');
    Route::get('/grupos/permisos', [GroupController::class, 'get_permissions'])->name('groups.get_permissions');
    
    Route::get('/cargos-laborales', [JobPositionController::class, 'index'])->name('job_positions.index');
    Route::get('/cargos-laborales/data', [JobPositionController::class, 'data'])->name('job_positions.data');
    Route::get('/cargos-laborales/crear', [JobPositionController::class, 'create'])->name('job_positions.create');
    Route::get('/cargos-laborales/{job_position}/editar', [JobPositionController::class, 'edit'])->name('job_positions.edit');
    Route::post('/cargos-laborales/eliminar', [JobPositionController::class, 'destroy'])->name('job_positions.destroy');
    Route::get('/cargos-laborales/permisos', [JobPositionController::class, 'get_permissions'])->name('job_positions.get_permissions');
    
    Route::get('/niveles', [LevelController::class, 'index'])->name('levels.index');
    Route::get('/niveles/data', [LevelController::class, 'data'])->name('levels.data');
    Route::get('/niveles/crear', [LevelController::class, 'create'])->name('levels.create');
    Route::get('/niveles/{level}/editar', [LevelController::class, 'edit'])->name('levels.edit');
    Route::post('/niveles/eliminar', [LevelController::class, 'destroy'])->name('levels.destroy');
    Route::get('/niveles/permisos', [LevelController::class, 'get_permissions'])->name('levels.get_permissions');
    
    Route::get('/empleados', [EmployeeController::class, 'index'])->name('employees.index');
    Route::get('/empleados/data', [EmployeeController::class, 'data'])->name('employees.data');
    Route::get('/empleados/crear', [EmployeeController::class, 'create'])->name('employees.create');
    Route::get('/empleados/{employee}/editar', [EmployeeController::class, 'edit'])->name('employees.edit');
    Route::post('/empleados/eliminar', [EmployeeController::class, 'destroy'])->name('employees.destroy');
    Route::get('/empleados/permisos', [EmployeeController::class, 'get_permissions'])->name('employees.get_permissions');
    
    Route::get('/tipos-de-planillas', [PayrollTypeController::class, 'index'])->name('payroll_types.index');
    Route::get('/tipos-de-planillas/data', [PayrollTypeController::class, 'data'])->name('payroll_types.data');
    Route::get('/tipos-de-planillas/crear', [PayrollTypeController::class, 'create'])->name('payroll_types.create');
    Route::get('/tipos-de-planillas/{payroll_type}/editar', [PayrollTypeController::class, 'edit'])->name('payroll_types.edit');
    Route::post('/tipos-de-planillas/eliminar', [PayrollTypeController::class, 'destroy'])->name('payroll_types.destroy');
    Route::get('/tipos-de-planillas/permisos', [PayrollTypeController::class, 'get_permissions'])->name('payroll_types.get_permissions');
    
    Route::get('/fuentes-de-financiamiento', [FundingResourceController::class, 'index'])->name('funding_resources.index');
    Route::get('/fuentes-de-financiamiento/data', [FundingResourceController::class, 'data'])->name('funding_resources.data');
    Route::get('/fuentes-de-financiamiento/crear', [FundingResourceController::class, 'create'])->name('funding_resources.create');
    Route::get('/fuentes-de-financiamiento/{funding_resource}/editar', [FundingResourceController::class, 'edit'])->name('funding_resources.edit');
    Route::post('/fuentes-de-financiamiento/eliminar', [FundingResourceController::class, 'destroy'])->name('funding_resources.destroy');
    Route::get('/fuentes-de-financiamiento/permisos', [FundingResourceController::class, 'get_permissions'])->name('funding_resources.get_permissions');
    
    Route::get('/planillas', [PayrollController::class, 'index'])->name('payrolls.index');
    Route::get('/planillas/data', [PayrollController::class, 'data'])->name('payrolls.data');
    Route::get('/planillas/crear', [PayrollController::class, 'create'])->name('payrolls.create');
    Route::get('/planillas/{payroll}/editar', [PayrollController::class, 'edit'])->name('payrolls.edit');
    Route::post('/planillas/eliminar', [PayrollController::class, 'destroy'])->name('payrolls.destroy');
    Route::get('/planillas/{payment}/boleta-de-pago', [PayrollController::class, 'generate_payment_slip'])->name('payrolls.generate_payment_slip');
    Route::get('/planillas/{period}/boletas-de-pago', [PayrollController::class, 'generate_payment_slips_period'])->name('payrolls.generate_payment_slips_period');
    Route::get('/planillas/{period}/reporte-general', [PayrollController::class, 'general_report'])->name('payrolls.general_report');
    Route::get('/planillas/{period}/imprimir-planilla', [PayrollController::class, 'payroll_report'])->name('payrolls.payroll_report');
    Route::get('/planillas/{period}/resumen-planilla', [PayrollController::class, 'payroll_summary'])->name('payrolls.payroll_summary');
    Route::get('/planillas/permisos', [PayrollController::class, 'get_permissions'])->name('payrolls.get_permissions');

    Route::get('/parametros', [SettingController::class, 'index'])->name('settings.index');

    Route::get('/usuarios', [UserController::class, 'index'])->name('users.index');
    Route::get('/usuarios/data', [UserController::class, 'data'])->name('users.data');
    Route::get('/usuarios/crear', [UserController::class, 'create'])->name('users.create');
    Route::get('/usuarios/{user}/editar', [UserController::class, 'edit'])->name('users.edit');
    Route::post('/usuarios/eliminar', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('/usuarios/permisos', [UserController::class, 'get_permissions'])->name('users.get_permissions');

    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/data', [RoleController::class, 'data'])->name('roles.data');
    Route::get('/roles/crear', [RoleController::class, 'create'])->name('roles.create');
    Route::get('/roles/{role}/editar', [RoleController::class, 'edit'])->name('roles.edit');
    Route::post('/roles/eliminar', [RoleController::class, 'destroy'])->name('roles.destroy');
    Route::get('/roles/permisos', [RoleController::class, 'get_permissions'])->name('roles.get_permissions');
    
    Route::get('/tipos-de-identificacion', [IdentityTypeController::class, 'index'])->name('identity_types.index');
    Route::get('/tipos-de-identificacion/data', [IdentityTypeController::class, 'data'])->name('identity_types.data');
    Route::get('/tipos-de-identificacion/crear', [IdentityTypeController::class, 'create'])->name('identity_types.create');
    Route::get('/tipos-de-identificacion/{identity_type}/editar', [IdentityTypeController::class, 'edit'])->name('identity_types.edit');
    Route::post('/tipos-de-identificacion/eliminar', [IdentityTypeController::class, 'destroy'])->name('identity_types.destroy');
    Route::get('/tipos-de-identificacion/permisos', [IdentityTypeController::class, 'get_permissions'])->name('identity_types.get_permissions');
});

Route::prefix('trabajadores')->group(function () {
    Route::get('iniciar-sesion', [WorkerAuthController::class, 'showLoginForm'])->name('workers.login');
    Route::post('iniciar-sesion', [WorkerAuthController::class, 'login']);
    Route::post('logout', [WorkerAuthController::class, 'logout'])->name('workers.logout');

    Route::middleware('auth.worker')->group(function () {
        Route::get('mis-boletas', function () {
            return view('workers.dashboard'); // Vista para empleados
        })->name('workers.dashboard');
        Route::get('/{payment}/ver-boleta', [CheckBallotsController::class, 'generate_payment_slip'])->name('check_ballots.payment_slip');
    });
});


require __DIR__.'/auth.php';
