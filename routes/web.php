<?php

use App\Http\Controllers\AfpController;
use App\Http\Controllers\BudgetaryObjectiveController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\FundingResourceController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\JobPositionController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\PayrollTypeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResourceTypeController;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth')->group(function () {
    Route::get('/afps', [AfpController::class, 'index'])->name('afps.index');
    Route::get('/afps/data', [AfpController::class, 'data'])->name('afps.data');
    Route::get('/afps/crear', [AfpController::class, 'create'])->name('afps.create');
    Route::get('/afps/{afp}/editar', [AfpController::class, 'edit'])->name('afps.edit');
    Route::post('/afps/eliminar', [AfpController::class, 'destroy'])->name('afps.destroy');
    
    Route::get('/metas-presupuestales', [BudgetaryObjectiveController::class, 'index'])->name('budgetary_objectives.index');
    Route::get('/metas-presupuestales/data', [BudgetaryObjectiveController::class, 'data'])->name('budgetary_objectives.data');
    Route::get('/metas-presupuestales/crear', [BudgetaryObjectiveController::class, 'create'])->name('budgetary_objectives.create');
    Route::get('/metas-presupuestales/{budgetary_objective}/editar', [BudgetaryObjectiveController::class, 'edit'])->name('budgetary_objectives.edit');
    Route::post('/metas-presupuestales/eliminar', [BudgetaryObjectiveController::class, 'destroy'])->name('budgetary_objectives.destroy');
    
    Route::get('/grupos', [GroupController::class, 'index'])->name('groups.index');
    Route::get('/grupos/data', [GroupController::class, 'data'])->name('groups.data');
    Route::get('/grupos/crear', [GroupController::class, 'create'])->name('groups.create');
    Route::get('/grupos/{group}/editar', [GroupController::class, 'edit'])->name('groups.edit');
    Route::post('/grupos/eliminar', [GroupController::class, 'destroy'])->name('groups.destroy');
    
    Route::get('/cargos-laborales', [JobPositionController::class, 'index'])->name('job_positions.index');
    Route::get('/cargos-laborales/data', [JobPositionController::class, 'data'])->name('job_positions.data');
    Route::get('/cargos-laborales/crear', [JobPositionController::class, 'create'])->name('job_positions.create');
    Route::get('/cargos-laborales/{job_position}/editar', [JobPositionController::class, 'edit'])->name('job_positions.edit');
    Route::post('/cargos-laborales/eliminar', [JobPositionController::class, 'destroy'])->name('job_positions.destroy');
    
    Route::get('/niveles', [LevelController::class, 'index'])->name('levels.index');
    Route::get('/niveles/data', [LevelController::class, 'data'])->name('levels.data');
    Route::get('/niveles/crear', [LevelController::class, 'create'])->name('levels.create');
    Route::get('/niveles/{level}/editar', [LevelController::class, 'edit'])->name('levels.edit');
    Route::post('/niveles/eliminar', [LevelController::class, 'destroy'])->name('levels.destroy');
    
    Route::get('/empleados', [EmployeeController::class, 'index'])->name('employees.index');
    Route::get('/empleados/data', [EmployeeController::class, 'data'])->name('employees.data');
    Route::get('/empleados/crear', [EmployeeController::class, 'create'])->name('employees.create');
    Route::get('/empleados/{employee}/editar', [EmployeeController::class, 'edit'])->name('employees.edit');
    Route::post('/empleados/eliminar', [EmployeeController::class, 'destroy'])->name('employees.destroy');
    
    Route::get('/tipos-de-planillas', [PayrollTypeController::class, 'index'])->name('payroll_types.index');
    Route::get('/tipos-de-planillas/data', [PayrollTypeController::class, 'data'])->name('payroll_types.data');
    Route::get('/tipos-de-planillas/crear', [PayrollTypeController::class, 'create'])->name('payroll_types.create');
    Route::get('/tipos-de-planillas/{payroll_type}/editar', [PayrollTypeController::class, 'edit'])->name('payroll_types.edit');
    Route::post('/tipos-de-planillas/eliminar', [PayrollTypeController::class, 'destroy'])->name('payroll_types.destroy');
    
    Route::get('/fuentes-de-financiamiento', [FundingResourceController::class, 'index'])->name('funding_resources.index');
    Route::get('/fuentes-de-financiamiento/data', [FundingResourceController::class, 'data'])->name('funding_resources.data');
    Route::get('/fuentes-de-financiamiento/crear', [FundingResourceController::class, 'create'])->name('funding_resources.create');
    Route::get('/fuentes-de-financiamiento/{funding_resource}/editar', [FundingResourceController::class, 'edit'])->name('funding_resources.edit');
    Route::post('/fuentes-de-financiamiento/eliminar', [FundingResourceController::class, 'destroy'])->name('funding_resources.destroy');
    
    Route::get('/planillas', [PayrollController::class, 'index'])->name('payrolls.index');
    Route::get('/planillas/data', [PayrollController::class, 'data'])->name('payrolls.data');
    Route::get('/planillas/crear', [PayrollController::class, 'create'])->name('payrolls.create');
    Route::get('/planillas/{payroll}/editar', [PayrollController::class, 'edit'])->name('payrolls.edit');
    Route::post('/planillas/eliminar', [PayrollController::class, 'destroy'])->name('payrolls.destroy');
});


require __DIR__.'/auth.php';
