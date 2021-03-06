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

Route::get('/', 'HomeController@index')->name('buyandtravel');
Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

Auth::routes();

Route::group(['prefix' => 'orders'], function(){
	Route::get('/', 'OrderController@index')->name('front.orders.index');
	Route::get('/{id}', 'OrderController@show')->name('front.orders.show');
	Route::get('/downloadPDF/{id}', 'OrderController@downloadPDF')->name('front.orders.pdf');
	Route::get('/{id}/addOffer', 'OrderController@addOffer')->name('front.orders.addOffer');
});

Route::group(['prefix' => 'travel'], function(){
	Route::get('/', 'TravelerController@index')->name('front.travel.index');
	Route::get('/{id}', 'TravelerController@show')->name('front.travel.show');
	Route::get('/downloadPDF/{id}', 'TravelerController@downloadPDF')->name('front.travel.pdf');
	Route::get('/{id}/addRequest', 'TravelerController@addRequest')->name('front.travel.addRequest');
});

Route::group(['prefix' => 'profile', 'namespace' => 'Profile'], function () {

	Route::get('/newmessages', 'MessageController@newMessages');

	Route::resource('messages', 'MessageController');
	Route::post('/messages/storesubject', 'MessageController@storeSubject')->name('messages.store.subject');
	Route::post('/messages/{id}/userslist', 'MessageController@getUsersList');
	Route::get('/messages/{id}/addparticipant/{user}', 'MessageController@addParticipant');
	Route::delete('/messages/{id}/removeparticipant', 'MessageController@removeParticipant')->name('message.remove');
	
	Route::get('/newnotifications', 'NotificationController@newNotifications');

	Route::get('/notifications', 'NotificationController@allNotifications')->name('notifications.index');

	Route::get('/summery', 'ProfileController@index')->name('profile.summery');
	Route::get('/user/verify/{token}', 'ProfileController@verifyUser')->name('user.verify');
	Route::get('/user/verificationlink', 'ProfileController@verificationMail')->name('user.verification');

	Route::resource('orders', 'OrderController');
	Route::post('/orders/image/add', 'OrderController@addImage')->name('order.image.add');
	Route::delete('/orders/image/delete/{id}', 'OrderController@deleteImage')->name('order.image.delete');
	Route::post('/orders/offer/details', 'OrderController@offerDetails');
	Route::post('/orders/offer/accept', 'OrderController@approveOffer')->name('order.offer.accept');
	Route::put('/orders/offer/{id}/recieve', 'OrderController@recieveOffer')->name('order.offer.recieve');
	Route::delete('/orders/offer/{id}/remove', 'OrderController@removeAcceptedOffer')->name('order.offer.remove');

	Route::get('/offers/accepted', 'OfferController@accepted')->name('offers.accepted');
	Route::post('/offers/accepted', 'OfferController@accepted');
	Route::resource('offers', 'OfferController');
	
	Route::resource('travel', 'TravelController');
	Route::post('/travel/request/details', 'TravelController@requestDetails');
	Route::put('/travel/{id}/request/accept', 'TravelController@approveRequest')->name('travel.request.accept');
	Route::put('/travel/{id}/request/remove', 'TravelController@removeApprovedRequest')->name('travel.request.remove');
	
	Route::get('/requests/accepted', 'RequestController@accepted')->name('requests.accepted');
	Route::post('/requests/accepted', 'RequestController@accepted');
	Route::resource('requests', 'RequestController');
	Route::put('/requests/{id}/image/update', 'RequestController@updateImage')->name('requests.image.update');
	Route::put('/requests/{id}/recieve/', 'RequestController@recieveProduct')->name('requests.recieve');
	Route::put('/requests/{id}/recieve/reset', 'RequestController@resetRecieption')->name('requests.recieve.reset');

	Route::group(['prefix' => 'user'], function(){
		Route::get('/', 'ProfileController@userinfo')->name('user.userinfo');
		Route::put('/storeImage/{id}', 'ProfileController@updateImage')->name('user.updateImage');
		Route::get('/edituser', 'ProfileController@edituser')->name('user.edituser');
		Route::put('/updateuser/{id}', 'ProfileController@updateuser')->name('user.updateuser');
		Route::get('/editcontact', 'ProfileController@editcontact')->name('user.editcontact');
		Route::put('/updatecontact/{id}', 'ProfileController@updatecontact')->name('user.updatecontact');
		Route::get('/editpassword', 'ProfileController@editpassword')->name('user.editpassword');
		Route::put('/updatepassword/{id}', 'ProfileController@updatepassword')->name('user.updatepassword');
	});

});
