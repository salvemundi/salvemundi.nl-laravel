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

use App\Http\Controllers\HomeController;

use App\Http\Resources\User as UserResource;
use App\Models\User;

//Auth::routes();

// Main page.

Route::get('/', [App\Http\Controllers\HomeController::class, 'welcome'])->name('home');

// Microsoft Authentication

Route::get('/signin', [App\Http\Controllers\AuthController::class, 'signin']);
Route::get('/callback', [App\Http\Controllers\AuthController::class, 'callback']);
Route::get('/signout', [App\Http\Controllers\AuthController::class, 'signout']);

// Commission page

Route::get('/commissies', [App\Http\Controllers\GetUsersController::class, 'run']);

// previousBoard page

Route::get('/vorigBestuur', [App\Http\Controllers\PreviousBoardController::class, 'index']);

// Signup for Introduction

Route::get('/intro', [App\Http\Controllers\IntroController::class, 'index'])->name('intro');
Route::post('/intro/store', [App\Http\Controllers\IntroController::class, 'store']);
Route::get('/introconfirm', [App\Http\Controllers\IntroController::class, 'confirmview'])->name('intro.confirm');
// Signup for SalveMundi page

Route::get('/inschrijven', [App\Http\Controllers\InschrijfController::class, 'index'])->name('inschrijven')->middleware('signUp.auth');
Route::post('/inschrijven/store', [App\Http\Controllers\InschrijfController::class, 'signupprocess'])->name('signupprocess')->middleware('signUp.auth');

// Mollie

Route::post('webhooks/mollie', [App\Http\Controllers\MollieWebhookController::class, 'handle'])->name('webhooks.mollie');

// Merch

Route::get('/merch', function() {return view('merch');})->name('merch');

// MyAccount page

Route::get('/mijnAccount', [App\Http\Controllers\myAccountController::class, 'index'])->middleware('azure.auth')->name('myAccount');
Route::post('/mijnAccount/store',[App\Http\Controllers\myAccountController::class, 'savePreferences'])->middleware('azure.auth');
Route::post('/mijnAccount/pay', [App\Http\Controllers\MolliePaymentController::class,'handleContributionPaymentFirstTime'])->middleware('azure.auth');
Route::post('/mijnAccount/cancel', [App\Http\Controllers\MolliePaymentController::class,'cancelSubscription'])->middleware('azure.auth');

// Activiteiten page

Route::get('/activiteiten',[App\Http\Controllers\ActivitiesController::class, 'run'] );
Route::post('/activiteiten/signup', [App\Http\Controllers\ActivitiesController::class,'signup'])->middleware('azure.auth');

// News page

Route::get('/nieuws',[App\Http\Controllers\NewsController::class, 'index'] );

// Finance page

Route::get('/financien',[App\Http\Controllers\FinanceController::class, 'index'] )->middleware('azure.auth');

// Admin Panel

