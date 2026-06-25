<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{LoginController, DashboardController, ClientController, MessageController, TechController, RoleController, AdminController, ProjectController, ProjectTimelineController, NotificationController, UserController};
use App\Events\MessageSent;
use Illuminate\Http\Request;
use App\Models\Message;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Support\Facades\Artisan;

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

Route::get('/register/users', [UserController::class, 'create']);
Route::post('/register/store', [UserController::class, 'store'])->name('user_register');

Route::get('/register/clients', [ClientController::class, 'registerClient']);
Route::post('/register/client/store', [ClientController::class, 'storeClient'])->name('client_register');


// login routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('admin_login')->middleware('admin_guest');
Route::post('/submit-login', [LoginController::class, 'submitLogin'])->name('submitLogin')->middleware('admin_guest');

Route::get('/db-seed', function(){
      Artisan::call('migrate');
      Artisan::call('db:seed');

    return 'Database seeded successfully!';
});


Route::middleware('admin')->group(function () {
    // dashboard
    Route::get('/', [DashboardController::class, 'dashboard']);
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('admin_dashboard');

    Route::post('/dashboard-read', [DashboardController::class, 'dashboardRead'])->name('dashboardRead');
    
    // logout route
    Route::post('/logout', [LoginController::class, 'logout'])->name('admin_logout');
    
    // message route
    Route::get('message', [MessageController::class, 'index'])->name('message.index');
    Route::post('/send-message', [MessageController::class, 'sendMessage']);
    
    
    // client route
    Route::resource('/client', ClientController::class);
    Route::post('/client-status', [ClientController::class, 'clientStatus'])->name('clientStatus');
    Route::post('/accept-client-request', [ClientController::class, 'acceptClientReq'])->name('acceptClientReq');
    Route::post('/reject-reason-client', [ClientController::class, 'rejectReasonClient'])->name('rejectReasonClient');

    // Tech route
    Route::resource('/tech', TechController::class);
    Route::post('/tech-status', [TechController::class, 'techStatus'])->name('techStatus');

    // Role route
    Route::resource('/role', RoleController::class);
    Route::post('/role-status', [RoleController::class, 'roleStatus'])->name('roleStatus');

    // User route
    Route::resource('/admin', AdminController::class);
    Route::post('/admin-status', [AdminController::class, 'adminStatus'])->name('adminStatus');

    // project route
    Route::resource('/project', ProjectController::class);
    Route::post('/project-status', [ProjectController::class, 'projectStatus'])->name('projectStatus');
    Route::post('/accept-project-request', [ProjectController::class, 'acceptProReq'])->name('acceptProReq');
    Route::post('/reject-reason-pro', [ProjectController::class, 'rejectReasonPro'])->name('rejectReasonPro');
    

    // project timeline route
    Route::get('/project-timeline/{id}', [ProjectTimelineController::class, 'index'])->name('projectTimeline');
    Route::post('/project-timeline/store', [ProjectTimelineController::class, 'store'])->name('projectTimelineStore');
    Route::delete('/project-timeline-delete/{id}', [ProjectTimelineController::class, 'destroy'])->name('projectTimelineDelete');
    Route::post('/project-timeline-edit/{id}', [ProjectTimelineController::class, 'edit'])->name('projectTimelineEdit');
    Route::post('/project-timeline-update/{id}', [ProjectTimelineController::class, 'update'])->name('projectTimelineUpdate');

    // notification
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
});