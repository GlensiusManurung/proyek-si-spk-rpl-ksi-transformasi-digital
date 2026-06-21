<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/about', function () {
    return view('about');
})->name('about');

//ini untuk halaman login dan logout akun//
Route::get('/login',[LoginController::class,'index'])->name('login');

Route::post('/login',[LoginController::class,'login'])->name('login.process');

Route::post('/logout',[LoginController::class,'logout'])->name('logout');


//ini untuk login ke halaman superadmin//
use App\Http\Controllers\SuperAdminController;
Route::get('/superadmin/dashboard',[SuperAdminController::class,'index'])
->name('superadmin.dashboard');

//ini untuk halaman Daftar akun//
use App\Http\Controllers\RegisterController;
Route::get('/daftar', [RegisterController::class, 'index'])->name('daftar');
Route::post('/daftar', [RegisterController::class, 'store'])->name('daftar.store');

//untuk akun google daftar dan login//
use App\Http\Controllers\GoogleAuthController;
Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('google.callback');


//ini buat halaman lupa password atau forgot password serta yg lainnya buat lupa password//
use App\Http\Controllers\ForgotPasswordController;
Route::get('/lupa-password', [ForgotPasswordController::class, 'showForgotForm'])->name('password.request');
Route::post('/lupa-password', [ForgotPasswordController::class, 'sendResetLink'])->name('password.send');
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset.form');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.reset.process');


//buat profile superadmin//
use App\Http\Controllers\ProfileController;
// Route Superadmin Profile
Route::middleware(['auth'])->prefix('superadmin')->group(function () {
    Route::get('/profile', [ProfileController::class, 'superadminProfile'])->name('superadmin.profile');
    Route::post('/profile/update', [ProfileController::class, 'superadminUpdate'])->name('superadmin.profile.update');
    Route::post('/profile/change-password', [ProfileController::class, 'superadminChangePassword'])->name('superadmin.profile.change-password');
    Route::delete('/profile/delete-photo', [ProfileController::class, 'superadminDeletePhoto'])->name('superadmin.profile.delete-photo');
});

// Route Admin Profile
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/profile', [ProfileController::class, 'adminProfile'])->name('admin.profile');
    Route::post('/profile/update', [ProfileController::class, 'adminUpdate'])->name('admin.profile.update');
    Route::post('/profile/change-password', [ProfileController::class, 'adminChangePassword'])->name('admin.profile.change-password');
    Route::delete('/profile/delete-photo', [ProfileController::class, 'adminDeletePhoto'])->name('admin.profile.delete-photo');
});

// Route Driver Profile
Route::middleware(['auth'])->prefix('driver')->group(function () {
    Route::get('/profile', [ProfileController::class, 'driverProfile'])->name('driver.profile');
    Route::post('/profile/update', [ProfileController::class, 'driverUpdate'])->name('driver.profile.update');
    Route::post('/profile/change-password', [ProfileController::class, 'driverChangePassword'])->name('driver.profile.change-password');
    Route::delete('/profile/delete-photo', [ProfileController::class, 'driverDeletePhoto'])->name('driver.profile.delete-photo');
});




// Route Superadmin
Route::middleware(['auth'])->group(function () {
    Route::get('/superadmin/dashboard', [SuperAdminController::class, 'index'])->name('superadmin.dashboard');
    Route::get('/superadmin/users', [SuperAdminController::class, 'users'])->name('superadmin.users');
    Route::get('/superadmin/create-akun', [SuperAdminController::class, 'createAkun'])->name('superadmin.create-akun');
    Route::post('/superadmin/store-akun', [SuperAdminController::class, 'storeAkun'])->name('superadmin.store-akun');
    Route::get('/superadmin/edit-akun/{id}', [SuperAdminController::class, 'editAkun'])->name('superadmin.edit-akun');
    Route::put('/superadmin/update-akun/{id}', [SuperAdminController::class, 'updateAkun'])->name('superadmin.update-akun');
    Route::delete('/superadmin/delete-akun/{id}', [SuperAdminController::class, 'deleteAkun'])->name('superadmin.delete-akun');
});


use App\Http\Controllers\AdminController;
// Route Admin
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});


use App\Http\Controllers\DriverController;
// Route Driver
Route::middleware(['auth'])->group(function () {
    Route::get('/driver/dashboard', [DriverController::class, 'dashboard'])->name('driver.dashboard');
});