Route::get('/admin', [App\Http\Controllers\AdminController::class, 'dashboard'])->middleware('admin.auth');
Route::get('/admin/leden', [App\Http\Controllers\AdminController::class, 'getUsers'])->middleware('admin.auth');
Route::get('/admin/intro', [App\Http\Controllers\AdminController::class, 'getIntro'])->middleware('admin.auth');
Route::get('/admin/sponsors', [App\Http\Controllers\AdminController::class, 'getSponsors'])->middleware('admin.auth')->name('admin.sponsors');
Route::post('/admin/sponsors/delete', [App\Http\Controllers\SponsorController::class, 'deleteSponsor'])->middleware('admin.auth');
Route::get('/admin/sponsors/add', function() {return view('admin/sponsorsAdd');})->middleware('admin.auth');
Route::post('/admin/sponsors/add/store', [App\Http\Controllers\SponsorController::class, 'addSponsor'])->middleware('admin.auth');
Route::get('/admin/activiteiten', [App\Http\Controllers\ActivitiesController::class, 'index'])->name('Activities')->middleware('admin.auth');
Route::post('/admin/activities/store', [App\Http\Controllers\ActivitiesController::class, 'store'])->middleware('admin.auth');
Route::post('/admin/activities/delete', [App\Http\Controllers\ActivitiesController::class, 'deleteActivity'])->middleware('admin.auth');
Route::get('/admin/nieuws', [App\Http\Controllers\NewsController::class, 'indexAdmin'])->name('News')->middleware('admin.auth');
Route::post('/admin/news/store', [App\Http\Controllers\NewsController::class, 'store'])->middleware('admin.auth');
Route::post('/admin/news/delete', [App\Http\Controllers\NewsController::class, 'deleteNews'])->middleware('admin.auth');
Route::get('/admin/nieuws', [App\Http\Controllers\NewsController::class, 'indexAdmin'])->name('News')->middleware('admin.auth');
Route::get('/admin/whatsapp', [App\Http\Controllers\WhatsAppController::class, 'index'])->middleware('admin.auth');
Route::post('/admin/whatsappLinks/store', [App\Http\Controllers\WhatsAppController::class, 'addWhatsappLinks'])->name('WhatsappLinks')->middleware('admin.auth');
Route::post('/admin/whatsappLinks/delete', [App\Http\Controllers\WhatsAppController::class, 'deleteWhatsappLinks'])->middleware('admin.auth');
Route::post('/admin/intro/store', [App\Http\Controllers\AdminController::class, 'storeIntro'])->middleware('admin.auth');
Route::get('/admin/transactie', [App\Http\Controllers\AdminController::class, 'indexTransaction'])->middleware('admin.auth');
Route::get('/admin/oud-bestuur', [App\Http\Controllers\PreviousBoardController::class, 'indexAdmin'])->middleware('admin.auth');
Route::post('/admin/oud-bestuur/store', [App\Http\Controllers\PreviousBoardController::class, 'addBestuur'])->middleware('admin.auth');
Route::post('/admin/oud-bestuur/delete', [App\Http\Controllers\PreviousBoardController::class, 'delete'])->middleware('admin.auth');
Route::get('/admin/financien', [App\Http\Controllers\FinanceController::class, 'indexAdmin'])->middleware('admin.auth');
Route::post('/admin/finance/store', [App\Http\Controllers\FinanceController::class, 'store'])->name('Finance')->middleware('admin.auth');
Route::post('/admin/finance/delete', [App\Http\Controllers\FinanceController::class, 'delete'])->middleware('admin.auth');
Route::get('/admin/products', [App\Http\Controllers\ProductController::class, 'index'])->middleware('admin.auth');
Route::get('/admin/products/edit',[App\Http\Controllers\ProductController::class, 'editPage'])->middleware('admin.auth');
Route::post('/admin/products/edit/store', [App\Http\Controllers\ProductController::class, 'store'])->middleware('admin.auth');
Route::get('/admin/rules', [App\Http\Controllers\RulesController::class, 'index'])->middleware('admin.auth');
Route::post('/admin/rules/store',[App\Http\Controllers\RulesController::class, 'store'])->middleware('admin.auth');
Route::post('/admin/rules/delete', [App\Http\Controllers\RulesController::class, 'delete'])->middleware('admin.auth');
Route::get('/admin/leden/groepen', [App\Http\Controllers\AdminController::class, 'groupIndex'])->middleware('admin.auth');
Route::post('/admin/leden/groepen/store', [App\Http\Controllers\AdminController::class, 'groupStore'])->middleware('admin.auth');
Route::post('/admin/leden/groepen/delete', [App\Http\Controllers\AdminController::class, 'groupDelete'])->middleware('admin.auth');
Route::post('/admin/leden/sync', [App\Http\Controllers\AdminController::class, 'sync'])->name('admin.sync')->middleware('admin.auth');
