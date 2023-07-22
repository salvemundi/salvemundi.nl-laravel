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

// Main page.

Route::get('/', [App\Http\Controllers\HomeController::class, 'welcome'])->name('home');

Route::get('/februari-intro', function () {
    return redirect('https://fontys.nl/Goede-Start-februari/Welkom-bij-AD-ICT-en-HBO-ICT-Locatie-Eindhoven.htm');
});

Route::get('/feest', function () {
    return redirect('https://salvemundi.sharepoint.com/:x:/s/feest/EdfnRaYnPMRNkcVw7exIaeUBKX8WnZn4bF83l2H3ifyyqA?e=KO5zJS');
});

// Microsoft Authentication

Route::get('/signin', [App\Http\Controllers\AuthController::class, 'signin']);
Route::get('/callback', [App\Http\Controllers\AuthController::class, 'callback']);
Route::get('/signout', [App\Http\Controllers\AuthController::class, 'signout']);

Route::get('/waarmoetdeprullenbakzak ', function () {
    return view('prullenbakfilmpje');
});

// Commission page

Route::get('/commissies', [App\Http\Controllers\CommitteeController::class, 'index']);
Route::get('/commissies/{committee_name}', [App\Http\Controllers\CommitteeController::class, 'committee']);

// Discord link
Route::get('/discord',  [App\Http\Controllers\DiscordController::class, 'redirect']);

// previousBoard page

Route::get('/vorigBestuur', [App\Http\Controllers\PreviousBoardController::class, 'index']);

// Signup for Introduction

Route::get('/intro', function() {return redirect("https://intro.salvemundi.nl");})->name('intro');

// Route::post('/intro/store', [App\Http\Controllers\IntroController::class, 'store']);
// Route::get('/introconfirm', [App\Http\Controllers\IntroController::class, 'confirmview'])->name('intro.confirm');
// Route::post('/introData/store', [App\Http\Controllers\IntroController::class, 'storeData']);

// Signup for SalveMundi page

Route::get('/inschrijven', [App\Http\Controllers\InschrijfController::class, 'index'])->name('inschrijven')->middleware('signUp.auth');
Route::post('/inschrijven/store', [App\Http\Controllers\InschrijfController::class, 'signupprocess'])->name('signupprocess')->middleware('signUp.auth');

// Mollie

Route::post('webhooks/mollie', [App\Http\Controllers\MollieWebhookController::class, 'handle'])->name('webhooks.mollie');

// Declaratie

Route::get('/declaratie', function() {return redirect("https://forms.office.com/r/kN2T95wzRm");})->name('declaratie');

// MyAccount page

Route::get('/mijnAccount', [App\Http\Controllers\MyAccountController::class, 'index'])->middleware('azure.auth')->name('myAccount');
Route::post('/mijnAccount/store',[App\Http\Controllers\MyAccountController::class, 'savePreferences'])->middleware('azure.auth');
Route::post('/mijnAccount/pay', [App\Http\Controllers\MolliePaymentController::class,'handleContributionPaymentFirstTime'])->middleware('azure.auth');
Route::post('/mijnAccount/cancel', [App\Http\Controllers\MolliePaymentController::class,'cancelSubscription'])->middleware('azure.auth');
Route::post('/mijnAccount/deletePicture', [App\Http\Controllers\MyAccountController::class,'deletePicture'])->middleware('azure.auth');

// Activiteiten page

Route::get('/activiteiten',[App\Http\Controllers\ActivitiesController::class, 'run'] );
Route::post('/activiteiten/signup', [App\Http\Controllers\ActivitiesController::class, 'signUp']);

// News page
Route::get('/nieuws',[App\Http\Controllers\NewsController::class, 'index'] );

// Sticker page

Route::get('/stickers',[App\Http\Controllers\StickerController::class, 'index'] );
Route::post('/stickers/store', [App\Http\Controllers\StickerController::class, 'store'])->middleware('azure.auth');
Route::post('/stickers/delete', [App\Http\Controllers\StickerController::class, 'delete'])->middleware('azure.auth');

