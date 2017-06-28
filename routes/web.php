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


Route::group(['middlewareGroups' => 'web'], function(){

    /*
    |--------------------------------------------------------------------------
    | Front Pages
    |--------------------------------------------------------------------------*/

    // Home page
    Route::get('/', 'HomeController@index')->name('home');

    // Post article
    Route::get('article/{id}', 'HomeController@post')->name('read_article');

    // Post comments
    Route::post('post/comment/create', 'PostCommentsController@store_comment')->name('save_post_comment');

    // Post comment replies
    Route::post('post/reply/create', 'PostCommentsController@store_reply')->name('save_post_comment_reply');

    // Create private message
    Route::get('/message/{id}/create', 'PrivateMessagesController@create')->name('create_pm');

    // Store private message
    Route::post('/message/{id}/store', 'PrivateMessagesController@store')->name('store_pm');

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
    Route::delete('admin/posts/delete/{id}', 'AdminPostsController@delete')->name('delete_post');

    // Preview post
    Route::post('/posts/preview', 'AdminPostsController@preview')->name('preview_post');

    // Store post
    Route::get('admin/posts/store', 'AdminPostsController@store')->name('store_post');

    // Update post
    Route::patch('admin/posts/update/{id}', 'AdminPostsController@update')->name('update_post');

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
    Route::patch('admin/wrestlers/{id}', 'AdminWrestlersController@update_wrestler')->name('update_wrestler');

    // Delete wrestler
    Route::delete('admin/wrestlers/{id}/delete', 'AdminWrestlersController@destroy')->name('delete_wrestler');

    // List of ratings for a wrestler
    Route::get('admin/wrestler_ratings/{id}', 'AdminWrestlerRatingsController@show')->name('all_ratings');

    // Edit wrestler ratings
    Route::get('admin/wrestler_ratings/{id}/edit', 'AdminWrestlerRatingsController@edit')->name('edit_ratings');

    // Update wrestler ratings
    Route::patch('admin/wrestler_ratings/{id}', 'AdminWrestlerRatingsController@update')->name('update_ratings');

    // Delete wrestler ratings
    Route::get('admin/wrestler_ratings/delete/{id}', 'AdminWrestlerRatingsController@delete_ratings')->name('delete_ratings');

    // Users resource
    Route::resource('admin/users', 'AdminUsersController');

    // Ban user
    Route::patch('admin/users/{id}/ban_user', 'AdminUsersController@ban_user')->name('ban_user');

    // Ban reports
	Route::get('admin/bans', 'AdminUsersController@ban_reports')->name('ban_reports');

    // Reinstate user
    Route::patch('admin/users/{id}/reinstate_user', 'AdminUsersController@reinstate_user')->name('reinstate_user');

    // Search users
    Route::post('admin/users/search_users', 'AdminUsersController@search_users')->name('search_users');

    // See ratings for user
    Route::get('admin/users/{id}/ratings', 'AdminUsersController@see_ratings')->name('see_ratings');

    // See posts by user
    Route::get('admin/users/{id}/posts', 'AdminUsersController@see_posts')->name('see_posts');

    // Search posts by user
    Route::post('admin/users/{id}/post_search', 'AdminUsersController@user_posts_search')->name('user_posts_search');

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
    Route::patch('/wres_profile/{id}/edit4', 'WrestlerRatingController@edit_rating4')->name('edit_rating4');

    /*
    |----------------------------------------------------------------------------
    | Wrestler Profile
    |--------------------------------------------------------------------------*/
    Route::get('/wres_profile/{id}', 'UserWrestlersController@show')->name('wrestler_profile');
    Route::get('/wres_profile/fav/{id}', 'UserWrestlersController@favorite')->name('wrestler_fav');
    Route::get('/wres_profile/unfollow/{id}', 'UserWrestlersController@unfollow')->name('wrestler_unfollow');
    Route::post('/wres_profile/comment', 'UserWrestlersController@store_comment')->name('save_wrestler_comment');
    Route::post('/wres_profile/reply', 'UserWrestlersController@store_reply')->name('save_wrestler_comment_reply');

    /*
    |----------------------------------------------------------------------------
    | User Dashboard
    |--------------------------------------------------------------------------*/

    // user dashboard
    Route::get('/user_dashboard', 'UserDashboardController@index')->name('user_dashboard');

    // My wrestlers page
    Route::get('/user_dashboard/my_ratings', 'UserDashboardController@my_wrestlers')->name('my_wrestlers');
    Route::get('/user_dashboard/my_favorites', 'UserDashboardController@my_favorites')->name('my_favorites');
    Route::delete('/user_dashboard/my_ratings/{id}/delete_rating', 'UserDashboardController@delete_rating')->name('user_delete_rating');
    Route::get('/user_dashboard/my_favorite/{id}/remove', 'UserDashboardController@remove_favorite')->name('remove_favorite');


    // Private messages index
    Route::get('/user_dashboard/messages', 'PrivateMessagesController@see_messages')->name('pm_index');

    // Show private message
    Route::get('user_dashboard/message/{id}', 'PrivateMessagesController@show')->name('pm_show');

    // Private message reply
    Route::post('user_dashboard/message/reply', 'PrivateMessagesController@send_reply')->name('send_pm_reply');

    // Private message delete
    Route::delete('user_dashboard/messages/{id}/delete', 'PrivateMessagesController@destroy')->name('delete_pm');

    // Edit User from user dashboard
    Route::get('user_dashboard/edit', 'UserDashboardController@edit_user')->name('dashboard_edit_user');

    // update user from dashboard
    Route::patch('user_dashboard/store_user', 'UserDashboardController@update_user')->name('dashboard_update_user');


    /*
    |----------------------------------------------------------------------------
    | User Profile
    |--------------------------------------------------------------------------*/

    Route::get('user_profile/{id}/show', 'UserProfileController@show')->name('user_profile')->middleware('auth');;
    Route::post('user_profile/{id}/block', 'UserProfileController@block_user')->name('block_user')->middleware('auth');
	Route::post('user_profile/{id}/unblock', 'UserProfileController@unblock_user')->name('unblock_user')->middleware('auth');


    /*
   |----------------------------------------------------------------------------
   | Password resets
   |--------------------------------------------------------------------------*/
    Route::post('password_reset/store', 'PasswordResetController@store')->name('password_reset_store');
    Route::get('password_reset/{id}/new_password/{key}', 'PasswordResetController@new_password')->name('new_password_reset');
    Route::post('password_reset/{id}/change/{key}', 'PasswordResetController@change_password')->name('change_password');

    Route::get('test/event', function(){
        event(new \App\Events\EchoTest("This is an event fired!"));
    });

});

Auth::routes();







