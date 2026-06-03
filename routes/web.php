<?php

/* |-------------------------------------------------------------------------- | Web Routes |-------------------------------------------------------------------------- | | Here is where you can register web routes for your application. These | routes are loaded by the RouteServiceProvider and all of them will | be assigned to the "web" middleware group. Make something great! | */
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

// Global Search API (Accessible to logged-in users)
Route::middleware('auth')->get('/api/global-search', [SearchController::class, 'globalSearch'])->name('global.search');

// Pengarah HQ - Inden API (AJAX)
Route::middleware('auth')->get('/api/hq/inden', [DashboardController::class, 'apiHqInden'])->name('api.hq.inden');

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
    // --- Admin routes (full access) ---
    Route::get('/admin', [DashboardController::class, 'pengarahHQDashboard'])->name('admin.dashboard');

    Route::get('/pengarah-hq', function () {
        return redirect()->route('admin.dashboard');
    })->name('pengarah.hq.dashboard');

    Route::get('/pengarah-institusi', [DashboardController::class, 'pengarahInstitusiDashboard'])->name('pengarah.institusi.dashboard');
    Route::get('/pengarah-institusi/ringkasan', [DashboardController::class, 'pengarahInstitusiRingkasanPesanan'])->name('pengarah.institusi.ringkasan');
    Route::get('/pengarah-institusi/institusi', [DashboardController::class, 'pengarahInstitusiInstitusi'])->name('pengarah.institusi.institusi');
    Route::get('/pengarah-institusi/pembekal', [DashboardController::class, 'pengarahInstitusiPembekal'])->name('pengarah.institusi.pembekal');
    Route::get('/pengarah-institusi/senarai-user', [DashboardController::class, 'pengarahInstitusiSenaraiUser'])->name('pengarah.institusi.senarai_pengguna');
    Route::get('/pengarah-institusi/profil', [DashboardController::class, 'pengarahInstitusiProfil'])->name('pengarah.institusi.profil');
    Route::get('/pengarah-negeri', [DashboardController::class, 'pengarahNegeriDashboard'])->name('pengarah.negeri.dashboard');
    Route::get('/pengarah-negeri/inventori', [DashboardController::class, 'pengarahNegeriInventori'])->name('pengarah.negeri.inventori');
    Route::get('/pengarah-negeri/profil', [DashboardController::class, 'pengarahNegeriProfil'])->name('pengarah.negeri.profil');

    Route::get('/admin-institusi', [DashboardController::class, 'adminInstitusiDashboard'])->name('admin.institusi.dashboard');
    Route::get('/admin-institusi/ringkasan', [DashboardController::class, 'adminInstitusiRingkasanPesanan'])->name('admin.institusi.ringkasan');
    Route::get('/admin-institusi/institusi', [DashboardController::class, 'adminInstitusiInstitusi'])->name('admin.institusi.institusi');
    Route::get('/admin-institusi/pembekal', [DashboardController::class, 'adminInstitusiPembekal'])->name('admin.institusi.pembekal');
    Route::get('/admin-institusi/senarai-user', [DashboardController::class, 'adminInstitusiSenaraiUser'])->name('admin.institusi.senarai_pengguna');
    Route::get('/admin-institusi/profil', [DashboardController::class, 'adminInstitusiProfil'])->name('admin.institusi.profil');

    Route::get('/dashboard/critical-stock', [DashboardController::class, 'criticalStock'])->name('dashboard.critical-stock');
    Route::get('/dashboard/stock-forecast', [DashboardController::class, 'stockForecast'])->name('dashboard.stock-forecast');
    Route::get('/dashboard/stock-by-category', [DashboardController::class, 'stockByCategory'])->name('dashboard.stock-by-category');

    Route::get('/admin/users', [\App\Http\Controllers\AdminController::class, 'listAdmins'])->name('admin.users');
    Route::post('/admin/register', [\App\Http\Controllers\AdminController::class, 'registerAdmin'])->name('admin.register');
    Route::put('/admin/{admin}', [\App\Http\Controllers\AdminController::class, 'updateAdmin'])->name('admin.update');

    Route::post('/position/store', [\App\Http\Controllers\PositionController::class, 'store'])->name('position.store');

    Route::get('/suppliers', [\App\Http\Controllers\SupplierController::class, 'index'])->name('suppliers.index');
    Route::post('/suppliers', [\App\Http\Controllers\SupplierController::class, 'store'])->name('suppliers.store');
    Route::put('/suppliers/{supplier}', [\App\Http\Controllers\SupplierController::class, 'update'])->name('suppliers.update');

    Route::get('/items/search', [\App\Http\Controllers\ItemController::class, 'search'])->name('items.search');
    Route::post('/items', [\App\Http\Controllers\ItemController::class, 'store'])->name('items.store');

    Route::get('/categories', [\App\Http\Controllers\CategoryController::class, 'index'])->name('categories.index');

    Route::get('/uoms', [\App\Http\Controllers\UomController::class, 'index'])->name('uoms.index');
    Route::post('/uoms', [\App\Http\Controllers\UomController::class, 'store'])->name('uoms.store');
    Route::put('/uoms/{uom}', [\App\Http\Controllers\UomController::class, 'update'])->name('uoms.update');

    // --- User routes (per-position access) ---
    Route::get('/user/dashboard', [DashboardController::class, 'userDashboard'])->name('user.dashboard');

    Route::get('/borang-inden/{order}/cetak-pdf', [DashboardController::class, 'cetakIndenPdf'])->name('borang.inden.cetak')->where('order', '[0-9]+');
    Route::get('/borang-inden/{order}', [DashboardController::class, 'lihatBorangInden'])->name('borang.inden.show')->where('order', '[0-9]+');

    Route::middleware('permission:borang_inden')->group(function () {
        Route::get('/borang-inden', [DashboardController::class, 'borangInden'])->name('borang.inden');
        Route::post('/borang-inden', [DashboardController::class, 'simpanBorangInden'])->name('borang.inden.store');
        Route::get('/borang-inden/generate-number', [DashboardController::class, 'generateOrderNo'])->name('borang.inden.generate');
        Route::get('/borang-inden/contracts', [DashboardController::class, 'getContractsByInstitution'])->name('borang.inden.contracts');
        Route::get('/borang-inden/contract-items/{contract}', [DashboardController::class, 'getContractItems'])->name('borang.inden.contract-items');
    });

    Route::middleware('permission:penerimaan_inden')->group(function () {
        Route::get('/borang-penerimaan', [DashboardController::class, 'borangPenerimaan'])->name('borang.penerimaan');
        Route::get('/borang-penerimaan/{order}/items', [DashboardController::class, 'getPenerimaanItems'])->name('borang.penerimaan.items');
        Route::post('/borang-penerimaan', [DashboardController::class, 'simpanPenerimaan'])->name('borang.penerimaan.store');
    });

    Route::get('/user/senarai-inden', [DashboardController::class, 'senaraiInden'])->name('user.senarai.inden');

    Route::middleware('permission:pengesahan_inden')->group(function () {
        Route::get('/user/pengesahan-inden', [DashboardController::class, 'pengesahanInden'])->name('user.pengesahan.inden');
        Route::post('/user/pengesahan-inden/{order}/sahkan', [DashboardController::class, 'sahkanInden'])->name('user.pengesahan.inden.sahkan');
    });

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