use App\Http\Controllers\ChatController;

// Route Chat (Semua role)
Route::middleware(['auth'])->group(function () {
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/messages/{userId}', [ChatController::class, 'getMessages']);
    Route::post('/chat/send', [ChatController::class, 'sendMessage']);
    Route::get('/chat/unread-count', [ChatController::class, 'getUnreadCount']);
    Route::get('/chat/online-users', [ChatController::class, 'onlineUsers']);
    Route::post('/chat/update-last-seen', [ChatController::class, 'updateLastSeen']);
});
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/chat', [ChatController::class, 'index'])->name('admin.chat');
});
Route::middleware(['auth'])->post('/chat/update-last-seen', [ChatController::class, 'updateLastSeen']);
Route::post('/chat/update-online-status', [ChatController::class, 'updateOnlineStatus']);
Route::middleware(['auth'])->group(function () {
    Route::post('/chat/mark-all-as-read', [ChatController::class, 'markAllAsRead']);
});


// Route Admin Users Management
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
    Route::post('/users/store', [AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::get('/users/edit/{id}', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::put('/users/update/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/users/delete/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
});

use App\Http\Controllers\DataDriverController;
// Route Data Driver (Admin only)
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/data-driver', [DataDriverController::class, 'index'])->name('admin.drivers.index');
    Route::get('/data-driver/create', [DataDriverController::class, 'create'])->name('admin.drivers.create');
    Route::post('/data-driver/store', [DataDriverController::class, 'store'])->name('admin.drivers.store');
    Route::get('/data-driver/edit/{id}', [DataDriverController::class, 'edit'])->name('admin.drivers.edit');
    Route::put('/data-driver/update/{id}', [DataDriverController::class, 'update'])->name('admin.drivers.update');
    Route::delete('/data-driver/delete/{id}', [DataDriverController::class, 'destroy'])->name('admin.drivers.delete');
    Route::get('/data-driver/show/{id}', [DataDriverController::class, 'show'])->name('admin.drivers.show');
});


use App\Http\Controllers\DataMobilController;

// Data Mobil
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/data-mobil', [DataMobilController::class, 'index'])->name('admin.mobils.index');
    Route::get('/data-mobil/create', [DataMobilController::class, 'create'])->name('admin.mobils.create');
    Route::post('/data-mobil/store', [DataMobilController::class, 'store'])->name('admin.mobils.store');
    Route::get('/data-mobil/edit/{id}', [DataMobilController::class, 'edit'])->name('admin.mobils.edit');
    Route::put('/data-mobil/update/{id}', [DataMobilController::class, 'update'])->name('admin.mobils.update');
    Route::delete('/data-mobil/delete/{id}', [DataMobilController::class, 'destroy'])->name('admin.mobils.delete');
});


use App\Http\Controllers\DataCustomerController;

// Data Customer (Admin only)
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/data-customer', [DataCustomerController::class, 'index'])->name('admin.customers.index');
    Route::get('/data-customer/create', [DataCustomerController::class, 'create'])->name('admin.customers.create');
    Route::post('/data-customer/store', [DataCustomerController::class, 'store'])->name('admin.customers.store');
    Route::get('/data-customer/edit/{id}', [DataCustomerController::class, 'edit'])->name('admin.customers.edit');
    Route::put('/data-customer/update/{id}', [DataCustomerController::class, 'update'])->name('admin.customers.update');
    Route::delete('/data-customer/delete/{id}', [DataCustomerController::class, 'destroy'])->name('admin.customers.delete');
    Route::get('/data-customer/show/{id}', [DataCustomerController::class, 'show'])->name('admin.customers.show');
});

use App\Http\Controllers\PengajuanController;
// Pengajuan (Admin only)
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/pengajuan', [PengajuanController::class, 'index'])->name('admin.pengajuans.index');
    Route::get('/pengajuan/create', [PengajuanController::class, 'create'])->name('admin.pengajuans.create');
    Route::post('/pengajuan/store', [PengajuanController::class, 'store'])->name('admin.pengajuans.store');
    Route::get('/pengajuan/edit/{id}', [PengajuanController::class, 'edit'])->name('admin.pengajuans.edit');
    Route::put('/pengajuan/update/{id}', [PengajuanController::class, 'update'])->name('admin.pengajuans.update');
    Route::delete('/pengajuan/delete/{id}', [PengajuanController::class, 'destroy'])->name('admin.pengajuans.delete');
    Route::post('/pengajuan/approve/{id}', [PengajuanController::class, 'approve'])->name('admin.pengajuans.approve');
    Route::post('/pengajuan/reject/{id}', [PengajuanController::class, 'reject'])->name('admin.pengajuans.reject');
});


