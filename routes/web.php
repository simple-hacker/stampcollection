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

Route::get('/browse/{year}', 'BrowseController@index')->name('browse.year');
Route::get('/browse/{issue}/{slug}', 'BrowseController@issue')->name('browse.issue');
// Route::get('/browse/issue/{issue}/stamp/{stamp}', 'BrowseController@stamp');

Route::get('/issue/create/{year?}', 'IssueController@index')->middleware('auth', 'role:admin')->name('create.issue');
Route::post('/issue', 'IssueController@store')->middleware('auth', 'role:admin')->name('add.issue');
Route::get('/issue/{issue}/edit', 'IssueController@edit')->middleware('auth', 'role:admin')->name('edit.issue');
Route::post('/issue/{issue}', 'IssueController@update')->middleware('auth', 'role:admin')->name('update.issue');
Route::delete('/issue/{issue}', 'IssueController@destroy')->middleware('auth')->name('delete.issue');

Route::get('/issue/{issue}/stamp/create', 'StampController@create')->middleware('auth', 'role:admin')->name('create.stamp');
Route::post('/issue/{issue}/stamp', 'StampController@store')->middleware('auth', 'role:admin')->name('add.stamp');
Route::get('/stamp/{stamp}/edit', 'StampController@edit')->middleware('auth', 'role:admin')->name('edit.stamp');
Route::post('/stamp/{stamp}', 'StampController@update')->middleware('auth', 'role:admin')->name('update.stamp');
Route::delete('/stamp/{stamp}', 'StampController@destroy')->middleware('auth', 'role:admin')->name('delete.stamp');

Route::get('/collection', 'CollectionController@show')->middleware('auth')->name('collection');
Route::post('/collection/{stamp}', 'CollectionController@store')->middleware('auth')->name('collection.add');
Route::delete('/collection/{stamp}', 'CollectionController@destroy')->middleware('auth')->name('collection.delete');

Route::get('/scraper/issue/{cgbs_issue}', 'ScraperController@issue')->middleware('auth', 'role:admin')->name('scraper.issue');
Route::get('/scraper/issuesByYear/{year}', 'ScraperController@issuesByYear')->middleware('auth', 'role:admin')->name('scraper.year');
