<?php

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

use App\Editing\PageRoutes;
// use App\Http\Controllers\Frontend\Auth\SocialLoginController;
use App\Http\Controllers\Auth\SocialLoginController;
use App\Http\Controllers\SitemapController;
use App\Notifications\Test\TestEmail;
use Illuminate\Notifications;

Auth::routes(['verify' => true]);
// Route::post('/login')->middleware('verified');
/**/
Route::get('/testmail', function () {

    Notification::route('mail', 'malyshev.arman@mail.ru')->notify(new TestEmail('Test'));

});


// Dynamic pages routes
app(PageRoutes::class)->routes();

Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth', 'role:admin']], function () {
    Route::get('/', function () {
        return redirect('admin/dashboard');
    });
    Route::get('dashboard', 'DashboardController@index')->name('home');
    include_route_files(__DIR__ . '/backend/');
});

Route::group(['namespace' => 'Business', 'prefix' => 'cabinet/business', 'as' => 'business.', 'middleware' => ['auth', 'role:user|admin']], function () {
    include_route_files(__DIR__ . '/business/');
});

Route::group(['namespace' => 'Cabinet', 'prefix' => 'cabinet', 'as' => 'cabinet.', 'middleware' => ['auth', 'role:user|admin']], function () {
    Route::get('/', function () {
        return redirect('cabinet/dashboard');
    });
    Route::get('dashboard', 'DashboardController@index')->name('home');
    include_route_files(__DIR__ . '/cabinet/');
});

Route::group(['namespace' => 'Api', 'prefix' => 'api', 'as' => 'api.'], function () {
    Route::group(['namespace' => 'Backend', 'prefix' => 'backend', 'as' => 'backend.', 'middleware' => ['auth', 'role:admin']], function () {
        include_route_files(__DIR__ . '/api/backend/');
    });
    Route::group(['namespace' => 'Frontend', 'prefix' => 'frontend', 'as' => 'frontend.'], function () {
        include_route_files(__DIR__ . '/api/frontend/');
    });
    Route::group(['namespace' => 'Business', 'prefix' => 'cabinet/business', 'as' => 'cabinet.', 'middleware' => ['auth', 'role:user|admin']], function () {
        include_route_files(__DIR__ . '/api/business/');
    });
    Route::group(['namespace' => 'Cabinet', 'prefix' => 'cabinet', 'as' => 'cabinet.', 'middleware' => ['auth', 'role:user|admin']], function () {
        include_route_files(__DIR__ . '/api/cabinet/');
    });
});

// Socialite Routes
Route::get('login/{provider}', [SocialLoginController::class, 'login'])->name('social.login');
Route::get('login/{provider}/callback', [SocialLoginController::class, 'login']);

Route::get('robots.txt', [SitemapController::class, 'robots']);

Route::get('/sitemap', [SitemapController::class, 'sitemap']);

Route::get('/rss', [\App\Http\Controllers\Frontend\Page\PageController::class, 'turbo']);

Route::get('/home', function () {
    return redirect('/');
});

Route::get('sitemap', function () {
    return view('frontend.page.sitemap.sitemap');
});


require __DIR__ . '/users/users.php';
require __DIR__ . '/roles/roles.php';
require __DIR__ . '/roles/permissions.php';
require __DIR__ . '/modules/modules.php';

Route::group(['namespace' => 'Frontend', 'as' => 'frontend.'], function () {
    require __DIR__ . '/frontend/event.php';
    require __DIR__ . '/frontend/company.php';
    require __DIR__ . '/frontend/city.php';
    require __DIR__ . '/frontend/rating.php';
});
