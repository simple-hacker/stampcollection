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

Route::get('/', 'HomeController@index')->name('welcome');

Auth::routes();

Route::get('/catalogue/{year?}', 'CatalogueController@index')->name('catalogue.year');
Route::get('/catalogue/{issue}/{slug}', 'CatalogueController@issue')->name('catalogue.issue');

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

Route::get('/collection/print', 'CollectionController@print')->middleware('auth')->name('collection.print');
Route::get('/collection/{year?}', 'CollectionController@index')->middleware('auth')->name('collection');
Route::get('/collection/stamp/{stamp}', 'CollectionController@show')->middleware('auth')->name('collection.show');
Route::post('/collection', 'CollectionController@store')->middleware('auth')->name('collection.add');
Route::delete('/collection/{collection}', 'CollectionController@destroy')->middleware('auth')->name('collection.delete');

Route::get('/scraper/issue/{cgbs_issue}', 'ScraperController@issue')->middleware('auth', 'role:admin')->name('scraper.issue');
Route::get('/scraper/issuesByYear/{year}', 'ScraperController@issuesByYear')->middleware('auth', 'role:admin')->name('scraper.year');

Route::get('/search/{query}', 'SearchController@index');

Route::get('/settings/change-password', 'ChangePasswordController@index')->middleware('auth')->name('password.change');
Route::post('/settings/change-password', 'ChangePasswordController@store')->middleware('auth')->name('password.update');

Route::get('/admin', 'AdminController@index')->middleware('auth', 'role:admin')->name('admin.index');

Route::get('/admin/gradings', 'GradingController@index')->middleware('auth', 'role:admin')->name('admin.gradings.index');
Route::post('/admin/gradings', 'GradingController@store')->middleware('auth', 'role:admin')->name('admin.gradings.add');
Route::patch('/admin/gradings', 'GradingController@update')->middleware('auth', 'role:admin')->name('admin.gradings.update');
Route::delete('/admin/gradings/{grading}', 'GradingController@destroy')->middleware('auth', 'role:admin')->name('admin.gradings.delete');

Route::get('/admin/categories', 'IssueCategoryController@index')->middleware('auth', 'role:admin')->name('admin.categories.index');
Route::post('/admin/categories', 'IssueCategoryController@store')->middleware('auth', 'role:admin')->name('admin.categories.add');
Route::patch('/admin/categories', 'IssueCategoryController@update')->middleware('auth', 'role:admin')->name('admin.categories.update');
Route::delete('/admin/categories/{category}', 'IssueCategoryController@destroy')->middleware('auth', 'role:admin')->name('admin.categories.delete');

Route::get('/admin/monarchs', 'MonarchController@index')->middleware('auth', 'role:admin')->name('admin.monarchs.index');
Route::post('/admin/monarchs', 'MonarchController@store')->middleware('auth', 'role:admin')->name('admin.monarchs.add');
Route::patch('/admin/monarchs', 'MonarchController@update')->middleware('auth', 'role:admin')->name('admin.monarchs.update');
Route::delete('/admin/monarchs/{monarch}', 'MonarchController@destroy')->middleware('auth', 'role:admin')->name('admin.monarchs.delete');

