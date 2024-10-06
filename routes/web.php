<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\ContactController;

// Rota para exibir o formulário de upload
Route::get('/upload', [UploadController::class, 'uploadForm'])->name('upload.form');

// Rota para importar o arquivo CSV
Route::post('/upload-csv', [UploadController::class, 'import'])->name('upload.csv');

// Rota para listar contatos
Route::get('/contatos', [ContactController::class, 'index'])->name('contatos.list');

// Rota para buscar contatos
Route::get('/contatos/search', [ContactController::class, 'search'])->name('contatos.search');
