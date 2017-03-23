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
use App\Wrestler;
use App\AltName;
use Illuminate\Support\Facades\Mail;

Route::group(['middlewareGroups' => 'web'], function(){

    /*
    |--------------------------------------------------------------------------
    | Front Pages
    |--------------------------------------------------------------------------*/

    // Home page
    Route::get('/', 'HomeController@index')->name('home');

    // Older posts
    Route::get('/olderposts', 'HomeController@older_posts')->name('older_posts');

    // Post article
    Route::get('article/{id}', 'HomeController@post')->name('read_article');

    // Post comments
    Route::post('post/comment/create', 'PostCommentsController@store_comment')->name('save_comment');

    // Post replies
    Route::post('post/reply/create', 'PostCommentsController@store_reply')->name('save_reply');

    /*
    |----------------------------------------------------------------------------
    | Admin Tool
    |--------------------------------------------------------------------------*/

    // View All Posts
    Route::get('/admin/posts/all', 'AdminPostsController@allposts')->name('all_posts');

    // All posts search
    Route::post('/admin/posts/all_search', 'AdminPostsController@search_posts')->name('all_posts_search');

    // Create post
    Route::get('admin/posts/create', 'AdminPostsController@create')->name('create_post');

    // Edit post
    Route::get('/admin/posts/edit/{id}', 'AdminPostsController@edit')->name('edit_post');

    // Delete post
    Route::get('admin/posts/delete/{id}', 'AdminPostsController@delete')->name('delete_post');

    // Store post
    Route::post('admin/posts/store', 'AdminPostsController@store')->name('store_post');

    // Update post
    Route::post('admin/posts/update/{id}', 'AdminPostsController@update')->name('update_post');

    // Add wrestler
    Route::get('admin/create_wrestler', 'AdminWrestlersController@create_wrestler')->name('create_wrestler');

    // Store wrestler
    Route::post('admin/store_wrestler', 'AdminWrestlersController@store_wrestler')->name('store_wrestler');

    // All wrestlers
    Route::get('admin/all_wrestlers', 'AdminWrestlersController@all_wrestlers')->name('all_wrestlers');

    // Search wrestlers
    Route::post('admin/wrestlers_search', 'AdminWrestlersController@search_wrestlers')->name('all_wrestlers_search');

    // Edit wrestlers
    Route::get('admin/wrestlers/{id}/edit', 'AdminWrestlersController@edit_wrestler')->name('edit_wrestler');

    // Update wrestler
    Route::post('admin/wrestlers/{id}', 'AdminWrestlersController@update_wrestler')->name('update_wrestler');

    // Delete wrestler
    Route::get('admin/wrestlers/{id}/delete', 'AdminWrestlersController@delete_wrestler')->name('delete_wrestler');

    // List of ratings for a wrestler
    Route::get('admin/wrestler_ratings/{id}', 'AdminWrestlerRatingsController@show')->name('all_ratings');

    // Edit wrestler ratings
    Route::get('admin/wrestler_ratings/{id}/edit', 'AdminWrestlerRatingsController@edit')->name('edit_ratings');

    // Update wrestler ratings
    Route::post('admin/wrestler_ratings/{id}', 'AdminWrestlerRatingsController@update')->name('update_ratings');

    // Delete wrestler ratings
    Route::get('admin/wrestler_ratings/delete/{id}', 'AdminWrestlerRatingsController@delete_ratings')->name('delete_ratings');

    // Users resource
    Route::resource('admin/users', 'AdminUsersController');

    // Ban user
    Route::get('admin/users/{id}/ban_user', 'AdminUsersController@ban_user')->name('ban_user');

    // Reinstate user
    Route::get('admin/users/{id}/reinstate_user', 'AdminUsersController@reinstate_user')->name('reinstate_user');

    // Search users
    Route::post('admin/users/search_users', 'AdminUsersController@search_users')->name('search_users');


    /*
    |----------------------------------------------------------------------------
    | Match Rating Tool
    |--------------------------------------------------------------------------*/

    Route::get('/ratingtool', 'MatchRaterController@ratingtool1')->name('rating_tool1');
    Route::post('/ratingtool', 'MatchRaterController@ratingtool2')->name('rating_tool2');
    Route::post('/ratingtool3', 'MatchRaterController@ratingtool3')->name('rating_tool3');
    Route::post('/ratingtool4', 'MatchRaterController@ratingtool4')->name('rating_tool4');


    /*
    |----------------------------------------------------------------------------
    | New Wrestler Rating
    |--------------------------------------------------------------------------*/
    Route::get('/wres_search', 'WrestlerRatingController@wres_search')->name('select_wrestler');
    Route::get('/wres_search_results', 'WrestlerRatingController@wres_search_results')->name('select_wrestler_results');
    Route::post('/wres_rate1', 'WrestlerRatingController@search_result')->name('search_result');
    Route::post('/wres_rate2', 'WrestlerRatingController@new_rating2')->name('new_rating2');
    Route::post('/wres_rate3', 'WrestlerRatingController@new_rating3')->name('new_rating3');
    Route::post('/wres_rate4', 'WrestlerRatingController@new_rating4')->name('new_rating4');
    Route::get('/wres_rate_go/{id}', 'WrestlerRatingController@new_rating_go')->name('new_rating_go');

    /*
    |----------------------------------------------------------------------------
    | Edit Wrestler Rating
    |--------------------------------------------------------------------------*/
    Route::get('/wres_profile/{id}/edit1', 'WrestlerRatingController@edit_rating1')->name('edit_rating1');
    Route::post('/wres_profile/{id}/edit2', 'WrestlerRatingController@edit_rating2')->name('edit_rating2');
    Route::post('/wres_profile/{id}/edit3', 'WrestlerRatingController@edit_rating3')->name('edit_rating3');
    Route::post('/wres_profile/{id}/edit4', 'WrestlerRatingController@edit_rating4')->name('edit_rating4');

    /*
    |----------------------------------------------------------------------------
    | Wrestler Profile
    |--------------------------------------------------------------------------*/
    Route::get('/wres_profile/{id}', 'UserWrestlersController@show')->name('wrestler_profile');

    /*
    |----------------------------------------------------------------------------
    | User Profile
    |--------------------------------------------------------------------------*/
    Route::get('/user_profile', 'UserProfileController@index')->name('user_profile');
    Route::get('/user_profile/my_wrestlers', 'UserProfileController@my_wrestlers')->name('my_wrestlers');



});

Auth::routes();




