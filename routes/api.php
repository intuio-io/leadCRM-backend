<?php

use App\Http\Controllers\Api\AttributeController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BuyerController;
use App\Http\Controllers\Api\CampaignController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\FilterController;
use App\Http\Controllers\Api\LeadController;
use App\Http\Controllers\Api\SupplierController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::middleware('auth:api')->group(function () {
    
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/refresh', [AuthController::class, 'refresh']);
    
    
    Route::get('/clients', [ClientController::class, 'showClients']);
    Route::post('/create/client', [ClientController::class, 'addClient']);
    Route::delete('/delete/client/{id}', [ClientController::class, 'delClient']);
    Route::patch('/edit/client', [ClientController::class, 'editClient']);

    Route::get('/campaigns', [CampaignController::class, 'showCampaigns']);
    Route::post('/create/campaign', [CampaignController::class, 'addCampaign']);
    Route::delete('/delete/campaign/{id}', [CampaignController::class, 'delCampaign']);
    Route::patch('/edit/campaign', [CampaignController::class, 'editCampaign']);
    Route::get('/campaign/details/{id}', [CampaignController::class, 'campaignDetail'])->whereNumber(['id']);
    
    Route::get('/campaign/suppliers/{campaign:id}', [SupplierController::class, 'showSuppliers']);
    Route::post('/add/supplier', [SupplierController::class, 'addSupplier']);
    Route::patch('/edit/supplier', [SupplierController::class, 'editSupplier']);
    Route::delete('/delete/supplier/{id}', [SupplierController::class, 'deleteSupplier']);
    Route::get('/supplier/detail/{campaignId}/{supplierId}', [SupplierController::class, 'supplierDetail'])->whereNumber(['campaignId','supplierId']);
    
    Route::get('/campaign/buyers/{campaign:id}', [BuyerController::class, 'showBuyers']);
    Route::post('/add/buyer', [BuyerController::class, 'addBuyer']);
    Route::patch('/edit/buyer', [BuyerController::class, 'editBuyer']);
    Route::delete('/delete/buyer/{id}', [BuyerController::class, 'deleteBuyer']);
    Route::get('/buyer/detail/{campaignId}/{buyerId}', [BuyerController::class, 'buyerDetail'])->whereNumber(['campaignId','buyerId']);


    Route::get('/campaign/attributes/{campaign:id}', [AttributeController::class, 'showAttributes']);
    Route::post('/add/attribute', [AttributeController::class, 'addAttribute']);
    Route::patch('/edit/attribute', [AttributeController::class, 'editAttribute']);
    Route::delete('/delete/attribute/{id}', [AttributeController::class, 'deleteAttribute']);
    Route::post('/reset/attributes/{id}', [CampaignController::class, 'resetAttributes']);



    Route::get('/campaign/filters/{campaign:id}', [FilterController::class, 'showFilters']);
    Route::post('/add/filter', [FilterController::class, 'addFilter']);
    Route::patch('/edit/filter', [FilterController::class, 'editFilter']);
    Route::delete('/delete/filter/{id}', [FilterController::class, 'deleteFilter']);


    Route::get('/leads/{campaign:id}', [LeadController::class, 'showLeads']);


    
    Route::post('/ingest', [LeadController::class, 'addLead']);

    Route::post('/logout', [AuthController::class, 'logout']);
});




Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login']);