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

Route::get('/', function () {
    return view('welcome');
})->name('welcome');


//--------------------------------------------------------------------------------------------
Route::get('/test', function () {
    return view('test');
});

Route::post('test','testc@test');


//---------------------------------------------------------------------------------------------------


Auth::routes(['verify' => true]);
Route::group(['middleware' => 'user_verified'], function(){
Route::get('recovery','RecoveryController@recover')->name('recovery');
Route::group(['middleware' => 'auth'], function () {

    Route::group(['middleware' => 'active'], function () {

        Route::get('/activate-email/{user}', function (Request $request) {
            if (!$request->hasValidSignature()) {
                abort(401, 'This link is not valid.');
            }

            $request->user()->update([
                'activated' => true
            ]);

            return 'Your account is now activated!';
        })->name('activate-email');
        Route::get('/home', 'HomeController@index')->name('home');
        Route::namespace('Admin')->prefix('admin')->name('admin.')->middleware('can:manage-users')->group(function(){
            Route::get('history','HistoryController@index')->name('history.index');
            Route::resource('/users','UsersController', ['except' => ['show' , 'create', 'store']]);
            Route::get('/users/activate/{user}','UsersController@activate')->name('users.activate');
            Route::get('/users/deactivate/{user}','UsersController@deactivate')->name('users.deactivate');
            Route::resource('/preferences','PreferencesController');
            Route::post('/preferences','PreferencesController@change')->name('preferences.change');
        });
        Route::namespace('Monitor')->prefix('monitor')->name('monitor.')->middleware('can:manage-workshop')->group(function(){
            Route::get('history','HistoryController@index')->name('history.index');
            Route::group(['middleware' => 'active_workshop2'], function () {
                Route::get('/result', function () {
                    return view('monitor.result');
                })->name('result');
                Route::post('/createGroup', 'createGroupController@createGroup')->name('createGroup');
                Route::post('/result', 'resultController@result')->name('getResult');
                Route::get('end','exitController@end')->name('end');
                Route::get('/groups','groups@index')->name('groups');
                Route::post('/groups','groups@update')->name('groups.update');
                Route::post('groups/kick/{group}/{user}','groups@kick')->name('groups.kick');
                Route::post('groups/authenticate','groups@authenticate')->name('groups.authenticate');
            });
            Route::post('/workshopst','WorkshopHome@start')->name('startWorkshop');
            Route::post('/RemoveUser/{user}', 'WorkshopHome@RemoveUser')->name('remove');
            Route::post('/workshop','WorkshopHome@index')->name('Workshop');
            Route::get('/workshop','WorkshopHome@update')->name('workshops');
            Route::get('/creationWorkshop', function () {
                if(session('workshop_id'))
                    return redirect()->back();
                return view('monitor.creation');
            })->name('create');
            Route::post('/created', 'workshopc@create')->name('creation');
            Route::get('exit','exitController@exit')->name('exit');


        });
        Route::namespace('Participant')->prefix('participant')->name('participant.')->middleware('can:participate-workshop')->group(function(){
            Route::get('history','HistoryController@index')->name('history.index');
            Route::post('/testActive','testActiveController@testActive');
            Route::get('nextstage', 'groupController@nextStage')->name('nextstage');
            Route::group(['middleware' => 'participate_workshop'], function () {
                Route::get('/userMakekey', function () {
                    return view('participant.userMakeKey');
                })->name('usermakekey');
            });
            Route::group(['middleware' => 'wait_active'], function () {
            Route::get('/workshop', function () {
                return view('participant.workshop');
            })->name('workshop');
        });
        Route::get('continue', 'ContinueController@continue')->name('continue');
        Route::post('youridea', 'Userkey@testKey')->name('userkey');
                Route::group(['middleware' => 'active_workshop'], function () {
                    Route::group(['middleware' => 'active_workshop_participant'], function () {

            Route::group(['middleware' => 'firststage'],function(){
            Route::get('youridea',function(){
                return view('participant.ideas');
            })->name('useridea');
            Route::post('wait', 'IdeaSubmit@submit')->name('ideasubmit');
            Route::get('/wait', function () {
                if(!session('i'))
                    session(['i' => 1]);
                return view('participant.wait');
            })->name('wait');
            Route::post('notify', 'notifyController@notify')->name('notification');
            Route::post('updateScore', 'updateScoreController@updatescore')->name('updateScore');
            Route::post('testStep', 'testStepController@testStep')->name('testStep');
            });
        Route::group(['middleware' => 'secondstage'],function(){

            Route::post('ChooseGroup', 'groupController@insertInGroup')->name('insertInGroup');
            Route::post('testGroup', 'groupController@testGroup')->name('test');
            Route::get('chooseGroup','groupController@index')->name('chooseGroup');
            Route::post('unregister','groupController@unregister')->name('unregister');
            });
        });
    });
        Route::group(['middleware' => 'secondstage'],function(){

            Route::get('workonidea','groupController@workon')->name('workon');
            Route::post('workonidea','groupController@isKicked')->name('iskicked');
        });
            Route::get('exit','exitController@exit')->name('exit');
        });
    });
        Route::get('/not-enabled',function(){
            if(auth()->user()->activated){
                return redirect()->route('home');

            }
            return view('blocked');
        });

});
});
