<?php

use App\Http\Controllers\Commands\ManageStoreEntryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('addCustomer', [ManageStoreEntryController::class, 'addCustomer']);
