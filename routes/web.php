<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();
// Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['auth', 'staffAccess', 'akunVerified'])->group(function () {
    // any route here will only be accessible for logged in users

    Route::prefix('admin')->group(function () {
        Route::prefix('/data-warga')->group(function () {
            //route crud warga
            Route::post('/add', 'crudWargaController@tambah')->name('tambahWarga');
            Route::post('/update/{id}/post', 'crudWargaController@update')->name('updateWarga');
            Route::get('/', 'crudWargaController@index')->name('crudWarga');
            Route::get('/update/{id}', 'crudWargaController@updateIndex')->name('upWarga');
            Route::get('/delete/{id}', 'crudWargaController@delete')->name('deleteWarga');
            Route::get('/aktif/{id}', 'crudWargaController@aktif')->name('aktifWarga');
            Route::get('/export-warga', 'crudWargaController@export')->name('exportWarga');
            Route::get('/get-data-warga', 'crudWargaController@getData')->name('getWarga');
        });

        Route::prefix('/data-staff')->group(function () {
            //route crud staff
            Route::post('/add', 'crudStaffController@tambah')->name('tambahStaff');
            Route::post('/update/{id}/post', 'crudStaffController@update')->name('updateStaff');
            Route::get('/', 'crudStaffController@adminIndex')->name('staff')->middleware('staffAccess');
            Route::get('/update/{id}', 'crudStaffController@updateIndex')->name('upStaff');
            Route::get('/delete/{id}', 'crudStaffController@destroy')->name('deleteStaff');
            Route::get('/aktif/{id}', 'crudStaffController@aktif')->name('aktifStaff');
            Route::get('/get-data-staff', 'crudStaffController@getData')->name('getStaff');
            Route::get('/export', 'crudStaffController@export')->name('exportStaff');
        });

        Route::prefix('/data-acara')->group(function () {
            //route acara/kegiatan
            Route::post('/add', 'beritaController@post')->name('post');
            Route::post('/update/{id}/post', 'beritaController@update')->name('updateAcara');
            Route::get('/', 'beritaController@adminIndex')->name('editAcara')->middleware('staffAccess');
            Route::get('/update/{id}', 'beritaController@updateIndex')->name('upAcara');
            Route::get('/delete/{id}', 'beritaController@destroy')->name('deleteAcara');
            Route::get('/aktif/{id}', 'beritaController@aktif')->name('aktifAcara');
            Route::get('/get-data-acara', 'beritaController@getData')->name('getAcara');
        });

        Route::prefix('/data-aspirasi')->group(function () {
            // route beranda
            Route::post('/delete-aspirasi/{id}', 'beritaController@deleteAspirasi')->name('deleteAspirasi');
            Route::get('/accept/{id}', 'beritaController@accAspirasi')->name('accAspirasi');
            Route::get('/reject/{id}', 'beritaController@rejectAspirasi')->name('rejectAspirasi');
            Route::get('/', 'beritaController@indexAspirasiAdmin')->name('aspi-admin')->middleware('staffAccess');
            Route::get('/get-data-aspirasi', 'beritaController@getDataAspirasi')->name('getAspirasi');
            Route::get('/export', 'beritaController@exportAsp')->name('exportAspirasi');
        });

        Route::prefix('/galeri')->group(function () {
            //editGaleri
            Route::post('/upload', 'dropzoneController@upload')->name('dz.upload');
            Route::get('/', 'dropzoneController@index')->name('galeriAdmin')->middleware('staffAccess');
            Route::get('/fetch', 'dropzoneController@fetch')->name('dropzone.fetch');
            Route::get('/delete', 'dropzoneController@delete')->name('dropzone.delete');
        });

        Route::middleware(['admin'])->group(function () {

            Route::prefix('/data-user')->group(function () {
                //route crud user
                Route::get('/', 'userController@Index')->name('user');
                Route::get('/update-level/{id}', 'userController@level')->name('levelUser');
                Route::get('/verified/{id}', 'userController@verified')->name('verifiedUser');
                Route::get('/delete/{id}', 'userController@delete')->name('deleteUser');
                Route::get('/reset/{id}', 'userController@reset')->name('resetUser');
                Route::get('/re-integrasi/{id}', 'userController@reIntegrasi')->name('reIntegrasi');
                Route::get('/user/export/', 'userController@export')->name('export-user');
            });

            Route::prefix('/data-pilihan')->group(function () {
                // route beranda
                Route::post('/add-Kerja', 'berandaController@addKerja')->name('addKerja');
                Route::post('/add-Jabatan', 'berandaController@addJabatan')->name('addJabatan');

                Route::get('/', 'berandaController@indexPilihan')->name('pilihan');
                Route::get('/delete-Kerja/{id}', 'berandaController@deleteKerja')->name('deleteKerja');
                Route::get('/delete-Jabatan/{id}', 'berandaController@deleteJabatan')->name('deleteJabatan');
                Route::get('/get-data-kerja', 'berandaController@getData')->name('getKerja');
                Route::get('/get-data-jabatan', 'berandaController@getDataJabatan')->name('getJabatan');
            });

            Route::prefix('/data-beranda')->group(function () {
                // route beranda
                Route::post('/update', 'berandaController@update')->name('updateBeranda');
                // Route::post('/addKerja', 'berandaController@addKerja')->name('addKerja');
                // Route::post('/update-visi-misi', 'berandaController@updateMs')->name('updateMs');
                Route::post('/update-thumbnail', 'berandaController@storeGambar')->name('updateThumb');
                Route::get('/', 'berandaController@index')->name('editBeranda');
                // Route::get('/deleteKerja/{id}', 'berandaController@deleteKerja')->name('deleteKerja');
            });
        });
    });
});

Route::prefix('/profil')->group(function () {
    //editprofil
    Route::post('/update/{id}', 'userController@passUpdate')->name('updatePass');
    Route::post('/taut', 'userController@tautkan')->name('tautkan');
    Route::post('/hapus-akun/{id}', 'userController@deleteAkun')->name('deleteAkun');
    Route::get('/', 'userController@profil')->name('profil');
});

Route::get('staff', 'crudStaffController@index')->name('list-Staff');
Route::get('kegiatan', 'beritaController@index')->name('list-kegiatan');
Route::get('kegiatan/{slug}', 'beritaController@show')->name('show-kegiatan');

//pencarian warga
Route::get('pencarian/warga', 'wargaController@index')->name('cariWarga');
Route::get('pencarian/warga/fetch', 'wargaController@fetch');

Route::get('aspirasi', 'beritaController@indexAspirasi')->name('aspirasi');
Route::post('aspirasi/post', 'beritaController@postAspirasi')->name('post-aspirasi');

Route::get('galeri', 'dropzoneController@galeri')->name('galeri');

Route::get('/', 'HomeController@Index')->name('beranda');
