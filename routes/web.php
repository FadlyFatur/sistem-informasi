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

Route::group(['middleware' => 'auth', 'admin'], function () {
    // any route here will only be accessible for logged in users

    Route::prefix('admin')->group(function () {
        Route::prefix('/data-warga')->group(function () {
            //route crud warga
            Route::post('/add', 'crudWargaController@tambah')->name('tambahWarga');
            Route::post('/update/{id}/post', 'crudWargaController@update')->name('updateWarga');
            Route::get('/', 'crudWargaController@index')->name('crudWarga')->middleware('akunVerified');
            Route::get('/update/{id}', 'crudWargaController@updateIndex')->name('upWarga')->middleware('akunVerified');
            Route::get('/delete/{id}', 'crudWargaController@delete')->name('deleteWarga');
            Route::get('/aktif/{id}', 'crudWargaController@aktif')->name('aktifWarga');
            Route::get('/export-warga', 'crudWargaController@export')->name('exportWarga');
            Route::get('/get-data-warga', 'crudWargaController@getData')->name('getWarga');
        });

        Route::prefix('/data-staff')->group(function () {
            //route crud staff
            Route::post('/add', 'crudStaffController@tambah')->name('tambahStaff');
            Route::post('/update/{id}/post', 'crudStaffController@update')->name('updateStaff');
            Route::get('/', 'crudStaffController@adminIndex')->name('staff')->middleware('akunVerified');
            Route::get('/update/{id}', 'crudStaffController@updateIndex')->name('upStaff')->middleware('akunVerified');
            Route::get('/delete/{id}', 'crudStaffController@destroy')->name('deleteStaff');
            Route::get('/aktif/{id}', 'crudStaffController@aktif')->name('aktifStaff');
            Route::get('/get-data-staff', 'crudStaffController@getData')->name('getStaff');
        });

        Route::prefix('/data-acara')->group(function () {
            //route acara/kegiatan
            Route::post('/add', 'beritaController@post')->name('post');
            Route::post('/update/{id}/post', 'beritaController@update')->name('updateAcara');
            Route::get('/', 'beritaController@adminIndex')->name('editAcara')->middleware('akunVerified');
            Route::get('/update/{id}', 'beritaController@updateIndex')->name('upAcara')->middleware('akunVerified');
            Route::get('/delete/{id}', 'beritaController@destroy')->name('deleteAcara');
            Route::get('/aktif/{id}', 'beritaController@aktif')->name('aktifAcara');
            Route::get('/get-data-acara', 'beritaController@getData')->name('getAcara');
        });

        Route::prefix('/data-beranda')->group(function () {
            // route beranda
            Route::post('/update', 'berandaController@update')->name('updateBeranda');
            // Route::post('/addKerja', 'berandaController@addKerja')->name('addKerja');
            Route::post('/update-visi-misi', 'berandaController@updateMs')->name('updateMs');
            Route::post('/update-thumbnail', 'berandaController@storeGambar')->name('updateThumb');
            Route::get('/', 'berandaController@index')->name('editBeranda')->middleware('akunVerified');
            // Route::get('/deleteKerja/{id}', 'berandaController@deleteKerja')->name('deleteKerja');
        });

        Route::prefix('/data-user')->group(function () {
            //route crud user
            Route::get('/', 'userController@Index')->name('user')->middleware('akunVerified');
            Route::get('/update-level/{id}', 'userController@level')->name('levelUser');
            Route::get('/verified/{id}', 'userController@verified')->name('verifiedUser');
            Route::get('/delete/{id}', 'userController@delete')->name('deleteUser');
            Route::get('/reset/{id}', 'userController@reset')->name('resetUser');
        });

        Route::prefix('/galeri')->group(function () {
            //editGaleri
            Route::post('/upload', 'dropzoneController@upload')->name('dz.upload');
            Route::get('/', 'dropzoneController@index')->name('galeriAdmin')->middleware('akunVerified');
            Route::get('/fetch', 'dropzoneController@fetch')->name('dropzone.fetch');
            Route::get('/delete', 'dropzoneController@delete')->name('dropzone.delete');
        });

        Route::prefix('/data-pilihan')->group(function () {
            // route beranda
            Route::post('/add-Kerja', 'berandaController@addKerja')->name('addKerja');
            Route::post('/add-Jabatan', 'berandaController@addJabatan')->name('addJabatan');
            Route::get('/', 'berandaController@indexPilihan')->name('pilihan')->middleware('akunVerified');
            Route::get('/delete-Kerja/{id}', 'berandaController@deleteKerja')->name('deleteKerja');
            Route::get('/delete-Jabatan/{id}', 'berandaController@deleteJabatan')->name('deleteJabatan');
            Route::get('/get-data-kerja', 'berandaController@getData')->name('getKerja');
            Route::get('/get-data-jabatan', 'berandaController@getDataJabatan')->name('getJabatan');
        });
    });
});

Route::prefix('/profil')->group(function () {
    //editprofil
    Route::post('/update/{id}', 'userController@passUpdate')->name('updatePass');
    Route::post('/taut', 'userController@tautkan')->name('tautkan');
    Route::get('/', 'userController@profil')->name('profil');
});

Route::get('staff', 'crudStaffController@index')->name('list-Staff');
Route::get('kegiatan', 'beritaController@index')->name('list-kegiatan');
Route::get('kegiatan/{slug}', 'beritaController@show')->name('show-kegiatan');

//pencarian warga
Route::get('pencarian/warga', 'wargaController@index')->name('cariWarga');
Route::get('pencarian/warga/fetch', 'wargaController@fetch');

Route::get('galeri', 'dropzoneController@galeri')->name('galeri');

Route::get('/', 'HomeController@Index')->name('beranda');
