<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;

Route::get('/', function () {
    return view('welcome');
});

// Route untuk ganti bahasa
Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'id'])) {
        Session::put('locale', $locale); // Simpan pilihan di Session
    }
    return redirect()->back(); // Kembali ke halaman sebelumnya
});
