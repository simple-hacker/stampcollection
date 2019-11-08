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
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/browse/{year}', 'BrowseController@index');
Route::get('/browse/{issue}/{slug}', 'BrowseController@issue')->name('browse.issue');
// Route::get('/browse/issue/{issue}/stamp/{stamp}', 'BrowseController@stamp');

Route::post('/issue', 'IssueController@store')->middleware('auth', 'role:admin');
Route::post('/issue/{issue}', 'IssueController@update')->middleware('auth');

Route::post('/stamp', 'StampController@store')->middleware('auth', 'role:admin');

Route::get('/collection', 'CollectionController@show')->middleware('auth');
Route::post('/collection/{stamp}', 'CollectionController@store')->middleware('auth')->name('collection.add');
Route::delete('/collection/{stamp}', 'CollectionController@destroy')->middleware('auth');

Route::get('/scraper/issue/{cgbs_issue}', 'ScraperController@issue')->middleware('auth', 'role:admin');
Route::get('/scraper/issuesByYear/{year}', 'ScraperController@issuesByYear')->middleware('auth', 'role:admin');