// Finance page
Route::get('/financien',[App\Http\Controllers\FinanceController::class, 'index'])->middleware('azure.auth');

// Nieuwsbrief page
Route::get('/nieuwsbrief',[App\Http\Controllers\NewsLetterController::class, 'index']);

// Privacy zooi
Route::get('/responsible-disclosure', function () {
    return view("privacyZooi");
});

// Agenda
Route::get('/agenda', function() {return view('agenda');})->name('agenda');

//SideJobBank page
Route::get('/bijbaanbank',[App\Http\Controllers\SideJobBankController::class, 'index']);

// Clubs
Route::get('/clubs',[App\Http\Controllers\ClubsController::class, 'index']);

// Admin Panel

Route::get('/admin/rechten',[App\Http\Controllers\PermissionController::class,'viewAllPermissions'])->middleware('admin.auth');
Route::get('/admin/rechten/{permissionId}/routes',[App\Http\Controllers\PermissionController::class,'viewAllRoutesOfPermission'])->middleware('admin.auth');
Route::post('/admin/rechten/{permissionId}/store',[App\Http\Controllers\PermissionController::class,'storePermission'])->middleware('admin.auth');
Route::post('/admin/rechten/{permissionId}/delete',[App\Http\Controllers\PermissionController::class,'deletePermission'])->middleware('admin.auth');
Route::post('/admin/rechten/store',[App\Http\Controllers\PermissionController::class,'storePermission'])->middleware('admin.auth');

Route::post('/admin/rechten/{permissionId}/routes/{routeId}/delete',[App\Http\Controllers\PermissionController::class,'deleteRouteFromPermission'])->middleware('admin.auth');
Route::post('/admin/rechten/{permissionId}/routes/{routeId}/store',[App\Http\Controllers\PermissionController::class,'addRouteToPermission'])->middleware('admin.auth');


Route::post('/admin/route/{routeId}/store',[App\Http\Controllers\RouteController::class,'storeRoute'])->middleware('admin.auth');
Route::post('/admin/route/store',[App\Http\Controllers\RouteController::class,'storeRoute'])->middleware('admin.auth');
Route::post('/admin/route/{routeId}/delete',[App\Http\Controllers\RouteController::class,'deleteRoute'])->middleware('admin.auth');


Route::get('/admin/leden/{userId}/permissions',[App\Http\Controllers\PermissionController::class, 'viewPermissionsUser'])->middleware("admin.auth");
Route::post('/admin/leden/{userId}/permissions/{permissionId}/store',[App\Http\Controllers\PermissionController::class,'savePermissionUser'])->middleware("admin.auth");
Route::post('/admin/leden/{userId}/permissions/{permissionId}/delete',[App\Http\Controllers\PermissionController::class,'deletePermissionUser'])->middleware("admin.auth");

Route::get('/admin/groepen', [App\Http\Controllers\CommitteeController::class, 'showAllCommitteesAdmin'])->middleware("admin.auth");
Route::get('/admin/groepen/{groupId}/permissions', [App\Http\Controllers\PermissionController::class, 'viewPermissionsGroup'])->middleware("admin.auth");
Route::post('/admin/groepen/{groupId}/permissions/{permissionId}/store', [App\Http\Controllers\PermissionController::class, 'savePermissionGroup'])->middleware("admin.auth");
Route::post('/admin/groepen/{groupId}/permissions/{permissionId}/delete', [App\Http\Controllers\PermissionController::class, 'deletePermissionGroup'])->middleware("admin.auth");

