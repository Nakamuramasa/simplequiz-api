<?php

Route::get('me', 'User\MeController@getMe');
Route::get('information', 'Quiz\InformationController@index');
Route::get('ranking', 'Quiz\RankingController@index');

Route::group(['middleware' => ['auth:api']], function(){
    Route::post('logout', 'Auth\LoginController@logout');
    Route::put('settings/password', 'User\SettingsController@updatePassword');

    Route::get('quiz', 'Quiz\QuizController@index');
    Route::post('insertRanking', 'Quiz\RankingController@insertRanking');
    Route::get('mypage', 'User\MypageController@index');
});

Route::group(['middleware' => ['guest:api']], function(){
    Route::post('register', 'Auth\RegisterController@register');
    Route::post('verification/verify/{user}', 'Auth\VerificationController@verify')->name('verification.verify');
    Route::post('verification/resend', 'Auth\VerificationController@resend');
    Route::post('login', 'Auth\LoginController@login');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');
});
