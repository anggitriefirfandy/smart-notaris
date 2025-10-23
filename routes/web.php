<?php

use App\Http\Controllers\HasilKerjaController;
use App\Http\Controllers\LembarKerjaController;
use App\Http\Controllers\LogAktivitasController;
use App\Http\Controllers\LogProgresController;
use App\Http\Controllers\Master\BankController;
use App\Http\Controllers\Master\NotarisController;
use App\Http\Controllers\Master\UserBankController;
use App\Http\Controllers\Master\UserNotarisController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\RiwayatDocController;
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
Route::get('/tes', function () {
    return view('admin.dashboard.dashboard_admin');
});
Route::resource('notaris', NotarisController::class)->middleware(['auth']);
Route::resource('user_notaris', UserNotarisController::class)->middleware(['auth']);
Auth::routes();
Route::resource('bank', BankController::class)->middleware(['auth']);
Route::resource('user_bank', UserBankController::class)->middleware(['auth']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('lembar_kerja', LembarKerjaController::class)->middleware(['auth']);
// Route::post('/upload-dokumen/{lembar_kerja}', 'RiwayatDocController@create')->name('upload_dokumen');
Route::get('/upload_dokumen/{id}', [LembarKerjaController::class, 'upload_berkas'])->name('upload_berkas')->middleware('auth');
Route::resource('riwayat_doc', RiwayatDocController::class);
// Route::get('/download_dokumen/{uid}', [RiwayatDocController::class, 'download'])->name('download_dokumen');
Route::resource('log-aktivitas', LogAktivitasController::class)->middleware(['auth']);

Route::get('/download_dokumen', [RiwayatDocController::class, 'download'])->name('download_dokumen');
Route::get('/download_covernote', [LembarKerjaController::class, 'download'])->name('download_covernote');
Route::get('/download_hasil', [HasilKerjaController::class, 'download'])->name('download_hasil');
// Route::get('/dokumen/{filename}', [RiwayatDocController::class, 'download'])->name('download_dokumen');
Route::post('/log-download', [LogAktivitasController::class, 'store'])->name('log_download');
Route::post('/changestatus/{uid}', [LembarKerjaController::class, 'changestatus'])->name('changestatus')->middleware(['auth']);
Route::get('/getjumlahnotaris', [NotarisController::class, 'getjumlahnotaris'])->name('getjumlahnotariss')->middleware(['auth']);
Route::get('/getjumlahlembarkerja', [NotarisController::class, 'getjumlahlembarkerja'])->name('getjumlahlembarkerjas')->middleware(['auth']);
Route::get('/getjumlahbank', [NotarisController::class, 'getjumlahbank'])->name('getjumlahbanks')->middleware(['auth']);
Route::get('/getjumlahselesai', [NotarisController::class, 'getjumlahselesai'])->name('getjumlahselesais')->middleware(['auth']);
Route::get('/getjumlahproses', [NotarisController::class, 'getjumlahproses'])->name('getjumlahprosess')->middleware(['auth']);
Route::get('/getaktivitas/{uid}', [NotarisController::class, 'getaktivitas'])->name('getaktivitass')->middleware(['auth']);
Route::resource('hasil_kerja', HasilKerjaController::class)->middleware(['auth']);
Route::post('/changestatus/{id}', [HasilKerjaController::class, 'changestatus'])->name('changestatus')->middleware(['auth']);
Route::get('/upload_hasil/{id}', [HasilKerjaController::class, 'upload_hasil'])->name('upload_hasil')->middleware('auth');
Route::post('/kerjakan', [LembarKerjaController::class, 'kerjakan'])->name('kerjakan')->middleware(['auth']);
Route::get('/tambah_kerjakan/{id}', [LembarKerjaController::class, 'tambah_kerjakan'])->name('tambah_kerjakan')->middleware(['auth']);
Route::get('/getnotif', [LembarKerjaController::class, 'getnotif'])->name('getnotifs')->middleware(['auth']);
Route::get('/tambah_log_progres/{id}', [LogProgresController::class, 'tambah_log_progres'])->name('tambah_log_progres')->middleware('auth');
Route::post('/log_progres', [LogProgresController::class, 'log_progres'])->name('log_progres')->middleware('auth');
Route::resource('show-log-progres', LogProgresController::class)->middleware(['auth']);
Route::get('/getjumlahuangselesai', [NotarisController::class, 'getjumlahuangselesai'])->name('getjumlahuangselesais')->middleware(['auth']);
Route::post('/changestatusselesai/{uid}', [LembarKerjaController::class, 'changestatusselesai'])->name('changestatusselesai')->middleware(['auth']);
Route::get('/getgrafiklembarkerja', [NotarisController::class, 'getgrafiklembarkerja'])->name('getgrafiklembarkerjas')->middleware(['auth']);
Route::get('/gettotallembarbulan', [NotarisController::class, 'gettotallembarbulan'])->name('gettotallembarbulans')->middleware(['auth']);
Route::post('/update-status', [LembarKerjaController::class, 'updateStatus']);
Route::post('/cutoff', [LembarKerjaController::class, 'cutoff'])->name('lembar_kerja.cutoff');
Route::get('/profil', [ProfilController::class, 'edit'])->name('profil.edit')->middleware('auth');
Route::put('/profil', [ProfilController::class, 'update'])->name('profil.update')->middleware('auth');
Route::get('/getjumlahuangselesaibank', [BankController::class, 'getjumlahuangselesaibank'])->name('getjumlahuangselesaibanks')->middleware(['auth']);
Route::get('/getpiegrafik', [BankController::class, 'getpiegrafik'])->name('getpiegrafiks')->middleware(['auth']);
