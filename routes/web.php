<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\CustomController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\QuickViewController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\WidgetController;
use App\Http\Controllers\AlertController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CompanySettingController;
use App\Http\Controllers\UserlogController;


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


require __DIR__.'/auth.php';
	Route::get('/', [HomeController::class, 'landingPage']);

	Route::any('share/link/error/{lang}',[SiteController::class, 'share_link_error'])->name('share-link-error');

	Route::any('share/setting/{type}',[SiteController::class, 'site_share_setting'])->name('save-share-setting')->middleware(['auth','XSS']);
	Route::any('edit/share/setting/{id}/{type}',[SiteController::class, 'show_site_share_setting'])->name('edit-share-setting')->middleware(['auth','XSS']);
	Route::any('site/dashboard/link/{id}/{lang}', [SiteController::class, 'site_dashboard_link'])->name('site.dashboard.link');
	Route::any('custom-share-chart',[CustomController::class, 'custom_share_chart'])->name('custom-share-chart');
	Route::any('quickview/link/{id}/{lang}', [QuickViewController::class, 'quickview_link'])->name('quickview.share.link');
	Route::any('quick-view-data',[QuickViewController::class, 'quick_view_data'])->name('quick-view-data');

	Route::any('site/analyse/link/{id}/{type?}/{lang}', [SiteController::class, 'site_analyse_link'])->name('site.analyse.link');
	Route::any('get-chart',[ChartController::class, 'get_chart_data'])->name('get-chart');
	Route::any('live-user',[ChartController::class, 'live_user'])->name('live-user');
	Route::any('active-page',[ChartController::class, 'active_page'])->name('active-page');
	Route::any('genrate_accesstoken',[AnalyticsController::class, 'genrate_accesstoken'])->name('genrate_accesstoken');
	Route::any('get-audience-data',[AnalyticsController::class, 'get_audience_data'])->name('get-audience-data');
	Route::any('get-page-data',[AnalyticsController::class, 'get_page_data'])->name('get-page-data');
	Route::any('get-seo-data',[AnalyticsController::class, 'get_seo_data'])->name('get-seo-data');
	Route::any('get-channel-data',[AnalyticsController::class, 'get_channel_data'])->name('get-channel-data');

	Route::get('/verify-email/{lang?}', [EmailVerificationPromptController::class, 'showverifyform'])->middleware(['XSS', 'auth'])
	->name('verification.notice');
	Route::post('resetpassword',[UsersController::class,'resetPassword'])->name('reset.password')->middleware(['auth','XSS']);
	    Route::any('/user/test/mail/send', [CompanySettingController::class, 'testmailstore'])->name('users.test.email.send')->middleware(['auth', 'XSS']);

	Route::any('add-site',[AnalyticsController::class, 'index'])->name('add-site')->middleware(['auth','XSS']);

	Route::any('oauth2callback',[AnalyticsController::class, 'oauth2callback'])->name('oauth2callback')->middleware(['auth','XSS']);
	Route::any('channel',[AnalyticsController::class, 'channel_analytics'])->name('channel')->middleware(['auth','XSS']);
	Route::any('audience',[AnalyticsController::class, 'audience_analytics'])->name('audience')->middleware(['auth','XSS']);

	Route::any('page',[AnalyticsController::class, 'page_analytics'])->name('page')->middleware(['auth','XSS']);
	Route::any('seo-analysis',[AnalyticsController::class, 'seo_analysis'])->name('seo-analysis')->middleware(['auth','XSS']);
	Route::any('new',[AnalyticsController::class, 'new'])->name('new')->middleware(['auth','XSS']);



