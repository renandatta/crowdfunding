<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;

Route::get('storage/{folder}/{filename}', function ($folder,$filename){
    $path = storage_path('app/' . $folder . '/' . $filename);
    if (!File::exists($path)) {
        abort(404);
    }
    $file = File::get($path);
    $type = File::mimeType($path);
    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);
    return $response;
});

Route::get('/', 'HomeController@index')->name('/');

Route::get('login', 'AuthController@login')->name('login');
Route::post('login', 'AuthController@login_process')->name('login.process');
Route::get('logout', 'AuthController@logout')->name('logout');
Route::get('register', 'AuthController@register')->name('register');
Route::post('register', 'AuthController@register_process')->name('register.process');

Route::get('campaign', 'HomeController@campaign')->name('campaign');
Route::get('campaign/search', 'HomeController@search')->name('campaign.search_menu');
Route::get('campaign/{slug}', 'HomeController@campaign_detail')->name('campaign.detail');
Route::get('campaign/category/{slug}', 'HomeController@category')->name('campaign.category');

Route::get('campaign/{slug}/donate', 'HomeController@campaign_donate')->name('campaign.donate')->middleware('auth');
Route::post('campaign/{slug}/donation/save', 'HomeController@campaign_donation_save')->name('campaign.donation.save')->middleware('auth');
Route::post('campaign/{slug}/discussion/save', 'HomeController@campaign_discussion_save')->name('campaign.discussion.save')->middleware('auth');

Route::post('campaign', 'HomeController@campaign_search')->name('campaign.search');

Route::get('faq', 'HomeController@faq')->name('faq');
Route::get('about', 'HomeController@about')->name('about');
Route::get('contact', 'HomeController@contact')->name('contact');

Route::get('profile', 'HomeController@profile')->name('profile');

Route::get('profile/edit', 'HomeController@profile_edit')->name('profile.edit');
Route::post('profile/save', 'HomeController@profile_save')->name('profile.save');

Route::get('profile/edit_password', 'HomeController@profile_edit_password')->name('profile.edit_password');
Route::post('profile/save_password', 'HomeController@profile_save_password')->name('profile.save_password');

Route::get('donation_history', 'HomeController@donation_history')->name('donation_history');
Route::get('discussion_history', 'HomeController@discussion_history')->name('discussion_history');

Route::middleware('user_level')->group(function (){
    Route::get('admin', 'AdminController@index')->name('admin');

    Route::get('admin/user', 'AdminUserController@index')->name('admin.user');
    Route::post('admin/user/search', 'AdminUserController@search')->name('admin.user.search');
    Route::get('admin/user/info/{id}', 'AdminUserController@info')->name('admin.user.info');
    Route::post('admin/user/save/{id}', 'AdminUserController@save')->name('admin.user.save');
    Route::delete('admin/user/info/{id}', 'AdminUserController@delete')->name('admin.user.delete');

    Route::get('admin/campaign_type', 'AdminCampaignTypeController@index')->name('admin.campaign_type');
    Route::post('admin/campaign_type/search', 'AdminCampaignTypeController@search')->name('admin.campaign_type.search');
    Route::get('admin/campaign_type/info/{id}', 'AdminCampaignTypeController@info')->name('admin.campaign_type.info');
    Route::post('admin/campaign_type/save/{id}', 'AdminCampaignTypeController@save')->name('admin.campaign_type.save');
    Route::delete('admin/campaign_type/info/{id}', 'AdminCampaignTypeController@delete')->name('admin.campaign_type.delete');

    Route::get('admin/payment_type', 'AdminPaymentTypeController@index')->name('admin.payment_type');
    Route::post('admin/payment_type/search', 'AdminPaymentTypeController@search')->name('admin.payment_type.search');
    Route::get('admin/payment_type/info/{id}', 'AdminPaymentTypeController@info')->name('admin.payment_type.info');
    Route::post('admin/payment_type/save/{id}', 'AdminPaymentTypeController@save')->name('admin.payment_type.save');
    Route::delete('admin/payment_type/info/{id}', 'AdminPaymentTypeController@delete')->name('admin.payment_type.delete');

    Route::get('admin/campaign', 'AdminCampaignController@index')->name('admin.campaign');
    Route::post('admin/campaign/search', 'AdminCampaignController@search')->name('admin.campaign.search');
    Route::get('admin/campaign/info/{id}', 'AdminCampaignController@info')->name('admin.campaign.info');
    Route::post('admin/campaign/save/{id}', 'AdminCampaignController@save')->name('admin.campaign.save');
    Route::delete('admin/campaign/info/{id}', 'AdminCampaignController@delete')->name('admin.campaign.delete');
    Route::get('admin/campaign/detail/{id}', 'AdminCampaignController@detail')->name('admin.campaign.detail');

    Route::get('admin/campaign/detail/{campaignId}/info/{id}', 'AdminCampaignDetailController@info')->name('admin.campaign.detail.info');
    Route::post('admin/campaign/detail/{campaignId}/save/{id}', 'AdminCampaignDetailController@save')->name('admin.campaign.detail.save');
    Route::get('admin/campaign/detail/{campaignId}/delete/{id}', 'AdminCampaignDetailController@delete')->name('admin.campaign.detail.delete');

    Route::get('admin/campaign/detail/{campaignId}/faq/info/{id}', 'AdminCampaignFaqController@info')->name('admin.campaign.detail.faq.info');
    Route::post('admin/campaign/detail/{campaignId}/faq/save/{id}', 'AdminCampaignFaqController@save')->name('admin.campaign.detail.faq.save');
    Route::get('admin/campaign/detail/{campaignId}/faq/delete/{id}', 'AdminCampaignFaqController@delete')->name('admin.campaign.detail.faq.delete');

    Route::get('admin/campaign/detail/{campaignId}/update/info/{id}', 'AdminCampaignUpdateController@info')->name('admin.campaign.detail.update.info');
    Route::post('admin/campaign/detail/{campaignId}/update/save/{id}', 'AdminCampaignUpdateController@save')->name('admin.campaign.detail.update.save');
    Route::get('admin/campaign/detail/{campaignId}/update/delete/{id}', 'AdminCampaignUpdateController@delete')->name('admin.campaign.detail.update.delete');

    Route::get('admin/campaign/detail/{campaignId}/discussion/info/{id}', 'AdminCampaignDiscussionController@info')->name('admin.campaign.detail.discussion.info');
    Route::post('admin/campaign/detail/{campaignId}/discussion/save/{id}', 'AdminCampaignDiscussionController@save')->name('admin.campaign.detail.discussion.save');
    Route::get('admin/campaign/detail/{campaignId}/discussion/delete/{id}', 'AdminCampaignDiscussionController@delete')->name('admin.campaign.detail.discussion.delete');

    Route::get('admin/donation', 'AdminDonationController@index')->name('admin.donation');
    Route::post('admin/donation/search', 'AdminDonationController@search')->name('admin.donation.search');

    Route::get('admin/donation/{id}/verify', 'AdminDonationController@verify')->name('admin.verify');
});
