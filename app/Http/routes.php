<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */

Route::group(
        ['prefix' => 'v1'], function() {
        // login request
        Route::post('authenticate', 'UserController@authenticate');
        
        // show current logged in users details
        Route::get('users/me', 'UserController@show');
        
        // user resource to enable show, update, delete etc
        Route::resource('users', 'UserController');
        
        Route::resource('api', 'ApiController');
        
        Route::resource('companies', 'CompanyController');
        
        Route::resource('projects', 'ProjectController');
}
);
