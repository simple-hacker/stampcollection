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

Route::get('/catalogue/{year}', 'CatalogueController@index')->name('catalogue.year');
Route::get('/catalogue/{issue}/{slug}', 'CatalogueController@issue')->name('catalogue.issue');
// Route::get('/browse/issue/{issue}/stamp/{stamp}', 'CatalogueController@stamp');

Route::get('/issue/create/{year?}', 'IssueController@create')->middleware('auth', 'role:admin')->name('issue.create');
Route::post('/issue', 'IssueController@store')->middleware('auth', 'role:admin')->name('issue.add');
Route::get('/issue/{issue}/edit', 'IssueController@edit')->middleware('auth', 'role:admin')->name('issue.edit');
Route::post('/issue/{issue}', 'IssueController@update')->middleware('auth', 'role:admin')->name('issue.update');
Route::delete('/issue/{issue}', 'IssueController@destroy')->middleware('auth')->name('issue.delete');

Route::get('/issue/{issue}/stamp/create', 'StampController@create')->middleware('auth', 'role:admin')->name('stamp.create');
Route::post('/issue/{issue}/stamp', 'StampController@store')->middleware('auth', 'role:admin')->name('stamp.add');
Route::get('/stamp/{stamp}/edit', 'StampController@edit')->middleware('auth', 'role:admin')->name('stamp.edit');
Route::post('/stamp/{stamp}', 'StampController@update')->middleware('auth', 'role:admin')->name('stamp.update');
Route::delete('/stamp/{stamp}', 'StampController@destroy')->middleware('auth', 'role:admin')->name('stamp.delete');

Route::get('/collection', 'CollectionController@index')->middleware('auth')->name('collection');
Route::get('/collection/{stamp}/{slug}', 'CollectionController@show')->middleware('auth')->name('collection.show');
Route::post('/collection/{stamp}', 'CollectionController@store')->middleware('auth')->name('collection.add');
Route::delete('/collection/{collection}', 'CollectionController@destroy')->middleware('auth')->name('collection.delete');

Route::get('/scraper/issue/{cgbs_issue}', 'ScraperController@issue')->middleware('auth', 'role:admin')->name('scraper.issue');
Route::get('/scraper/issuesByYear/{year}', 'ScraperController@issuesByYear')->middleware('auth', 'role:admin')->name('scraper.year');