Route::group(['middleware' => ['verified'],], function (){
	  Route::post('company/slack-settings', [CompanySettingController::class, 'saveSlackSettings'])->name('company.slack.settings');
    Route::post('company/report-settings', [CompanySettingController::class, 'savereportSettings'])->name('company.report.settings');
	Route::any('/dashboard',[HomeController::class, 'dashboard'])->name('dashboard')->middleware(['auth','XSS']);
	Route::any('save-json', [HomeController::class, 'save_json'])->name('save-json');
	Route::any('quickview/share/setting/',[QuickViewController::class, 'quickview_share_setting'])->name('save-quickview-setting')->middleware(['auth','XSS']);
	Route::any('quickview/edit/share/setting/',[QuickViewController::class, 'show_quickview_share_setting'])->name('edit-quickview-setting')->middleware(['auth','XSS']);
	Route::any('users',[UsersController::class, 'index'])->name('users')->middleware(['auth','XSS']);
	Route::any('save-user',[UsersController::class, 'save_user'])->name('save-user')->middleware(['auth','XSS']);
	Route::any('update-user',[UsersController::class, 'update_user'])->name('update-user')->middleware(['auth','XSS']);
	Route::any('delete-user/{id}',[UsersController::class, 'delete_user'])->name('delete-user')->middleware(['auth','XSS']);
	Route::any('edit-user/{id}',[UsersController::class, 'edit_user'])->name('edit-use')->middleware(['auth','XSS']);
	Route::get('/my-account',[UsersController::class,'account'])->name('my.account')->middleware(['auth','XSS']);
	Route::post('/my-account',[UsersController::class,'accountupdate'])->name('account.update')->middleware(['auth','XSS']);
	Route::post('/my-account/password',[UsersController::class,'updatePassword'])->name('update.password')->middleware(['auth','XSS']);
	Route::delete('/my-account',[UsersController::class,'deleteAvatar'])->name('delete.avatar')->middleware(['auth','XSS']);
	Route::get('/plan/change/{id}', [UsersController::class, 'changePlan'])->name('users.change.plan')->middleware(['auth','XSS']);
	Route::get('user/{id}/plan/{pid}/{duration}', [UsersController::class, 'manuallyActivatePlan'])->name('manually.activate.plan')->middleware(['auth','XSS']);
	Route::any('roles',[RoleController::class,'index'])->name('roles.index')->middleware(['auth','XSS']);
	Route::any('create/roles',[RoleController::class,'create'])->name('create.roles')->middleware(['auth','XSS']);
	Route::any('store/roles',[RoleController::class,'store'])->name('store.roles')->middleware(['auth','XSS']);
	Route::any('edit/roles/{id}',[RoleController::class,'edit'])->name('roles.edit')->middleware(['auth','XSS']);
	Route::any('destroy/roles/{id}',[RoleController::class,'destroy'])->name('roles.destroy')->middleware(['auth','XSS']);
	Route::any('update/roles/{id}',[RoleController::class,'update'])->name('roles.update')->middleware(['auth','XSS']);
	Route::resource('permissions', PermissionController::class)->middleware(['auth','XSS']);
	Route::get('settings', [SettingController::class, 'index'])->name('settings.index')->middleware(['auth','XSS']);
	Route::post('settings', [SettingController::class, 'store'])->name('settings.store')->middleware(['auth','XSS']);
	Route::post('email-settings', [SettingController::class, 'emailSettingStore'])->name('email.settings.store')->middleware(['auth','XSS']);
	Route::post('pusher-settings', [SettingController::class, 'pusherSettingStore'])->name('pusher.settings.store')->middleware(['auth','XSS']);
	Route::any('test', [SettingController::class, 'testEmail'])->name('test.email')->middleware(['auth','XSS']);
	Route::post('test/send', [SettingController::class, 'testEmailSend'])->name('test.email.send')->middleware(['auth','XSS']);
	Route::post('payment-setting', [SettingController::class, 'savePaymentSettings'])->name('payment.setting')->middleware(['auth','XSS']);
	Route::post('storage-settings',[SettingController::class,'storageSettingStore'])->name('storage.setting.store')->middleware(['auth','XSS']);
	Route::post('setting/seo',[CompanySettingController::class,'saveSEOSettings'])->name('seo.settings.store')->middleware(['auth','XSS']);
	Route::post('cookie-setting', [CompanySettingController::class, 'saveCookieSettings'])->name('cookie.setting');
	Route::any('getProperty',[SiteController::class, 'getProperty'])->name('getProperty')->middleware(['auth','XSS']);
	Route::any('getView',[SiteController::class, 'getView'])->name('getView')->middleware(['auth','XSS']);
	Route::any('save-site',[SiteController::class, 'save_site'])->name('save-site')->middleware(['auth','XSS']);
	Route::any('site-standard/{id}',[SiteController::class, 'site_standard'])->name('site-standard')->middleware(['auth','XSS']);
	Route::any('manage-site',[SiteController::class, 'manage_site'])->name('manage-site')->middleware(['auth','XSS']);
	Route::any('site-list',[SiteController::class, 'site_list'])->name('site-list')->middleware(['auth','XSS']);
	Route::any('edit-site/{id}',[SiteController::class, 'edit_site'])->name('edit-site')->middleware(['auth','XSS']);
	Route::any('delete-site/{id}',[SiteController::class, 'delete_site'])->name('delete-site')->middleware(['auth','XSS']);
	Route::any('widget',[WidgetController::class, 'show_widget'])->name('widget')->middleware(['auth','XSS']);
	Route::any('save-widget',[WidgetController::class, 'save_widget'])->name('save-widget')->middleware(['auth','XSS']);
	Route::any('widget-data',[WidgetController::class, 'widget_data'])->name('widget-data')->middleware(['auth','XSS']);
	Route::any('edit-widget',[WidgetController::class, 'edit_widget_data'])->name('edit-widget')->middleware(['auth','XSS']);
	Route::any('aletr',[AlertController::class, 'index'])->name('aletr')->middleware(['auth','XSS']);
	Route::any('save-aletr',[AlertController::class, 'create'])->name('save-aletr')->middleware(['auth','XSS']);
	Route::any('aletr/history',[AlertController::class, 'history'])->name('aletr-history')->middleware(['auth','XSS']);
	Route::any('delete/aletr/history/{id}',[AlertController::class, 'delete_history'])->name('delete-alert-history')->middleware(['auth','XSS']);
	Route::any('report/history',[ReportController::class, 'report_history'])->name('report-history')->middleware(['auth','XSS']);

	Route::any('delete/report/history/{id}',[ReportController::class, 'delete_history'])->name('delete-report-history')->middleware(['auth','XSS']);
	Route::any('show/report/{id}',[ReportController::class, 'show_history'])->name('show-report')->middleware(['auth','XSS']);
	Route::any('quick-view/{id}',[QuickViewController::class, 'quick_view'])->name('quick-view')->middleware(['auth','XSS']);
	Route::any('edit-quick-view-data',[QuickViewController::class, 'edit_quick_view_data'])->name('edit-quick-view-data')->middleware(['auth','XSS']);
	Route::any('save-quick-view-data',[QuickViewController::class, 'save_quick_view_data'])->name('save-quick-view-data')->middleware(['auth','XSS']);
	Route::any('custom-dashboard',[CustomController::class, 'custom_dashboard'])->name('custom-dashboard')->middleware(['auth','XSS']);
	Route::any('get-dimension',[CustomController::class, 'get_dimension'])->name('get-dimension')->middleware(['auth','XSS']);
	Route::any('custom-chat',[CustomController::class, 'custom_chart'])->name('custom-chat')->middleware(['auth','XSS']);
	Route::get('manage-language/{lang}', [LanguageController::class , 'manageLanguage'])->name('manage.language')->middleware(['auth','XSS']);
    Route::get('create-language', [LanguageController::class , 'createLanguage'])->name('create.language')->middleware(['auth','XSS']);
    Route::post('store-language', [LanguageController::class, 'storeLanguage'])->name('store.language')->middleware(['auth','XSS']);
    Route::delete('/lang/{lang}', [LanguageController::class , 'destroyLang'])->name('lang.destroy')->middleware(['auth','XSS']);
    Route::post('store-language-data/{lang}', [LanguageController::class ,'storeLanguageData'])->name('store.language.data')->middleware(['auth','XSS']);
    Route::get('/super_admin/change_lang/{lang}', [LanguageController::class, 'changeLangAdmin'])->name('change_lang_admin')->middleware(['auth','XSS']);
	Route::post('disable-language',[LanguageController::class,'disableLang'])->name('disablelanguage')->middleware(['auth','XSS']);


    Route::get('/company/settings', [CompanySettingController::class, 'settings'])->name('company.settings')->middleware(['auth','XSS']);
	Route::post('/company/settings', [CompanySettingController::class, 'settingsStore'])->name('company.settings.store')->middleware(['auth','XSS']);
	Route::post('/company/system_settings', [CompanySettingController::class, 'SystemsettingsStore'])->name('company.settings.system.store')->middleware(['auth','XSS']);
	Route::post('/company/email/settings', [CompanySettingController::class, 'emailSettingStore'])->name('company.email.settings.store')->middleware(['auth','XSS']);
	Route::any('/company/test/mail', [CompanySettingController::class, 'testmail'])->name('company.test.mail')->middleware(['auth','XSS']);
	Route::any('/company/test/mail/send', [CompanySettingController::class, 'testmailstore'])->name('company.test.email.send')->middleware(['auth','XSS']);
});

Route::any('/cookie-consent', [CompanySettingController::class,'CookieConsent'])->name('cookie-consent');
Route::post('setting/cache',[SettingController::class,'cacheSettings'])->name('cache.settings')->middleware(['auth','XSS']);

Route::get('userlogs',[UserlogController::class,'index'])->name('userlog.index')->middleware(['auth','XSS']);
Route::get('userlogsView/{id}',[UserlogController::class,'view'])->name('userlog.view')->middleware(['auth','XSS']);
Route::delete('userlogsdelete/{id}',[UserlogController::class,'destroy'])->name('userlog.destroy')->middleware(['auth','XSS']);
Route::get('userlogs/getlogdetail/{id}', [UserlogController::class, 'getlogDetail'])->name('userlog.getlogdetail');
