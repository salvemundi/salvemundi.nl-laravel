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

// Calendar
Route::get('/ical', [App\Http\Controllers\CalendarController::class, 'generateICal']);

// Merch
Route::middleware(['auth'])->group(function () {
    Route::get('/merch', [App\Http\Controllers\MerchController::class, 'view']);
    Route::get('/merch/{id}', [App\Http\Controllers\MerchController::class, 'viewItem']);
    Route::post('/merch/purchase/{id}', [App\Http\Controllers\MerchPaymentController::class, 'handlePurchase']);
});
Route::get('/februari-intro', function () {
    return redirect('https://fontys.nl/Goede-Start-februari/Welkom-bij-AD-ICT-en-HBO-ICT-Locatie-Eindhoven.htm');
});

Route::get('/feest', function () {
    return redirect('https://salvemundi.sharepoint.com/:x:/s/feest/EdfnRaYnPMRNkcVw7exIaeUBKX8WnZn4bF83l2H3ifyyqA?e=KO5zJS');
});

// Microsoft Authentication
Route::get('/signin', [App\Http\Controllers\AuthController::class, 'signIn'])->name('login');
Route::get('/callback', [App\Http\Controllers\AuthController::class, 'callback']);
Route::get('/signout', [App\Http\Controllers\AuthController::class, 'signOut']);

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

// Signup for SalveMundi page
Route::get('/inschrijven', [App\Http\Controllers\InschrijfController::class, 'index'])->name('inschrijven')->middleware('signUp.auth');
Route::post('/inschrijven/store', [App\Http\Controllers\InschrijfController::class, 'signupprocess'])->name('signupprocess')->middleware('signUp.auth');

// Mollie
Route::post('webhooks/mollie', [App\Http\Controllers\MollieWebhookController::class, 'handle'])->name('webhooks.mollie');
Route::post('webhooks/mollie/merch', [App\Http\Controllers\MerchPaymentController::class,'handlePayment'])->name('webhooks.mollie.merch');

// Declaratie
Route::get('/declaratie', function() {return redirect("https://forms.office.com/r/kN2T95wzRm");})->name('declaratie');
Route::get('/declareren', function () {
    return redirect()->route('declaratie');
});

// MyAccount page
Route::get('/mijnAccount', [App\Http\Controllers\MyAccountController::class, 'index'])->middleware('auth')->name('myAccount');
Route::post('/mijnAccount/store',[App\Http\Controllers\MyAccountController::class, 'savePreferences'])->middleware('auth');
Route::post('/mijnAccount/pay', [App\Http\Controllers\MolliePaymentController::class,'handleContributionPaymentFirstTime'])->middleware('auth');
Route::post('/mijnAccount/cancel', [App\Http\Controllers\MolliePaymentController::class,'cancelSubscription'])->middleware('auth');
Route::post('/mijnAccount/deletePicture', [App\Http\Controllers\MyAccountController::class,'deletePicture'])->middleware('auth');

// Activiteiten page
Route::get('/activiteiten',[App\Http\Controllers\ActivitiesController::class, 'run'] );
Route::post('/activiteiten/signup', [App\Http\Controllers\ActivitiesController::class, 'signUp']);

Route::get('/kroegentocht',[App\Http\Controllers\ActivitiesController::class,'pubcrawl']);

// News page
Route::get('/nieuws',[App\Http\Controllers\NewsController::class, 'index'] );

// Sticker page
Route::get('/stickers',[App\Http\Controllers\StickerController::class, 'index'] );
Route::post('/stickers/store', [App\Http\Controllers\StickerController::class, 'store'])->middleware('auth');
Route::post('/stickers/delete', [App\Http\Controllers\StickerController::class, 'delete'])->middleware('auth');

// Finance page
Route::get('/financien',[App\Http\Controllers\FinanceController::class, 'index'])->middleware('auth');

// Nieuwsbrief page
Route::get('/nieuwsbrief',[App\Http\Controllers\NewsLetterController::class, 'index']);

// Pizza
Route::get('/pizza',[App\Http\Controllers\PizzaController::class ,'index'])->middleware('auth');
Route::post('/pizza/store',[\App\Http\Controllers\PizzaController::class,'store'])->middleware('auth');
Route::post('/pizza/delete/all',[\App\Http\Controllers\PizzaController::class, 'deleteAllPizzas'])->middleware('auth');
Route::post('/pizza/delete/{id}',[\App\Http\Controllers\PizzaController::class, 'deleteOwnPizza'])->middleware('auth');

// Privacy zooi
Route::get('/responsible-disclosure', function () {
    return view("privacyZooi");
});

// Cobo aanmeld pagina
Route::get('/cobo', function () {
    return redirect('https://salvemundi.sharepoint.com/:x:/s/cobo/Eb9cAIvGq3pEvwL4qETDNUgBjzrcmZCLqfYwlbCUrHGDlg?e=H6YJy0');
});

