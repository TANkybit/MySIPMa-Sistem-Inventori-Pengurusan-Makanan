<?php

/* |-------------------------------------------------------------------------- | Web Routes |-------------------------------------------------------------------------- | | Here is where you can register web routes for your application. These | routes are loaded by the RouteServiceProvider and all of them will | be assigned to the "web" middleware group. Make something great! | */
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Route for Laman Utama (index.blade.php)
Route::get('/', function () {
    return view('index');
})->name('index');

// Route for Log Masuk (login.blade.php)
Route::get('/login', function () {
    return view('login');
})->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Debug route - remove after testing
Route::get('/debug-dashboard', function () {
    $user = \Illuminate\Support\Facades\Auth::user();
    $orders = \App\Models\Order::all()->count();
    $approvals = \App\Models\Approval::all()->count();
    
    return response()->json([
        'auth_user' => $user ? [
            'id' => $user->id,
            'name' => $user->name,
            'institution_id' => $user->institution_id,
        ] : null,
        'total_orders_in_db' => $orders,
        'total_approvals_in_db' => $approvals,
        'user_orders' => $user && $user->institution_id ? \App\Models\Order::where('institution_id', $user->institution_id)->count() : 0,
        'user_pending_approvals' => $user && $user->institution_id ? \App\Models\Order::join('approvals', 'orders.id', '=', 'approvals.order_id')
            ->where('orders.institution_id', $user->institution_id)
            ->where('approvals.status', 0)
            ->distinct()
            ->count('orders.id') : 0,
    ]);
});

// Route for forgot.blade.php
Route::get('/forgot-password', function () {
    return view('forgot');
})->name('password.request');
Route::post('/forgot-password-check', [AuthController::class, 'checkEmail'])->name('password.check');

// Route for welcome page (added so views can link to it)
Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

Route::middleware('auth')->group(function () {
    Route::get('/admin', function () {
        $institutions = \App\Models\Institution::orderBy('name')->get();

        return view('admin_dashboard', compact('institutions'));
    })->name('admin.dashboard');

    Route::get('/dashboard/critical-stock', [DashboardController::class, 'criticalStock'])->name('dashboard.critical-stock');
    Route::get('/dashboard/stock-forecast', [DashboardController::class, 'stockForecast'])->name('dashboard.stock-forecast');

    Route::get('/admin/users', [\App\Http\Controllers\AdminController::class, 'listAdmins'])->name('admin.users');
    Route::post('/admin/register', [\App\Http\Controllers\AdminController::class, 'registerAdmin'])->name('admin.register');
    Route::put('/admin/{admin}', [\App\Http\Controllers\AdminController::class, 'updateAdmin'])->name('admin.update');

    Route::post('/position/store', [\App\Http\Controllers\PositionController::class, 'store'])->name('position.store');

    Route::get('/suppliers', [\App\Http\Controllers\SupplierController::class, 'index'])->name('suppliers.index');
    Route::post('/suppliers', [\App\Http\Controllers\SupplierController::class, 'store'])->name('suppliers.store');
    Route::put('/suppliers/{supplier}', [\App\Http\Controllers\SupplierController::class, 'update'])->name('suppliers.update');

    Route::post('/items', [\App\Http\Controllers\ItemController::class, 'store'])->name('items.store');

    Route::get('/categories', [\App\Http\Controllers\CategoryController::class, 'index'])->name('categories.index');

    Route::get('/uoms', [\App\Http\Controllers\UomController::class, 'index'])->name('uoms.index');
    Route::post('/uoms', [\App\Http\Controllers\UomController::class, 'store'])->name('uoms.store');
    Route::put('/uoms/{uom}', [\App\Http\Controllers\UomController::class, 'update'])->name('uoms.update');

    Route::get('/user/dashboard', [DashboardController::class, 'userDashboard'])->name('user.dashboard');

    Route::get('/borang-inden', [DashboardController::class, 'borangInden'])->name('borang.inden');
    Route::post('/borang-inden', [DashboardController::class, 'simpanBorangInden'])->name('borang.inden.store');
    Route::get('/borang-inden/{order}', [DashboardController::class, 'lihatBorangInden'])->name('borang.inden.show');

    Route::get('/user/senarai-inden', [DashboardController::class, 'senaraiInden'])->name('user.senarai.inden');

    Route::get('/user/pengesahan-inden', [DashboardController::class, 'pengesahanInden'])->name('user.pengesahan.inden');
    Route::post('/user/pengesahan-inden/{order}/sahkan', [DashboardController::class, 'sahkanInden'])->name('user.pengesahan.inden.sahkan');

    Route::get('/profile', [ProfileController::class, 'showProfile'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'editProfile'])->name('profile.edit');
    Route::get('/profile/me', [ProfileController::class , 'getProfile'])->name('profile.me');
    Route::post('/profile/update', [ProfileController::class , 'update'])->name('profile.update');
    Route::post('/profile/avatar', [ProfileController::class , 'updateAvatar'])->name('profile.avatar');
    Route::post('/profile/password', [ProfileController::class , 'updatePassword'])->name('profile.password');
});

// Route for Sejarah (sejarah.blade.php)
Route::get('/sejarah', function () {
    return view('sejarah');
})->name('sejarah');


// Route for sending email
Route::post('/contact', [ContactController::class , 'send'])
    ->name('contact.send');


?>
