<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'pages/index')->name('index');
Route::post('/register', 'AuthController@register')->name('register');
Route::post('/login', 'AuthController@login')->name('login');
Route::get('/logout', 'AuthController@logout')->name('logout');

Route::group(['prefix' => 'admin', 'middleware' => 'guest:ROLE_ADMIN'], function () {
    Route::get('/users', 'UserController@index')->name('users.index');
    Route::get('/users/create', 'UserController@create')->name('users.create');
    Route::post('/users', 'UserController@store')->name('users.store');
    Route::get('/users/{user}/edit', 'UserController@edit')->name('users.edit');
    Route::patch('/users/{user}', 'UserController@update')->name('users.update');
    Route::get('/hospitals', 'HospitalController@index')->name('hospitals.index');
    Route::get('/hospitals/create', 'HospitalController@create')->name('hospitals.create');
    Route::get('/hospitals/{hospital}', 'HospitalController@show')->name('hospitals.show');
    Route::post('/hospitals', 'HospitalController@store')->name('hospitals.store');
    Route::get('/hospitals/{hospital}/edit', 'HospitalController@edit')->name('hospitals.edit');
    Route::patch('/hospitals/{hospital}', 'HospitalController@update')->name('hospitals.update');
    Route::delete('/hospitals/{hospital}', 'HospitalController@destroy')->name('hospitals.destroy');
    Route::get('/cities', 'CityController@index')->name('cities.index');
    Route::get('/cities/create', 'CityController@create')->name('cities.create');
    Route::post('/cities', 'CityController@store')->name('cities.store');
    Route::get('/cities/{city}/edit', 'CityController@edit')->name('cities.edit');
    Route::patch('/cities/{city}', 'CityController@update')->name('cities.update');
    Route::delete('/cities/{city}', 'CityController@destroy')->name('cities.destroy');
    Route::post('/{declaration}/questions', 'QuestionController@store')->name('questions.store');
    Route::get('/questions/{question}/edit', 'QuestionController@edit')->name('questions.edit');
    Route::patch('/questions/{question}', 'QuestionController@update')->name('questions.update');
    Route::delete('/questions/{question}', 'QuestionController@destroy')->name('questions.destroy');
    Route::get('/declarations', 'DeclarationController@index')->name('declarations.index');
    Route::get('/declarations/create', 'DeclarationController@create')->name('declarations.create');
    Route::post('/declarations', 'DeclarationController@store')->name('declarations.store');
    Route::get('/declarations/{declaration}', 'DeclarationController@show')->name('declarations.show');
    Route::get('/declarations/{declaration}/edit', 'DeclarationController@edit')->name('declarations.edit');
    Route::patch('/declarations/{declaration}', 'DeclarationController@update')->name('declarations.update');
    Route::delete('/declarations/{declaration}', 'DeclarationController@destroy')->name('declarations.destroy');
    Route::patch('/declarations/{declaration}/activity', 'DeclarationController@updateActivity')->name('declarations.update.activity');
    Route::get('/quantity-blood', 'DonationController@quantityBlood')->name('quantity.blood');
});

Route::group(['prefix' => 'super-doctor', 'middleware' => 'guest:ROLE_SUPERDOCTOR'], function () {
    Route::get('/declarations', 'DonationController@indexDoctor')->name('declarations.index.doctor');
    Route::get('/declarations/{donation}', 'DonationController@showDoctor')->name('declarations.show.doctor');
    Route::patch('/declarations/{donation}', 'DonationController@updateDoctor')->name('declarations.update.doctor');
    Route::delete('/declarations/{donation}', 'DonationController@destroy')->name('declarations.destroy.doctor');
});

Route::group(['middleware' => 'guest:ROLE_DOCTOR'], function () {
    Route::get('doctor/patients', 'PatientController@indexHospital')->name('patients.index.hospital');
    Route::get('doctor/need-blood/create', 'PatientController@create')->name('patients.create');
    Route::post('doctor/need-blood', 'PatientController@store')->name('patients.store');
});

Route::group(['middleware' => 'guest:ROLE_ADMIN,ROLE_DOCTOR'], function () {
    Route::delete('users/{user}', 'UserController@destroy')->name('users.destroy');
    Route::get('need-blood/{user}/edit', 'PatientController@edit')->name('patients.edit');
    Route::patch('need-blood/{user}/edit', 'PatientController@update')->name('patients.update');
});


Route::group(['middleware' => 'guest:ROLE_LABORANT'], function () {
    Route::get('laborant/results', 'DonationController@indexLaborant')->name('donations.index.laborant');
    Route::patch('laborant/{donation}', 'DonationController@updateLaborant')->name('donations.update.laborant');
});

Route::group(['middleware' => 'guest:ROLE_USER,ROLE_LABORANT,ROLE_ADMIN,ROLE_SUPERDOCTOR,ROLE_DOCTOR'], function () {
    Route::get('donor/step-1', 'AnswerController@stepOne')->name('answers.step.one');
    Route::post('donor/step-1', 'AnswerController@storeOne')->name('answers.store.one');
    Route::get('donor/step-2', 'AnswerController@StepTwo')->name('answers.step.two');
    Route::post('donor/step-2', 'AnswerController@storeTwo')->name('answers.store.two');
    Route::get('donor/step-2/autoload', 'AnswerController@autoload')->name('answers.autoload');
    Route::get('user/profile', 'UserController@profile')->name('profile');
    Route::patch('user/profile/{user}', 'UserController@updateProfile')->name('users.update.profile');
    Route::get('/need-blood/list', 'PatientController@index')->name('patients.index');
    Route::get('user/results', 'UserController@results')->name('results');
});
