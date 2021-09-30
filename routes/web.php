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

Route::get('/', 'HomeController@Index')->name('beranda');
Auth::routes();
// Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
    // any route here will only be accessible for logged in users
    //route crud warga
    Route::get('manajemen/data-warga', 'crudWargaController@index')->name('crudWarga');
    Route::post('manajemen/tambahWarga/Post', 'crudWargaController@tambah')->name('tambahWarga');
    Route::get('manajemen/crudwarga/delete/{id}', 'crudWargaController@delete')->name('deleteWarga');
    Route::post('manajemen/crudwarga/update/{id}', 'crudWargaController@update')->name('updateWarga');
    Route::get('manajemen/crudwarga/aktif/{id}', 'crudWargaController@aktif')->name('aktifWarga');
    Route::get('manajemen/crudwarga/export-warga', 'crudWargaController@export')->name('exportWarga');

    // route beranda
    Route::get('manajemen/Edit-beranda', 'berandaController@Index')->name('editBeranda');
    Route::post('manajemen/Edit-beranda/Post', 'berandaController@update')->name('updateBeranda');
    Route::post('manajemen/Edit-beranda/addKerja', 'berandaController@addKerja')->name('addKerja');
    Route::get('manajemen/Edit-beranda/deleteKerja/{id}', 'berandaController@deleteKerja')->name('deleteKerja');
    Route::post('manajemen/Edit-beranda/visi-misi', 'berandaController@updateMs')->name('updateMs');

    //route acara/kegiatan
    Route::get('manajemen/kegiatan', 'beritaController@adminIndex')->name('editAcara');
    Route::get('berita/{slug}', 'beritaController@show')->name('showAcara');
    Route::post('manajemen/kegiatan/post-kegiatan', 'beritaController@post')->name('post');
    Route::get('manajemen/kegiatan/delete/{id}', 'beritaController@destroy')->name('deleteAcara');
    Route::post('manajemen/kegiatan/update/{id}', 'beritaController@update')->name('updateAcara');
    Route::get('manajemen/kegiatan/aktif/{id}', 'beritaController@aktif')->name('aktifAcara');

    //route crud staff
    Route::get('manajemen/staff', 'crudStaffController@adminIndex')->name('staff');
    Route::post('manajemen/staff/tambah', 'crudStaffController@tambah')->name('tambahStaff');
    Route::get('manajemen/staff/delete/{id}', 'crudStaffController@destroy')->name('deleteStaff');
    Route::post('manajemen/staff/update/{id}', 'crudStaffController@update')->name('updateStaff');
    Route::get('manajemen/staff/aktif/{id}', 'crudStaffController@aktif')->name('aktifStaff');

    //route crud user
    Route::get('manajemen/user', 'userController@Index')->name('user');
    Route::get('manajemen/user/update-level/{id}', 'userController@level')->name('levelUser');
    Route::get('manajemen/user/verified/{id}', 'userController@verified')->name('verifiedUser');
    Route::get('manajemen/user/delete/{id}', 'userController@delete')->name('deleteUser');
    Route::get('manajemen/user/reset/{id}', 'userController@reset')->name('resetUser');

    //editprofil
    Route::get('profil', 'userController@profil')->name('profil');
    Route::post('profil/update/{id}', 'userController@passUpdate')->name('updatePass');
    Route::post('profil/taut', 'userController@tautkan')->name('tautkan');

    //editGaleri
    Route::get('manajemen/galeri', 'dropzoneController@index')->name('galeriAdmin');    
    Route::post('manajemen/galeri/upload', 'dropzoneController@upload')->name('dz.upload');
    Route::get('manajemen/galeri/fetch', 'DropzoneController@fetch')->name('dropzone.fetch');
    Route::get('galeri/fetch', 'DropzoneController@fetchGaleri')->name('dz.fetch');
    Route::get('manajemen/galeri/delete', 'DropzoneController@delete')->name('dropzone.delete');

 });

Route::get('staff', 'crudStaffController@index')->name('lihatStaff');
Route::get('berita', 'beritaController@Index')->name('Acara');

//pencarian warga
Route::get('pencarian/warga', 'wargaController@index')->name('cariWarga');
Route::get('pencarian/warga/fetch', 'wargaController@fetch');

Route::get('galeri', 'dropzoneController@galeri')->name('galeri');

 




