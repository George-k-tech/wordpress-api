<?php

use App\Http\Controllers\Commands\ManageStoreEntryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('customer-details', [ManageStoreEntryController::class, 'addCustomer']);
Route::post("payment-details/{customerId}", [ManageStoreEntryController::class, 'addPayment']);
Route::post("order-details/{customerId}", [ManageStoreEntryController::class, 'addOrder']);
Route::get("customer-details/{customerId}", [ManageStoreEntryController::class, 'getCustomer']);
Route::get("payment-details/{id}", [ManageStoreEntryController::class, 'getPayment']);
Route::get("order-details/{id}", [ManageStoreEntryController::class, 'getOrder']);