Route::get('/admin', [App\Http\Controllers\AdminController::class, 'dashboard'])->middleware('admin.auth');
Route::post("/admin/leden/disableall", [App\Http\Controllers\AdminController::class,'DisableAllAzureAcc'])->middleware("admin.auth");
Route::post('/admin/leden/disable', [App\Http\Controllers\AdminController::class, 'disableAzureAcc'])->name('disableUser')->middleware('admin.auth');
Route::post('/admin/leden/unpaid/notify', [App\Http\Controllers\AdminController::class, 'sendEmailToUnpaidMembers'])->middleware('admin.auth');
Route::get('/admin/intro', [App\Http\Controllers\AdminController::class, 'getIntro'])->middleware("admin.auth");
Route::get('/admin/sponsors', [App\Http\Controllers\AdminController::class, 'getSponsors'])->middleware('admin.auth')->name('admin.sponsors');
Route::post('/admin/sponsors/delete', [App\Http\Controllers\SponsorController::class, 'deleteSponsor'])->middleware('admin.auth');
Route::get('/admin/sponsors/add', function() {return view('admin/sponsorsAdd');})->middleware('admin.auth');
Route::post('/admin/sponsors/add/store', [App\Http\Controllers\SponsorController::class, 'addSponsor'])->middleware('admin.auth');
Route::get('/admin/activiteiten', [App\Http\Controllers\ActivitiesController::class, 'index'])->name('Activities')->middleware('admin.auth');
Route::post('/admin/activities/store', [App\Http\Controllers\ActivitiesController::class, 'store'])->middleware('admin.auth');
Route::post('/admin/activities/edit', [App\Http\Controllers\ActivitiesController::class, 'editActivities'])->middleware('admin.auth');
Route::post('/admin/activities/edit/store', [App\Http\Controllers\ActivitiesController::class, 'store'])->middleware('admin.auth');
Route::post('/admin/activities/delete', [App\Http\Controllers\ActivitiesController::class, 'deleteActivity'])->middleware('admin.auth');
Route::post('/admin/activities/signups', [App\Http\Controllers\ActivitiesController::class, 'signupsActivity'])->middleware('admin.auth');
Route::get('/admin/activiteiten/tags', [App\Http\Controllers\TagsController::class, 'getTags'])->name('ActivityTags')->middleware('admin.auth');
Route::post('/admin/activiteiten/tags/store', [App\Http\Controllers\TagsController::class, 'store'])->name('ActivityTagsStore')->middleware('admin.auth');
Route::post('/admin/activiteiten/tags/delete/{tagId}', [App\Http\Controllers\TagsController::class, 'delete'])->name('ActivityTagDelete')->middleware('admin.auth');

Route::get('/admin/nieuws', [App\Http\Controllers\NewsController::class, 'indexAdmin'])->name('News')->middleware('admin.auth');
Route::post('/admin/news/store', [App\Http\Controllers\NewsController::class, 'store'])->middleware('admin.auth');
Route::post('/admin/news/delete', [App\Http\Controllers\NewsController::class, 'deleteNews'])->middleware('admin.auth');
Route::post('/admin/news/edit', [App\Http\Controllers\NewsController::class, 'editNews'])->middleware('admin.auth');
Route::post('/admin/news/edit/store', [App\Http\Controllers\NewsController::class, 'store'])->middleware('admin.auth');

Route::post('/admin/skills/store/{id}', [App\Http\Controllers\SideJobSkillController::class, 'store'])->middleware('admin.auth');
Route::post('/admin/skills/store', [App\Http\Controllers\SideJobSkillController::class, 'store'])->middleware('admin.auth');
Route::post('/admin/skills/delete/{id}', [App\Http\Controllers\SideJobSkillController::class, 'delete'])->middleware('admin.auth');

