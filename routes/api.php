<?php

use Illuminate\Http\Request;
use App\Http\Controllers\TopicController;
use Illuminate\Database\Console\Migrations\RollbackCommand;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::group(['prefix' => 'v1', 'middleware' => 'cors'], function () {
    Route::get('/news', 'NewsController@getNews');

    Route::post('/news', 'NewsController@storeNews');

    Route::get('/news/{news_id}', 'NewsController@showNews');

    Route::put('/news/{news_id}', 'NewsController@updateNews');

    Route::delete('/news/{news_id}', 'NewsController@destroyNews');

    Route::get('/topics', 'TopicController@getTopic');

    Route::post('/topics', 'TopicController@storeTopic');

    Route::get('topics/{topic_id}', 'TopicController@showTopic');

    Route::delete('/topics/{topic_id}', 'TopicController@destroyTopic');

    Route::post('/user/register', 'AuthController@register');

    Route::post('/user/signin', 'AuthController@signin');

});
