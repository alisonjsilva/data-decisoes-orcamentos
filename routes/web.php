<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
Auth::routes(['register' => false]);

Route::get('/', function () {
    // return view('admin.createProposal');
    return view('home');
});

Route::get('api/service', 'ServiceController@listOfServices');
Route::get('api/services/{catid}', 'ServiceController@servicesByCategory');
Route::get('api/categories', 'CategoryController@listOfServices');
Route::get('api/services/package/{id}', 'ServiceController@servicesByPackageId')->name('packageById');
Route::get('api/packages', 'PackageController@packages')->name('apiPackages');
Route::get('api/suppliers', 'SupplierController@listOfSuppliers');
Route::get('api/materials', 'MaterialController@listOfMaterials');

Route::get('api/materialsorders/destroy/{id}', 'MaterialsOrdersController@destroyAjax');

Route::resource('service', 'ServiceController');
Route::get('api/services/materials/{id}', 'ServiceController@materialsByServiceId')->name('materialsByServiceId');

Route::resource('category', 'CategoryController');

Route::resource('division', 'DivisionController' );

Route::resource('package', 'PackageController' );

Route::resource('material', 'MaterialController' );

Route::resource('supplier', 'SupplierController' );

Route::get('order/export/{id}', 'OrderController@exportOrderById')->name('exportorderbyid');
Route::get('order/export', 'OrderController@exportOrder');
Route::resource('order', 'OrderController' );
Route::get('api/order/createorder/{id}', 'OrderController@createOrderFromProposal');


Route::resource('proposal', 'ProposalController' );
Route::post('api/proposal/saveAjax','ProposalController@postProposalAjax');
Route::post('api/proposal/updateAjax','ProposalController@updateProposalAjax');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

