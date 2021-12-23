<?php

use App\Http\Controllers\Api\AgentController;
use App\Http\Controllers\Api\DataController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\PlanholderController;
use App\Http\Controllers\Api\BeneficiaryController;
use App\Http\Controllers\Api\CollectController;

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

Route::post("register", [UserController::class, "register"]);
Route::post("login", [UserController::class, "login"]);
Route::get("get-agents-name", [AgentController::class, "getAgentsName"]);

Route::group(["middleware" => ["auth:api"]], function(){
    Route::get("profile", [UserController::class, "profile"]);
    Route::get("logout", [UserController::class, "logout"]);

    // agents api routes


    // planholder api routes
    Route::post("add-planholder", [PlanholderController::class, "addPlanholder"]);
    Route::get("get-planholder", [PlanholderController::class, "getPlanholder"]);
    Route::get("get-single-planholder/{id}", [PlanholderController::class, "getSinglePlanholder"]);
    Route::put("update-planholder/{id}", [PlanholderController::class, "updatePlanholder"]);
    Route::delete("delete-planholder/{id}", [PlanholderController::class, "deletePlanholder"]);

    // data api routes
    Route::post("add-data", [DataController::class, "addData"]);
    Route::get("get-data/{id}", [DataController::class, "getData"]);
    Route::get("get-single-data/{id}", [DataController::class, "getSingleData"]);
    Route::put("update-data/{id}", [DataController::class, "updateData"]);

    // beneficiary api routes
    Route::post("add-beneficiary", [BeneficiaryController::class, "addBeneficiary"]);
    Route::get("get-beneficiaries/{id}", [BeneficiaryController::class, "getBeneficiaries"]);
    Route::get("get-beneficiary/{id}", [BeneficiaryController::class, "getBeneficiary"]);
    Route::put("update-beneficiary/{id}", [BeneficiaryController::class, "updateBeneficiary"]);
    Route::delete("delete-beneficiary/{id}", [BeneficiaryController::class, "deleteBeneficiary"]);

    // collects api routes
    Route::post("add-collect", [CollectController::class, "addCollect"]);
    Route::get("get-collects/", [CollectController::class, "getCollects"]);
    Route::get("get-collect-by-planholder/{id}", [CollectController::class, "getCollectByPlanholder"]);
    Route::get("get-collect-by-collector/{id}", [CollectController::class, "getCollectByCollector"]);
    Route::put("update-collect/{id}", [CollectController::class, "updateCollect"]);
    Route::delete("delete-collect/{id}", [CollectController::class, "deleteCollect"]);

});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