use App\Http\Controllers\PengirimanController;
// Pengiriman (Admin only)
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/pengiriman', [PengirimanController::class, 'index'])->name('admin.pengirimans.index');
    Route::get('/pengiriman/create', [PengirimanController::class, 'create'])->name('admin.pengirimans.create');
    Route::post('/pengiriman/store', [PengirimanController::class, 'store'])->name('admin.pengirimans.store');
    Route::get('/pengiriman/edit/{id}', [PengirimanController::class, 'edit'])->name('admin.pengirimans.edit');
    Route::put('/pengiriman/update/{id}', [PengirimanController::class, 'update'])->name('admin.pengirimans.update');
    Route::delete('/pengiriman/delete/{id}', [PengirimanController::class, 'destroy'])->name('admin.pengirimans.delete');
    Route::post('/pengiriman/update-status/{id}', [PengirimanController::class, 'updateStatus'])->name('admin.pengirimans.update-status');
});


use App\Http\Controllers\BuktiPengirimanController;
// Bukti Pengiriman (Driver)
Route::middleware(['auth'])->prefix('driver')->group(function () {
    Route::get('/bukti-pengiriman', [BuktiPengirimanController::class, 'driverIndex'])->name('driver.bukti-pengiriman.index');
    Route::get('/bukti-pengiriman/create/{pengiriman_id}', [BuktiPengirimanController::class, 'driverCreate'])->name('driver.bukti-pengiriman.create');
    Route::post('/bukti-pengiriman/store/{pengiriman_id}', [BuktiPengirimanController::class, 'driverStore'])->name('driver.bukti-pengiriman.store');
});
// Bukti Pengiriman (Admin)
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/bukti-pengiriman', [BuktiPengirimanController::class, 'adminIndex'])->name('admin.bukti-pengiriman.index');
    Route::get('/bukti-pengiriman/show/{id}', [BuktiPengirimanController::class, 'show'])->name('admin.bukti-pengiriman.show');
    Route::delete('/bukti-pengiriman/delete/{id}', [BuktiPengirimanController::class, 'destroy'])->name('admin.bukti-pengiriman.delete');
});

// Route untuk Driver
Route::middleware(['auth'])->prefix('driver')->group(function () {
    Route::get('/dashboard', [DriverController::class, 'dashboard'])->name('driver.dashboard');
    
    // ========== TAMBAHKAN ROUTE INI ==========
    Route::get('/pengiriman-saya', [DriverController::class, 'pengirimanSaya'])->name('driver.pengiriman-saya');
    Route::get('/pengiriman-saya/{id}', [DriverController::class, 'detailPengiriman'])->name('driver.pengiriman-saya.detail');
});



// Driver update status pengiriman
Route::middleware(['auth'])->prefix('driver')->group(function () {
    Route::post('/pengiriman/update-status/{id}', [DriverController::class, 'updateStatusPengiriman'])
         ->name('driver.pengiriman.update-status');
});


// Riwayat Pengiriman
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/riwayat-pengiriman', [PengirimanController::class, 'riwayat'])->name('admin.riwayat-pengiriman');
});

Route::middleware(['auth'])->prefix('driver')->group(function () {
    Route::get('/riwayat-pengiriman', [DriverController::class, 'riwayatPengiriman'])->name('driver.riwayat-pengiriman');
});


//ROUTE UNTUK SET OFFLINE SAAT TUTUP BROWSER//
Route::post('/set-offline', function () {
    if (Auth::check()) {
        Auth::user()->update(['is_online' => false]);
    }
    return response()->json(['success' => true]);
})->middleware('auth');




// Route Export Data Driver
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/drivers/export-excel', [DataDriverController::class, 'exportExcel'])->name('admin.drivers.export-excel');
    Route::get('/drivers/export-pdf', [DataDriverController::class, 'exportPdf'])->name('admin.drivers.export-pdf');
    Route::get('/drivers/export-word', [DataDriverController::class, 'exportWord'])->name('admin.drivers.export-word');
});