Route::get('/admin/bijbaanbank', [App\Http\Controllers\SideJobBankController::class, 'indexAdmin'])->middleware('admin.auth');
Route::post('/admin/bijbaanbank/store', [App\Http\Controllers\SideJobBankController::class, 'store'])->middleware('admin.auth');
Route::post('/admin/bijbaanbank/delete', [App\Http\Controllers\SideJobBankController::class, 'deleteSideJobBank'])->middleware('admin.auth');
Route::post('/admin/bijbaanbank/edit', [App\Http\Controllers\SideJobBankController::class, 'editSideJobBank'])->middleware('admin.auth');
Route::post('/admin/bijbaanbank/edit/store', [App\Http\Controllers\SideJobBankController::class, 'store'])->middleware('admin.auth');
Route::get('/admin/socials', [App\Http\Controllers\WhatsAppController::class, 'index'])->middleware('admin.auth');
Route::post('/admin/discord', [App\Http\Controllers\DiscordController::class, 'save'])->middleware('admin.auth');
Route::post('/admin/whatsappLinks/store', [App\Http\Controllers\WhatsAppController::class, 'addWhatsappLinks'])->name('WhatsappLinks')->middleware('admin.auth');
Route::post('/admin/whatsappLinks/delete', [App\Http\Controllers\WhatsAppController::class, 'deleteWhatsappLinks'])->middleware('admin.auth');
Route::post('/admin/intro/store', [App\Http\Controllers\AdminController::class, 'storeIntro'])->middleware('admin.auth');
Route::post('/admin/intro/storeConfirm', [App\Http\Controllers\AdminController::class, 'storeIntroConfirm'])->middleware('admin.auth');
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
Route::post('/admin/products/delete', [App\Http\Controllers\ProductController::class, 'delete'])->middleware('admin.auth');
Route::get('/admin/rules', [App\Http\Controllers\RulesController::class, 'index'])->middleware('admin.auth');
Route::post('/admin/rules/store',[App\Http\Controllers\RulesController::class, 'store'])->middleware('admin.auth');
Route::post('/admin/rules/delete', [App\Http\Controllers\RulesController::class, 'delete'])->middleware('admin.auth');
Route::get('/admin/leden/groepen', [App\Http\Controllers\AdminController::class, 'groupIndex'])->middleware('admin.auth');
Route::post('/admin/leden/groepen/store', [App\Http\Controllers\AdminController::class, 'groupStore'])->middleware('admin.auth');
Route::post('/admin/leden/groepen/delete', [App\Http\Controllers\AdminController::class, 'groupDelete'])->middleware('admin.auth');
Route::post('/admin/leden/sync', [App\Http\Controllers\AdminController::class, 'sync'])->name('admin.sync')->middleware('admin.auth');

Route::get('/export_excel', [App\Http\Controllers\IntroController::class, 'indexExcel'])->middleware('admin.auth');
Route::get('/export_excel/excel', [App\Http\Controllers\IntroController::class, 'excel'])->name('export_excel.excelBetaald')->middleware('admin.auth');

Route::get('/export_excel', [App\Http\Controllers\IntroController::class, 'indexExcel'])->middleware('admin.auth');
Route::get('/export_excel/excelNietBetaald', [App\Http\Controllers\IntroController::class, 'excelNietBetaald'])->name('export_excel.excelIedereen')->middleware('admin.auth');

Route::get('/admin/leden', [App\Http\Controllers\AdminController::class, 'viewRemoveLeden'])->middleware('admin.auth');
Route::post('/admin/leden/delete', [App\Http\Controllers\AzureController::class, 'DeleteUser'])->middleware('admin.auth')->name('removeLeden');

Route::get('/admin/newsletter', [App\Http\Controllers\NewsLetterController::class, 'indexAdmin'])->middleware('admin.auth');
Route::post('/admin/newsletter/store', [App\Http\Controllers\NewsLetterController::class, 'store'])->middleware('admin.auth');
Route::post('/admin/newsletter/delete', [App\Http\Controllers\NewsLetterController::class, 'delete'])->middleware('admin.auth');

Route::get('/admin/clubs', [App\Http\Controllers\ClubsController::class, 'adminIndex'])->middleware('admin.auth');
Route::post('/admin/clubs/store', [App\Http\Controllers\ClubsController::class, 'store'])->middleware('admin.auth');
Route::post('/admin/clubs/edit', [App\Http\Controllers\ClubsController::class, 'edit'])->middleware('admin.auth');
Route::post('/admin/clubs/edit/store', [App\Http\Controllers\ClubsController::class, 'store'])->middleware('admin.auth');
Route::post('/admin/clubs/delete', [App\Http\Controllers\ClubsController::class, 'delete'])->middleware('admin.auth');