// Agenda
Route::get('/agenda', [App\Http\Controllers\CalendarController::class, 'index'])->name('agenda');

//SideJobBank page
Route::get('/bijbaanbank',[App\Http\Controllers\SideJobBankController::class, 'index']);

// Clubs
Route::get('/clubs',[App\Http\Controllers\ClubsController::class, 'index']);

// Admin Panel
Route::middleware(['admin.auth'])->group(function () {
    // permissions
    Route::get('/admin/rechten',[App\Http\Controllers\PermissionController::class,'viewAllPermissions']);
    Route::get('/admin/rechten/{permissionId}/routes',[App\Http\Controllers\PermissionController::class,'viewAllRoutesOfPermission']);
    Route::post('/admin/rechten/{permissionId}/store',[App\Http\Controllers\PermissionController::class,'storePermission']);
    Route::post('/admin/rechten/{permissionId}/delete',[App\Http\Controllers\PermissionController::class,'deletePermission']);
    Route::post('/admin/rechten/store',[App\Http\Controllers\PermissionController::class,'storePermission']);
    Route::post('/admin/rechten/{permissionId}/routes/{routeId}/delete',[App\Http\Controllers\PermissionController::class,'deleteRouteFromPermission']);
    Route::post('/admin/rechten/{permissionId}/routes/{routeId}/store',[App\Http\Controllers\PermissionController::class,'addRouteToPermission']);
    Route::post('/admin/route/{routeId}/store',[App\Http\Controllers\RouteController::class,'storeRoute']);
    Route::post('/admin/route/store',[App\Http\Controllers\RouteController::class,'storeRoute']);
    Route::post('/admin/route/{routeId}/delete',[App\Http\Controllers\RouteController::class,'deleteRoute']);
    Route::get('/admin/leden/{userId}/permissions',[App\Http\Controllers\PermissionController::class, 'viewPermissionsUser']);
    Route::post('/admin/leden/{userId}/permissions/{permissionId}/store',[App\Http\Controllers\PermissionController::class,'savePermissionUser']);
    Route::post('/admin/leden/{userId}/permissions/{permissionId}/delete',[App\Http\Controllers\PermissionController::class,'deletePermissionUser']);
    Route::get('/admin/groepen/{groupId}/permissions', [App\Http\Controllers\PermissionController::class, 'viewPermissionsGroup']);
    Route::post('/admin/groepen/{groupId}/permissions/{permissionId}/store', [App\Http\Controllers\PermissionController::class, 'savePermissionGroup']);
    Route::post('/admin/groepen/{groupId}/permissions/{permissionId}/delete', [App\Http\Controllers\PermissionController::class, 'deletePermissionGroup']);

    // members
    Route::get('/admin', [App\Http\Controllers\AdminController::class, 'dashboard']);
    Route::post("/admin/leden/disableall", [App\Http\Controllers\AdminController::class,'DisableAllAzureAcc']);
    Route::post('/admin/leden/disable', [App\Http\Controllers\AdminController::class, 'disableAzureAcc'])->name('disableUser');
    Route::post('/admin/leden/unpaid/notify', [App\Http\Controllers\AdminController::class, 'sendEmailToUnpaidMembers']);
    Route::post('/admin/leden/delete', [App\Http\Controllers\AzureController::class, 'DeleteUser'])->name('removeLeden');

    // sponsors
    Route::get('/admin/sponsors', [App\Http\Controllers\AdminController::class, 'getSponsors'])->name('admin.sponsors');
    Route::post('/admin/sponsors/delete', [App\Http\Controllers\SponsorController::class, 'deleteSponsor']);
    Route::get('/admin/sponsors/add', function() {return view('admin/sponsorsAdd');});
    Route::post('/admin/sponsors/add/store', [App\Http\Controllers\SponsorController::class, 'addSponsor']);

    // activities
    Route::get('/admin/activiteiten', [App\Http\Controllers\ActivitiesController::class, 'index'])->name('Activities');
    Route::post('/admin/activities/store', [App\Http\Controllers\ActivitiesController::class, 'store']);
    Route::get('/admin/activities/{activityId}/edit', [App\Http\Controllers\ActivitiesController::class, 'editActivities']);
    Route::post('/admin/activities/edit/store', [App\Http\Controllers\ActivitiesController::class, 'store']);
    Route::post('/admin/activities/delete', [App\Http\Controllers\ActivitiesController::class, 'deleteActivity']);
    Route::get('/admin/activities/{activityId}/signups', [App\Http\Controllers\ActivitiesController::class, 'signupsActivity']);

    // activity tags
    Route::get('/admin/activiteiten/tags', [App\Http\Controllers\TagsController::class, 'getTags'])->name('ActivityTags');
    Route::post('/admin/activiteiten/tags/store', [App\Http\Controllers\TagsController::class, 'store'])->name('ActivityTagsStore');
    Route::post('/admin/activiteiten/tags/delete/{tagId}', [App\Http\Controllers\TagsController::class, 'delete'])->name('ActivityTagDelete');

    // activity participant management
    Route::post('/admin/activiteiten/{activityId}/addMember', [App\Http\Controllers\ActivitiesController::class, 'addMemberToAcitivty']);
    Route::post('/admin/activiteiten/{activityId}/remove/{userId}', [App\Http\Controllers\ActivitiesController::class, 'removeMemberFromActivity']);

    // news
    Route::get('/admin/nieuws', [App\Http\Controllers\NewsController::class, 'indexAdmin'])->name('News');
    Route::post('/admin/news/store', [App\Http\Controllers\NewsController::class, 'store']);
    Route::post('/admin/news/delete', [App\Http\Controllers\NewsController::class, 'deleteNews']);
    Route::post('/admin/news/edit', [App\Http\Controllers\NewsController::class, 'editNews']);
    Route::post('/admin/news/edit/store', [App\Http\Controllers\NewsController::class, 'store']);

    // side jobs
    Route::post('/admin/skills/store/{id}', [App\Http\Controllers\SideJobSkillController::class, 'store']);
    Route::post('/admin/skills/store', [App\Http\Controllers\SideJobSkillController::class, 'store']);
    Route::post('/admin/skills/delete/{id}', [App\Http\Controllers\SideJobSkillController::class, 'delete']);
    Route::get('/admin/bijbaanbank', [App\Http\Controllers\SideJobBankController::class, 'indexAdmin']);
    Route::post('/admin/bijbaanbank/store', [App\Http\Controllers\SideJobBankController::class, 'store']);
    Route::post('/admin/bijbaanbank/delete', [App\Http\Controllers\SideJobBankController::class, 'deleteSideJobBank']);
    Route::post('/admin/bijbaanbank/edit', [App\Http\Controllers\SideJobBankController::class, 'editSideJobBank']);
    Route::post('/admin/bijbaanbank/edit/store', [App\Http\Controllers\SideJobBankController::class, 'store']);

    // social media links
    Route::get('/admin/socials', [App\Http\Controllers\WhatsAppController::class, 'index']);
    Route::post('/admin/discord', [App\Http\Controllers\DiscordController::class, 'save']);
    Route::post('/admin/whatsappLinks/store', [App\Http\Controllers\WhatsAppController::class, 'addWhatsappLinks'])->name('WhatsappLinks');
    Route::post('/admin/whatsappLinks/delete', [App\Http\Controllers\WhatsAppController::class, 'deleteWhatsappLinks']);

    // intro legacy
    Route::post('/admin/intro/store', [App\Http\Controllers\AdminController::class, 'storeIntro']);
    Route::post('/admin/intro/storeConfirm', [App\Http\Controllers\AdminController::class, 'storeIntroConfirm']);
    Route::get('/export_excel', [App\Http\Controllers\IntroController::class, 'indexExcel']);
    Route::get('/export_excel/excel', [App\Http\Controllers\IntroController::class, 'excel'])->name('export_excel.excelBetaald');
    Route::get('/export_excel', [App\Http\Controllers\IntroController::class, 'indexExcel']);
    Route::get('/export_excel/excelNietBetaald', [App\Http\Controllers\IntroController::class, 'excelNietBetaald'])->name('export_excel.excelIedereen');
    Route::get('/admin/intro', [App\Http\Controllers\AdminController::class, 'getIntro']);

    // old board
    Route::get('/admin/oud-bestuur', [App\Http\Controllers\PreviousBoardController::class, 'indexAdmin']);
    Route::post('/admin/oud-bestuur/store', [App\Http\Controllers\PreviousBoardController::class, 'addBestuur']);
    Route::post('/admin/oud-bestuur/delete', [App\Http\Controllers\PreviousBoardController::class, 'delete']);

    // finances display for members
    Route::get('/admin/financien', [App\Http\Controllers\FinanceController::class, 'indexAdmin']);
    Route::post('/admin/finance/store', [App\Http\Controllers\FinanceController::class, 'store'])->name('Finance');
    Route::post('/admin/finance/delete', [App\Http\Controllers\FinanceController::class, 'delete']);

    // activity and membership management
    Route::get('/admin/products', [App\Http\Controllers\ProductController::class, 'index']);
    Route::get('/admin/products/edit',[App\Http\Controllers\ProductController::class, 'editPage']);
    Route::post('/admin/products/edit/store', [App\Http\Controllers\ProductController::class, 'store']);
    Route::post('/admin/products/delete', [App\Http\Controllers\ProductController::class, 'delete']);

    // rules management
    Route::get('/admin/rules', [App\Http\Controllers\RulesController::class, 'index']);
    Route::post('/admin/rules/store',[App\Http\Controllers\RulesController::class, 'store']);
    Route::post('/admin/rules/delete', [App\Http\Controllers\RulesController::class, 'delete']);

    // member & group management
    Route::get('/admin/groepen', [App\Http\Controllers\CommitteeController::class, 'showAllCommitteesAdmin']);
    Route::get('/admin/groepen/{groupId}/members', [App\Http\Controllers\CommitteeController::class, 'viewMembersGroup']);
    Route::get('/admin/leden/{userId}/groepen', [App\Http\Controllers\AdminController::class, 'groupIndex']);
    Route::post('/admin/leden/groepen/store', [App\Http\Controllers\AdminController::class, 'groupStore']);
    Route::post('/admin/leden/groepen/delete', [App\Http\Controllers\AdminController::class, 'groupDelete']);
    Route::post('/admin/leden/sync', [App\Http\Controllers\AdminController::class, 'sync'])->name('admin.sync');
    Route::get('/admin/leden', [App\Http\Controllers\AdminController::class, 'viewRemoveLeden']);
    Route::post('/admin/groepen/{groupId}/makeLeader/{userId}', [App\Http\Controllers\CommitteeController::class,'makeUserCommitteeLeader']);

    // newsletter
    Route::get('/admin/newsletter', [App\Http\Controllers\NewsLetterController::class, 'indexAdmin']);
    Route::post('/admin/newsletter/store', [App\Http\Controllers\NewsLetterController::class, 'store']);
    Route::post('/admin/newsletter/delete', [App\Http\Controllers\NewsLetterController::class, 'delete']);

    // clubs
    Route::get('/admin/clubs', [App\Http\Controllers\ClubsController::class, 'adminIndex']);
    Route::post('/admin/clubs/store', [App\Http\Controllers\ClubsController::class, 'store']);
    Route::post('/admin/clubs/edit', [App\Http\Controllers\ClubsController::class, 'edit']);
    Route::post('/admin/clubs/edit/store', [App\Http\Controllers\ClubsController::class, 'store']);
    Route::post('/admin/clubs/delete', [App\Http\Controllers\ClubsController::class, 'delete']);

    // calendar
    Route::get('/admin/calendar', [App\Http\Controllers\CalendarController::class, 'admin']);
    Route::post('/admin/calendar/store', [App\Http\Controllers\CalendarController::class, 'store']);
    Route::post('/admin/calendar/{id}/store', [App\Http\Controllers\CalendarController::class, 'store']);
    Route::get('/admin/calendar/{id}/edit', [App\Http\Controllers\CalendarController::class, 'adminEdit']);
    Route::post('/admin/calendar/{id}/delete', [App\Http\Controllers\CalendarController::class, 'delete']);

    // coupons
    Route::get('/admin/coupons', [App\Http\Controllers\CouponController::class, 'index']);
    Route::post('/admin/coupons/create', [App\Http\Controllers\CouponController::class, 'store']);
    Route::post('/admin/coupons/delete/{id}', [App\Http\Controllers\CouponController::class, 'delete']);
    Route::post('/admin/coupons/edit/{id}', [App\Http\Controllers\CouponController::class, 'store']);
    Route::get('/admin/coupons/edit/{id}', [App\Http\Controllers\CouponController::class, 'editView']);

    // merch
    Route::get('/admin/merch', [App\Http\Controllers\MerchController::class, 'adminView']);
    Route::get('/admin/merch/edit/{id}', [App\Http\Controllers\MerchController::class, 'adminEditView']);
    Route::post('/admin/merch/store', [App\Http\Controllers\MerchController::class,'store']);
    Route::get('/admin/merch/orders',[App\Http\Controllers\MerchController::class,'adminAllOrders']);
    Route::post('/admin/merch/orders/pickedUp/{orderId}',[App\Http\Controllers\MerchController::class,'pickedUpToggle']);
    Route::post('/admin/merch/store/{id}', [App\Http\Controllers\MerchController::class,'store']);
    Route::post('/admin/merch/delete/{id}', [App\Http\Controllers\MerchController::class,'delete']);
    Route::get('/admin/merch/inventory/{id}', [App\Http\Controllers\MerchController::class, 'viewInventory']);
    Route::post('/admin/merch/inventory/{id}/save/{sizeId}/{genderId}',[App\Http\Controllers\MerchController::class,'storeSize']);
    Route::post('/admin/merch/inventory/{id}/attach',[App\Http\Controllers\MerchController::class,'attachSize']);
    Route::post('/admin/merch/inventory/{id}/delete/{sizeId}/{genderId}',[App\Http\Controllers\MerchController::class,'deleteSize']);
});
