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
Route::get('/logout', 'userLogin@logout');
Route::get('/', function () {
  return redirect('login');
});
Route::get('/login', function () {
  return view('login');
})->name('login');

Route::group(['middleware' => ['guest']], function () {
  Route::get('/login', function () {
    return view('login');
  })->name('login');
  Route::post('/login', 'userLogin@authentication');
  Route::get('/request-changes/{member_uid}', 'requestChanges@view');
  Route::get('/request-changes', function () {
    return view('request_changes');
  });
  Route::post('/request-changes', 'requestChanges@change');
  Route::get('/generate/{uid}', 'issueCertificates@download');
  Route::get('/claim', 'claimCertificates@view');
  Route::post('/claim', 'claimCertificates@download');
  Route::get('/claim-certificate', 'claimCertificates@download');
  Route::get('/generate-email-certificate/{uid}', 'issueCertificates@download');
  Route::get('/error', function () {
    return view('error');
  });
});

Route::group(['middleware' => ['auth']], function () {
  Route::get('/email/{emailType}', 'TestEmail@test');
  Route::get('/dashboard', 'dashboard@view');
  Route::get('/import-attendees', 'importAttendees@view');
  Route::get('/attendees', 'attendeesPage@view');
  Route::get('/teams', 'attendeesPage@viewTeam');
  Route::get('/issue-certificates', 'issueCertificates@view');
  Route::get('/issued-certificates', 'issueCertificates@issuedView');
  Route::get('/pending-certificates', 'issueCertificates@pendingCertificateView');
  Route::get('/search', 'issueCertificates@view');
  Route::get('/issue/{uid}', 'issueCertificates@issue');
  Route::get('/requested-changes', 'requestedChanges@view');
  Route::get('/requested-changes/{action}/{id}', 'requestedChanges@action');
  Route::get('/approved-changes', 'requestedChanges@viewApproved');
  // Route::get('/issue-certificates','issueCertificates@download');
  Route::post('/import-attendees', 'importAttendees@upload');
  Route::get('/generate-certificate/{uid}', 'issueCertificates@download');
});