// Export Data Mobil
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/mobils/export-excel', [DataMobilController::class, 'exportExcel'])->name('admin.mobils.export-excel');
    Route::get('/mobils/export-pdf', [DataMobilController::class, 'exportPdf'])->name('admin.mobils.export-pdf');
    Route::get('/mobils/export-word', [DataMobilController::class, 'exportWord'])->name('admin.mobils.export-word');
});

// Export Data Pengiriman
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/pengirimans/export-excel', [PengirimanController::class, 'exportExcel'])->name('admin.pengirimans.export-excel');
    Route::get('/pengirimans/export-pdf', [PengirimanController::class, 'exportPdf'])->name('admin.pengirimans.export-pdf');
    Route::get('/pengirimans/export-word', [PengirimanController::class, 'exportWord'])->name('admin.pengirimans.export-word');
});

use App\Http\Controllers\SAWController;

Route::middleware(['auth'])->prefix('admin')->group(function () {
    // Kriteria
    Route::get('/saw/kriteria', [SAWController::class, 'kriteriaIndex'])->name('admin.saw.kriteria');
    Route::post('/saw/kriteria', [SAWController::class, 'kriteriaStore'])->name('admin.saw.kriteria.store');
    Route::put('/saw/kriteria/{id}', [SAWController::class, 'kriteriaUpdate'])->name('admin.saw.kriteria.update');
    Route::delete('/saw/kriteria/{id}', [SAWController::class, 'kriteriaDestroy'])->name('admin.saw.kriteria.delete');
    
    // Penilaian
    Route::get('/saw/penilaian', [SAWController::class, 'penilaianIndex'])->name('admin.saw.penilaian');
    Route::post('/saw/penilaian', [SAWController::class, 'penilaianStore'])->name('admin.saw.penilaian.store');
    
    // Ranking
    Route::get('/saw/ranking', [SAWController::class, 'hitungRanking'])->name('admin.saw.ranking');
});



Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/saw/penilaian', [SAWController::class, 'penilaianIndex'])->name('admin.saw.penilaian');
    Route::post('/saw/penilaian', [SAWController::class, 'simpanPenilaian'])->name('admin.saw.penilaian.store');
    Route::get('/saw/ranking', [SAWController::class, 'hitungRanking'])->name('admin.saw.ranking');
});


    Route::middleware(['auth'])->prefix('admin')->group(function () {
    // Kriteria (CRUD Lengkap)
    Route::get('/saw/kriteria', [SAWController::class, 'kriteriaIndex'])->name('admin.saw.kriteria');
    Route::get('/saw/kriteria/create', [SAWController::class, 'kriteriaCreate'])->name('admin.saw.kriteria.create');
    Route::post('/saw/kriteria', [SAWController::class, 'kriteriaStore'])->name('admin.saw.kriteria.store');
    Route::get('/saw/kriteria/edit/{id}', [SAWController::class, 'kriteriaEdit'])->name('admin.saw.kriteria.edit');
    Route::put('/saw/kriteria/{id}', [SAWController::class, 'kriteriaUpdate'])->name('admin.saw.kriteria.update');
    Route::delete('/saw/kriteria/{id}', [SAWController::class, 'kriteriaDestroy'])->name('admin.saw.kriteria.delete');
});
   

use App\Http\Controllers\NotificationController;

// Admin & Superadmin routes
Route::middleware(['auth', 'role:admin,superadmin'])->prefix('admin')->group(function () {
    Route::get('/notifications', [NotificationController::class, 'indexPage'])->name('admin.notifications');
});

// Driver routes
Route::middleware(['auth', 'role:driver'])->prefix('driver')->group(function () {
    Route::get('/notifications', [NotificationController::class, 'indexPage'])->name('driver.notifications');
});





// ==================== NOTIFICATION ROUTES (via web) ====================
Route::middleware('auth')->group(function () {
    Route::get('/api/notifications', [NotificationController::class, 'index']);
    Route::get('/api/notifications/all', [NotificationController::class, 'all']);
    Route::get('/api/notifications/new', [NotificationController::class, 'newNotifications']);
    Route::post('/api/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
    Route::post('/api/notifications/mark-all-read', [NotificationController::class, 'markAllRead']);
     Route::delete('/api/notifications', [NotificationController::class, 'destroy']);
    Route::delete('/api/notifications/all', [NotificationController::class, 'destroyAll']);
});


