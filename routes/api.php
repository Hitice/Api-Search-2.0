<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\ContactApiController;

Route::get('/contatos', [ContactApiController::class, 'index']);
Route::get('/contatos/campanha/{campanha}', [ContactApiController::class, 'filterByCampaign']);
