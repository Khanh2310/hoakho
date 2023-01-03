<?php

//LOGIN

use App\Action;
use App\Admin_Action_Category;
use App\Http\Controllers\StorageController;
use App\Http\Controllers\StorageProductController;
use App\Mail\verify;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;

// SHIPPER
Route::get('/login_shipper', 'ShipperController@show_login');
Route::post('/process_login_shipper', 'ShipperController@process_login');
Route::get('/delivering', 'ShipperController@all_order_delivering')->middleware('delivery');
Route::get('/order_detail/{order_id}', 'ShipperController@order_detail')->middleware('delivery');
Route::post('/shipper/confirm_delivery_order_success', 'ShipperController@confirm_delivery_order_success');
Route::post('/shipper/confirm_delivery_order_fail', 'ShipperController@confirm_delivery_order_fail');
Route::get('/logout_shipper', 'ShipperController@logout_shipper');

// LOGIN SOCIAL
Route::get('/login_facebook', 'LoginSocialController@login_facebook');
Route::get('/callback', 'LoginSocialController@callback_facebook');

Route::get('login_google', 'LoginSocialController@login_google');
Route::get('/google/callback', 'LoginSocialController@callback_google');

// LOGIN ADDMIN
Route::get('login', 'AuthController@show_login');
Route::post('process_login', 'AuthController@process_login');
Route::get('logout_admin', 'AuthController@logout_admin');

// LOGIN CLIENT
Route::get('login_client', 'CustomerController@show_login');
Route::post('process_login_client', 'CustomerController@process_login');
Route::get('register_client', 'CustomerController@show_register');
Route::get('process_register_client/{username}/{email}/{password}', 'CustomerController@process_register');
Route::get('logout_client', 'CustomerController@logout_client');

Route::get('mail_reset_password', 'CustomerController@mail_reset_password');
Route::post('process_mail_reset_password', 'CustomerController@process_mail_reset_password');
Route::get('reset_password/{customer_id}', 'CustomerController@reset_password');
Route::post('process_reset_password/{customer_id}', 'CustomerController@process_reset_password');
Route::post('mail_register_client', 'CustomerController@mail_register_client');

Route::get('verify_account', 'CustomerController@verify_account');
Route::get('error_process_register', 'CustomerController@error_process_register');
Route::get('success_process_register', 'CustomerController@success_process_register');


// MIDDLEWARE PAGE ADMIN
// Route::group(['middleware'=>'roles'], function(){
//
// });

// GROUP ADMIN
Route::prefix('admin')->group(function () {
    // DASHBORD
    Route::get('/', 'DashboardController@index')->middleware('admin_manager_employee');
    Route::post('auto_load_data_dashboard', 'DashboardController@auto_load_data_dashboard')->middleware('admin_manager_employee');
    Route::post('filer_year_order_dashboard', 'DashboardController@filer_year_order_dashboard')->middleware('admin_manager_employee');
    Route::post('filer_year_revenue_dashboard', 'DashboardController@filer_year_revenue_dashboard')->middleware('admin_manager_employee');
    Route::post('print_pdf_dashbpard_revenue_daily', 'DashboardController@print_pdf_dashbpard_revenue_daily')->middleware('admin_manager_employee');
    Route::post('filter_date_daily_order', 'DashboardController@filter_date_daily_order')->middleware('admin_manager_employee');

    // ADMIN
    // Route::group(['middleware'=>'admin_manager'], function(){
    Route::get('all_admin', 'AdminController@show_admin')->middleware('admin_manager');
    Route::get('add_admin', 'AdminController@add_admin')->middleware('admin');
    Route::get('update_admin/{admin_id}', 'AdminController@update_admin')->middleware('admin');
    Route::get('view_recycle', 'AdminController@view_recycle')->middleware('admin');
    Route::get('re_delete/{admin_id}', 'AdminController@re_delete')->middleware('admin');
    Route::get('delete_when_find/{admin_id}', 'AdminController@delete_when_find')->middleware('admin');
    Route::get('view_profile/{admin_id}', 'AdminController@view_profile')->middleware('admin_manager_employee');

    Route::post('find_admin', 'AdminController@find_admin')->middleware('admin_manager');
    Route::post('delete_forever', 'AdminController@delete_forever')->middleware('admin');
    Route::post('soft_delete', 'AdminController@soft_delete')->middleware('admin');
    Route::post('process_add_admin', 'AdminController@process_add_admin')->middleware('admin');
    Route::post('process_update_admin/{admin_id}', 'AdminController@process_update_admin')->middleware('admin');
    Route::post('process_update_profile_admin/{admin_id}', 'AdminController@process_update_profile_admin')->middleware('admin_manager_employee');
    Route::post('update_password_admin/{admin_id}', 'AdminController@update_password_admin')->middleware('admin_manager_employee');

    Route::post('filter_admin_role', 'AdminController@filter_admin_role')->middleware('admin_manager_employee');
    Route::post('print_pdf_admin', 'AdminController@print_pdf_admin')->middleware('admin_manager_employee');
    // });

    //PERMISSION
    Route::get('list_permission', 'AdminController@list_permission')->middleware('admin_manager');
    Route::post('assign_roles', 'AdminController@assign_roles')->middleware('admin');

    //PRODUCT
    Route::get('add_product', 'ProductController@add_product')->middleware('admin_manager');
    Route::get('all_product', 'ProductController@all_product')->middleware('admin_manager_employee');
    Route::get('is_featured/{prod_id}', 'ProductController@is_featured')->middleware('admin_manager');
    Route::get('is_not_featured/{prod_id}', 'ProductController@is_not_featured')->middleware('admin_manager');
    Route::get('update_product/{prod_id}', 'ProductController@update_product')->middleware('admin_manager');
    Route::get('view_recycle_product', 'ProductController@view_recycle_product')->middleware('admin');
    Route::get('re_delete_product/{prod_id}', 'ProductController@re_delete_product')->middleware('admin');
    Route::get('find_product', 'ProductController@find_product')->middleware('admin_manager_employee');
    Route::get('view_detail_product/{prod_id}', 'ProductController@view_detail_product')->middleware('admin_manager_employee');
    Route::get('delete_when_find_product/{product_id}', 'ProductController@delete_when_find_product')->middleware('admin');

    Route::post('process_add_product', 'ProductController@process_add_product')->middleware('admin_manager');
    Route::post('process_update_product/{prod_id}', 'ProductController@process_update_product')->middleware('admin_manager');
    Route::post('soft_delete_product', 'ProductController@soft_delete_product')->middleware('admin');
    Route::post('delete_forever_product', 'ProductController@delete_forever_product')->middleware('admin');
    Route::post('filter_new_product', 'ProductController@filter_new_product')->middleware('admin_manager_employee');
    Route::post('filter_product_feature', 'ProductController@filter_product_feature')->middleware('admin_manager_employee');
    Route::post('filter_product_follow_cate', 'ProductController@filter_product_follow_cate')->middleware('admin_manager_employee');
    Route::post('filter_product_follow_cate_many', 'ProductController@filter_product_follow_cate_many')->middleware('admin_manager_employee');
    Route::post('filter_product_follow_storage', 'ProductController@filter_product_follow_storage')->middleware('admin_manager_employee');
    Route::post('filter_product_follow_storage_many', 'ProductController@filter_product_follow_storage_many')->middleware('admin_manager_employee');
    Route::post('filter_product_follow_price_choose', 'ProductController@filter_product_follow_price_choose')->middleware('admin_manager_employee');
    Route::post('filter_product_follow_price_cus_option', 'ProductController@filter_product_follow_price_cus_option')->middleware('admin_manager_employee');
    Route::post('filter_product_follow_rating_choose', 'ProductController@filter_product_follow_rating_choose')->middleware('admin_manager_employee');
    Route::post('filter_product_follow_date_create_single', 'ProductController@filter_product_follow_date_create_single')->middleware('admin_manager_employee');
    Route::post('filter_product_follow_date_create_many', 'ProductController@filter_product_follow_date_create_many')->middleware('admin_manager_employee');

    Route::post('print_pdf_product', 'ProductController@print_pdf_product')->middleware('admin_manager_employee');

    // PRODUCT IMAGE
    Route::get('all_gallery_product/{prod_id}', 'ImageProductController@all_gallery_product')->middleware('admin_manager_employee');
    Route::get('view_recycle_image_product/{prod_id}', 'ImageProductController@view_recycle_image_product')->middleware('admin');
    Route::get('restore_image_product/{image_id}', 'ImageProductController@restore_image_product')->middleware('admin');


    Route::post('process_add_image_product/{prod_id}', 'ImageProductController@process_add_image_product')->middleware('admin_manager');
    Route::post('delete_soft_image_product', 'ImageProductController@delete_soft_image_product')->middleware('admin');
    Route::post('delete_forever_image_product', 'ImageProductController@delete_forever_image_product')->middleware('admin');

    // PRODUCT PRICE
    Route::get('history_price_product/{prod_id}', 'ProductPriceController@history_price_product')->middleware('admin_manager_employee');

    Route::post('update_price_product', 'ProductPriceController@update_price_product')->middleware('admin_manager');
    Route::post('filter_price_product_history', 'ProductPriceController@filter_price_product_history')->middleware('admin_manager_employee');


    //CATEGORY
    Route::get('all_category', 'CategoryController@show_category')->middleware('admin_manager_employee');
    Route::get('add_category', 'CategoryController@add_category')->middleware('admin_manager');
    Route::get('update_category/{cate_id}', 'CategoryController@update_category')->middleware('admin_manager');

    Route::post('process_add_category', 'CategoryController@process_add_category')->middleware('admin_manager');
    Route::post('process_update_category/{cate_id}', 'CategoryController@process_update_category')->middleware('admin_manager');
    Route::get('process_delete_category/{cate_id}', 'CategoryController@process_delete_category')->middleware('admin');

    Route::get('view_recycle_cate', 'CategoryController@view_recycle')->middleware('admin');
    Route::get('re_delete_cate/{cate_id}', 'CategoryController@re_delete')->middleware('admin');
    Route::post('delete_forever_cate', 'CategoryController@delete_forever')->middleware('admin');
    Route::get('delete_recovery_forever/{cate_id}', 'CategoryController@delete_recovery_forever')->middleware('admin');
    Route::post('soft_delete_cate', 'CategoryController@soft_delete')->middleware('admin');

    Route::get('find_category', 'CategoryController@find_category')->middleware('admin_manager_employee');

    //STORAGE
    Route::get('all_storage', 'StorageController@show_storage')->middleware('admin_manager_employee');
    Route::get('add_storage', 'StorageController@add_storage')->middleware('admin_manager');
    Route::get('update_storage_when_find/{storage_id}', 'StorageController@update_storage_when_find')->middleware('admin_manager');
    Route::get('process_delete_storage_when_find/{storage}', 'StorageController@process_delete_storage_when_find')->middleware('admin');

    Route::post('process_add_storage', 'StorageController@process_add_storage')->middleware('admin_manager');
    Route::post('process_update_storage', 'StorageController@process_update_storage')->middleware('admin_manager');
    Route::post('process_update_storage_when_find', 'StorageController@process_update_storage_when_find')->middleware('admin_manager');


    Route::get('view_recycle_storage', 'StorageController@view_recycle')->middleware('admin');
    Route::get('re_delete_storage/{storage_id}', 'StorageController@re_delete')->middleware('admin');
    Route::post('delete_forever_storage', 'StorageController@delete_forever')->middleware('admin');
    Route::get('delete_recovery_forever_storage/{storage_id}', 'StorageController@delete_recovery_forever_storage')->middleware('admin');
    Route::post('soft_delete_storage', 'StorageController@soft_delete')->middleware('admin');

    Route::get('find_storage', 'StorageController@find_storage')->middleware('admin_manager_employee');
    Route::post('storage_id_update', 'StorageController@get_id_storage')->middleware('admin_manager');

    //STORAGE_PRODUCT
    Route::get('all_storage_product/{storage_id}', 'StorageProductController@all_storage_product')->middleware('admin_manager_employee');
    Route::get('update_storage_product/{storage_product_id}', 'StorageProductController@update_storage_product')->middleware('admin_manager');
    Route::get('import_storage_product/{storage_product_id}', 'StorageProductController@import_storage_product')->middleware('admin_manager');
    Route::get('history_storage_product/{storage_product_id}', 'StorageProductController@history_storage_product')->middleware('admin_manager_employee');

    Route::post('process_update_storage_product/{storage_product_id}', 'StorageProductController@process_update_storage_product')->middleware('admin_manager');
    Route::post('process_import_storage_product/{storage_product_id}', 'StorageProductController@process_import_storage_product')->middleware('admin_manager');
    Route::get('process_delete_storage_product/{storage_product_id}', 'StorageProductController@process_delete_storage_product')->middleware('admin');

    Route::get('view_recycle_storage_product/{storage_id}', 'StorageProductController@view_recycle')->middleware('admin');
    Route::get('re_delete_storage_product/{storage_product_id}', 'StorageProductController@re_delete')->middleware('admin');
    Route::post('delete_forever_storage_product', 'StorageProductController@delete_forever')->middleware('admin');
    Route::get('delete_recovery_forever_storage_product/{storage_product_id}', 'StorageProductController@delete_recovery_forever_storage_product')->middleware('admin');
    Route::post('soft_delete_storage_product', 'StorageProductController@soft_delete')->middleware('admin');

    Route::post('find_storage_product', 'StorageProductController@find_storage_product')->middleware('admin_manager_employee');

    Route::post('filter_storage_product_quantity_choose', 'StorageProductController@filter_storage_product_quantity_choose')->middleware('admin_manager_employee');
    Route::post('filter_storage_product_quantity_cus_option', 'StorageProductController@filter_storage_product_quantity_cus_option')->middleware('admin_manager_employee');

    Route::post('print_pdf_storage_product', 'StorageProductController@print_pdf_storage_product')->middleware('admin_manager_employee');
    Route::post('print_pdf_history_storage_product', 'StorageProductController@print_pdf_history_storage_product')->middleware('admin_manager_employee');



    //ORDER
    Route::get('all_order', 'OrderController@all_order')->middleware('admin_manager_employee');
    Route::get('await_confirm_order', 'OrderController@await_confirm_order')->middleware('admin_manager_employee');
    Route::get('confirmed', 'OrderController@confirmed')->middleware('admin_manager_employee');
    Route::get('delivering', 'OrderController@delivering')->middleware('admin_manager_employee');
    Route::get('delivery_success', 'OrderController@delivery_success')->middleware('admin_manager_employee');
    Route::get('detail_order_item/{order_id}', 'OrderController@detail_order_item')->middleware('admin_manager_employee');
    Route::get('cancelled', 'OrderController@cancelled')->middleware('admin_manager_employee');
    Route::get('print_pdf_delivery_order/{order_id}', 'OrderController@print_pdf_delivery_order')->middleware('admin_manager_employee');

    Route::post('confirm_order', 'OrderController@confirm_order')->middleware('admin_manager_employee');
    Route::post('confirm_delivary_order', 'OrderController@confirm_delivary_order')->middleware('admin_manager_employee');
    Route::post('confirm_delivery_success_order', 'OrderController@confirm_delivery_success_order')->middleware('admin_manager_employee');
    Route::post('search_order', 'OrderController@search_order')->middleware('admin_manager_employee');

    Route::post('filter_order_fol_price', 'OrderController@filter_order_fol_price')->middleware('admin_manager_employee');
    Route::post('filter_order_fol_payment_status', 'OrderController@filter_order_fol_payment_status')->middleware('admin_manager_employee');
    Route::post('filter_order_fol_payment_method', 'OrderController@filter_order_fol_payment_method')->middleware('admin_manager_employee');
    Route::post('filter_order_fol_date', 'OrderController@filter_order_fol_date')->middleware('admin_manager_employee');
    Route::post('filter_order_fol_date_many', 'OrderController@filter_order_fol_date_many')->middleware('admin_manager_employee');

    Route::post('print_pdf_order', 'OrderController@print_pdf_order')->middleware('admin_manager_employee')->middleware('admin_manager_employee');



    // VOUCHER
    Route::get('all_voucher/{product_id}', 'VoucherController@all_voucher')->middleware('admin_manager_employee');
    Route::get('detail_voucher/{voucher_id}', 'VoucherController@detail_voucher')->middleware('admin_manager_employee');
    Route::get('add_voucher', 'VoucherController@add_voucher')->middleware('admin_manager');
    Route::get('add_product_voucher/{product_id}', 'VoucherController@add_product_voucher')->middleware('admin_manager');
    Route::get('update_voucher/{voucher_id}', 'VoucherController@update_voucher')->middleware('admin_manager');
    Route::post('process_add_voucher', 'VoucherController@process_add_voucher')->middleware('admin_manager');
    Route::post('process_update_voucher/{voucher_id}', 'VoucherController@process_update_voucher')->middleware('admin_manager');
    Route::get('all_product_voucher', 'VoucherController@all_product_voucher')->middleware('admin_manager_employee');
    Route::post('get_voucher_id', 'VoucherController@get_voucher_id')->middleware('admin_manager_employee');

    Route::get('find_product_voucher', 'VoucherController@find_product_voucher')->middleware('admin_manager_employee');
    Route::post('find_voucher', 'VoucherController@find_voucher')->middleware('admin_manager_employee');
    Route::post('soft_delete_voucher', 'VoucherController@soft_delete_voucher')->middleware('admin');

    Route::get('view_recycle_product_voucher/{product_id}', 'VoucherController@all_recycle')->middleware('admin');
    Route::post('delete_forever_voucher', 'VoucherController@delete_forever')->middleware('admin');
    Route::get('re_delete_voucher/{voucher_id}', 'VoucherController@re_delete')->middleware('admin');
    Route::get('delete_voucher_when_find/{voucher_id}', 'VoucherController@delete_voucher_when_find')->middleware('admin');
    Route::get('detail_voucher/{voucher_id}', 'VoucherController@detail_voucher')->middleware('admin_manager_employee');

    Route::post('print_pdf_voucher', 'VoucherController@print_pdf_voucher')->middleware('admin_manager_employee');
    Route::post('filter_voucher_follow_status_apply', 'VoucherController@filter_voucher_follow_status_apply')->middleware('admin_manager_employee');
    Route::post('filter_voucher_follow_status_unapply', 'VoucherController@filter_voucher_follow_status_unapply')->middleware('admin_manager_employee');
    Route::post('filter_voucher_follow_date_single', 'VoucherController@filter_voucher_follow_date_single')->middleware('admin_manager_employee');
    Route::post('filter_voucher_follow_date_many', 'VoucherController@filter_voucher_follow_date_many')->middleware('admin_manager_employee');

    // SLIDER
    Route::get('all_slider', 'SliderController@all_slider')->middleware('admin_manager_employee');
    Route::get('add_slider', 'SliderController@add_slider')->middleware('admin_manager');
    Route::get('active_slider/{slider_id}', 'SliderController@active_slider')->middleware('admin_manager');
    Route::get('unactive_slider/{slider_id}', 'SliderController@unactive_slider')->middleware('admin_manager');
    Route::post('process_add_slider', 'SliderController@process_add_slider')->middleware('admin_manager');
    Route::post('process_delete_slider', 'SliderController@process_delete_slider')->middleware('admin');

    // CUSTOMER
    Route::get('all_customer', 'CustomerAdminController@all_customer')->middleware('admin_manager_employee');
    Route::get('detail_customer/{customer_id}', 'CustomerAdminController@detail_customer')->middleware('admin_manager_employee');
    Route::get('find_customer', 'CustomerAdminController@find_customer')->middleware('admin_manager_employee');

    Route::post('filter_customer_follow_order_quantity_choose', 'CustomerAdminController@filter_customer_follow_order_quantity_choose')->middleware('admin_manager_employee');
    Route::post('filter_customer_follow_order_quantity_cus_option', 'CustomerAdminController@filter_customer_follow_order_quantity_cus_option')->middleware('admin_manager_employee');
    Route::post('filter_order_customer_follow_price_choose', 'CustomerAdminController@filter_order_customer_follow_price_choose')->middleware('admin_manager_employee');
    Route::post('filter_order_customer_follow_price_cus_option', 'CustomerAdminController@filter_order_customer_follow_price_cus_option')->middleware('admin_manager_employee');
    Route::post('filter_order_customer_follow_date_single', 'CustomerAdminController@filter_order_customer_follow_date_single')->middleware('admin_manager_employee');
    Route::post('filter_order_customer_follow_date_many', 'CustomerAdminController@filter_order_customer_follow_date_many')->middleware('admin_manager_employee');

    Route::post('print_pdf_customer', 'CustomerAdminController@print_pdf_customer')->middleware('admin_manager_employee');
    Route::post('print_pdf_order_customer/{customer_id}', 'CustomerAdminController@print_pdf_order_customer')->middleware('admin_manager_employee');

    //DISCOUNT PRODUCT
    Route::get('all_discount', 'DiscountController@all_discount')->middleware('admin_manager_employee');
    Route::get('add_discount', 'DiscountController@add_discount')->middleware('admin_manager');
    Route::get('update_discount/{discount_id}', 'DiscountController@update_discount')->middleware('admin_manager');
    Route::get('detail_discount/{discount_id}', 'DiscountController@detail_discount')->middleware('admin_manager_employee');
    Route::get('delete_discount_when_filter/{discount_id}', 'DiscountController@delete_discount_when_filter')->middleware('admin');

    Route::post('process_add_discount', 'DiscountController@process_add_discount')->middleware('admin_manager');
    Route::post('check_val_discount', 'DiscountController@check_val_discount')->middleware('admin_manager');
    Route::post('check_val_discount_2', 'DiscountController@check_val_discount_2')->middleware('admin_manager');
    Route::post('check_val_discount_update', 'DiscountController@check_val_discount_update')->middleware('admin_manager');
    Route::post('check_val_discount_update_2', 'DiscountController@check_val_discount_update_2')->middleware('admin_manager');
    Route::post('process_update_discount/{discount_id}', 'DiscountController@process_update_discount')->middleware('admin_manager');
    Route::post('delete_discount', 'DiscountController@delete_discount')->middleware('admin_manager');

    Route::post('filter_discount_status_time_discount', 'DiscountController@filter_discount_status_time_discount')->middleware('admin_manager_employee');
    Route::post('print_pdf_discount', 'DiscountController@print_pdf_discount')->middleware('admin_manager_employee');

    // PROCESS COMMENT
    Route::get('view_comment_to_process', 'CommentController@view_comment_to_process')->middleware('admin_manager_employee');
    Route::get('process_accep_comment_when_filter/{comment_id}', 'CommentController@process_accep_comment_when_filter')->middleware('admin_manager_employee');
    Route::get('process_unaccep_comment_when_filter/{comment_id}', 'CommentController@process_unaccep_comment_when_filter')->middleware('admin_manager_employee');
    Route::post('process_accep_comment', 'CommentController@process_accep_comment')->middleware('admin_manager_employee');
    Route::post('process_unaccep_comment', 'CommentController@process_unaccep_comment')->middleware('admin_manager_employee');

    Route::post('filter_comment_fol_product', 'CommentController@filter_comment_fol_product')->middleware('admin_manager_employee');
    Route::post('filter_comment_fol_rating', 'CommentController@filter_comment_fol_rating')->middleware('admin_manager_employee');

    Route::post('print_pdf_comment', 'CommentController@print_pdf_comment')->middleware('admin_manager_employee');


    // TRACE
    Route::post('trace_product_side_profile_single_date', 'TraceSideProfileController@trace_product_side_profile_single_date')->middleware('admin');
    Route::post('trace_product_side_profile_many_date', 'TraceSideProfileController@trace_product_side_profile_many_date')->middleware('admin');

    Route::post('trace_cate_side_profile_single_date', 'TraceSideProfileController@trace_cate_side_profile_single_date')->middleware('admin');
    Route::post('trace_cate_side_profile_many_date', 'TraceSideProfileController@trace_cate_side_profile_many_date')->middleware('admin');

    Route::post('trace_price_product_side_profile_single_date', 'TraceSideProfileController@trace_price_product_side_profile_single_date')->middleware('admin');
    Route::post('trace_price_product_side_profile_many_date', 'TraceSideProfileController@trace_price_product_side_profile_many_date')->middleware('admin');

    Route::post('trace_admin_side_profile_single_date', 'TraceSideProfileController@trace_admin_side_profile_single_date')->middleware('admin');
    Route::post('trace_admin_side_profile_many_date', 'TraceSideProfileController@trace_admin_side_profile_many_date')->middleware('admin');

    Route::post('trace_product_image_side_profile_single_date', 'TraceSideProfileController@trace_product_image_side_profile_single_date')->middleware('admin');
    Route::post('trace_product_image_side_profile_many_date', 'TraceSideProfileController@trace_product_image_side_profile_many_date')->middleware('admin');

    Route::post('trace_storage_side_profile_single_date', 'TraceSideProfileController@trace_storage_side_profile_single_date')->middleware('admin');
    Route::post('trace_storage_side_profile_many_date', 'TraceSideProfileController@trace_storage_side_profile_many_date')->middleware('admin');

    Route::post('trace_storage_product_side_profile_single_date', 'TraceSideProfileController@trace_storage_product_side_profile_single_date')->middleware('admin');
    Route::post('trace_storage_product_side_profile_many_date', 'TraceSideProfileController@trace_storage_product_side_profile_many_date')->middleware('admin');

    Route::post('trace_discount_side_profile_single_date', 'TraceSideProfileController@trace_discount_side_profile_single_date')->middleware('admin');
    Route::post('trace_discount_side_profile_many_date', 'TraceSideProfileController@trace_discount_side_profile_many_date')->middleware('admin');

    Route::post('trace_voucher_side_profile_single_date', 'TraceSideProfileController@trace_voucher_side_profile_single_date')->middleware('admin');
    Route::post('trace_voucher_side_profile_many_date', 'TraceSideProfileController@trace_voucher_side_profile_many_date')->middleware('admin');

    // SHIPPING COST
    Route::get('all_shipping_cost', 'ShippingCostController@all_shipping_cost')->middleware('admin_manager_employee');
    Route::get('add_shipping_cost', 'ShippingCostController@add_shipping_cost')->middleware('admin_manager');
    Route::post('process_add_shipping_cost', 'ShippingCostController@process_add_shipping_cost')->middleware('admin_manager');
    Route::post('delete_shipping_cost', 'ShippingCostController@delete_shipping_cost')->middleware('admin');
    Route::get('update_shipping_cost/{shipping_cost_id}', 'ShippingCostController@update_shipping_cost')->middleware('admin_manager');
    Route::post('process_update_shipping_cost/{shipping_cost_id}', 'ShippingCostController@process_update_shipping_cost')->middleware('admin_manager');

    Route::post('find_shipping_cost', 'ShippingCostController@find_shipping_cost')->middleware('admin_manager_employee');
});

// FONT END
// NAV
Route::get('/', 'HomeClientController@index');
Route::get('shop_product', 'ShopController@shop_product');
Route::get('contact_us', 'HomeClientController@contact_us');
Route::get('terms_conditions', 'HomeClientController@terms_conditions');

//HOME -> SHOW
Route::get('show_all_product_discount', 'HomeClientController@show_all_product_discount');
Route::get('show_all_product_feature', 'HomeClientController@show_all_product_feature');
Route::get('show_all_product_recommend', 'HomeClientController@show_all_product_recommend');

// SHOP AJAX
Route::post('ajax_sort_cate_shop', 'ShopController@ajax_sort_cate_shop');
Route::post('ajax_sort_rating_shop', 'ShopController@ajax_sort_rating_shop');
Route::post('ajax_sort_price_enter_shop', 'ShopController@ajax_sort_price_enter_shop');

Route::post('sort_price_ajax_shop_select', 'ShopController@sort_price_ajax_shop_select');
Route::post('sort_rating_ajax_shop_select', 'ShopController@sort_rating_ajax_shop_select');
Route::post('sort_discount_ajax_shop_select', 'ShopController@sort_discount_ajax_shop_select');
Route::post('filter_modal_shop_ajax', 'ShopController@filter_modal_shop_ajax');

//detail product
Route::get('product_detail/{product_id}', 'HomeClientController@product_detail');
Route::get('product_detail_slug/{slug}', 'HomeClientController@product_detail_slug');
Route::get('buy_now/{product_id}', 'HomeClientController@buy_now');
Route::post('load_detail_product', 'HomeClientController@load_detail_product');
//event card side detail
Route::post('product_detail/load_detail_product', 'HomeClientController@load_detail_product');
Route::post('product_detail/add_to_cart', 'CartController@add_cart');
Route::post('product_detail/add_wish_list_ajax', 'WishListController@add_wish_list_ajax');
Route::post('product_detail/load_quantity_cart', 'CartController@load_quantity_cart');
Route::post('product_detail/show_mini_cart_when_add', 'CartController@show_mini_cart_when_add');
Route::post('product_detail/update_qty_when_change', 'CartController@update_qty_when_change');
//event card side detail slug
Route::post('product_detail_slug/load_detail_product', 'HomeClientController@load_detail_product');
Route::post('product_detail_slug/add_to_cart', 'CartController@add_cart');
Route::post('product_detail_slug/add_wish_list_ajax', 'WishListController@add_wish_list_ajax');
Route::post('product_detail_slug/load_quantity_cart', 'CartController@load_quantity_cart');
Route::post('product_detail_slug/show_mini_cart_when_add', 'CartController@show_mini_cart_when_add');
Route::post('product_detail_slug/update_qty_when_change', 'CartController@update_qty_when_change');
// search auto complete
Route::post('ajax_search_auto_complete', 'HomeClientController@ajax_search_auto_complete');
Route::post('search_product_form_search_auto_complete', 'HomeClientController@search_product_form_search_auto_complete');
//search ajax product follow keyword search
Route::post('ajax_search_cate_and_keyword', 'AjaxSearchProductKeyword@ajax_search_cate_and_keyword');
Route::post('ajax_search_rating_and_keyword', 'AjaxSearchProductKeyword@ajax_search_rating_and_keyword');
Route::post('ajax_search_price_and_keyword', 'AjaxSearchProductKeyword@ajax_search_price_and_keyword');
//sort ajax and keyword
Route::post('ajax_sort_price_and_keyword', 'AjaxSearchProductKeyword@ajax_sort_price_and_keyword');
Route::post('ajax_sort_rating_and_keyword', 'AjaxSearchProductKeyword@ajax_sort_rating_and_keyword');
Route::post('ajax_sort_discount_and_keyword', 'AjaxSearchProductKeyword@ajax_sort_discount_and_keyword');

//comment_rating
Route::post('add_comment_rating', 'HomeClientController@add_comment_rating');
Route::post('load_comment', 'HomeClientController@load_comment');
Route::post('load_more_comment', 'HomeClientController@load_more_comment');
Route::post('like_comment', 'HomeClientController@like_comment');
Route::post('delete_comment', 'HomeClientController@delete_comment');
Route::post('update_comment', 'HomeClientController@update_comment');


Route::get('user/account', 'AccountController@show_account');
Route::get('user/address', 'AccountController@address_account');
Route::get('user/resetpassword', 'AccountController@reset_password_account');
Route::get('user/order', 'AccountController@order_account');
Route::get('user/voucher', 'AccountController@show_voucher');
//CUSTOMER VOUCHER
Route::post('process_save_voucher', 'StorageVoucherController@process_save_voucher');

// update account info
Route::post('update_info_account', 'AccountController@update_account');
Route::post('upload_avt_account', 'AccountController@upload_avt_account');

// USER RESETPASSWORD
Route::post('process_update_password_account', 'AccountController@process_update_password');

// USER ADDRESS
Route::post('process_add_address', 'AccountController@process_add_address');
Route::post('trans_id_update', 'AccountController@get_id_trans');
Route::post('get_phone_address', 'AccountController@get_phone_trans');
Route::post('get_address_detail_trans', 'AccountController@get_address_detail_trans');
Route::post('get_address_ward_trans', 'AccountController@get_address_ward_trans');
Route::post('get_address_district_trans', 'AccountController@get_address_district_trans');
Route::post('get_address_city_trans', 'AccountController@get_address_city_trans');

Route::post('process_update_address', 'AccountController@process_update_address');
Route::post('process_delete_address', 'AccountController@process_delete_address');
Route::post('process_mode_default', 'AccountController@process_mode_default');

Route::post('load_district', 'AddressController@load_district');
Route::post('load_ward', 'AddressController@load_ward');
Route::post('load_district_update_address_user', 'AddressController@load_district');
Route::post('load_ward_update_address_user', 'AddressController@load_ward');

// USER ORDER
Route::get('user/order/{order_id}', 'AccountController@order_detail_account');
Route::post('process_cancel_order', 'AccountController@process_cancel_order');

// CART
Route::post('add_to_cart', 'CartController@add_cart');
Route::post('load_quantity_cart', 'CartController@load_quantity_cart');
Route::post('show_mini_cart_when_add', 'CartController@show_mini_cart_when_add');

Route::post('update_qty_when_change', 'CartController@update_qty_when_change');
Route::post('update_qty_when_update_cart', 'CartController@update_qty_when_update_cart');


Route::get('show_cart', 'CartController@show_cart');
Route::post('update_cart', 'CartController@update_cart');
Route::post('update_cart_checkbox', 'CartController@update_cart_checkbox');
Route::post('check_quatity_blur', 'CartController@check_quatity_blur');
Route::post('remove_item_cart', 'CartController@remove_item_cart');
Route::post('get_val_checkbox', 'CartController@get_val_checkbox');

// WISH LIST
Route::post('add_wish_list_ajax', 'WishListController@add_wish_list_ajax');
Route::post('load_wish_list_ajax', 'WishListController@load_wish_list_ajax');
Route::post('count_total_wish_list_ajax', 'WishListController@count_total_wish_list_ajax');
Route::post('remove_item_wish_list', 'WishListController@remove_item_wish_list');

//CHECK OUT
Route::post('checkout', 'CheckOutController@show_checkout');
Route::post('add_address_trans', 'CheckOutController@add_address_trans');
Route::post('check_voucher_code_to_apply', 'CheckOutController@check_voucher_code_to_apply');

Route::post('check_qty_to_checkout', 'CheckOutController@check_qty_to_checkout');
Route::post('process_checkout', 'CheckOutController@process_checkout');
Route::get(
    'view_checkout_paypal_success/{payment_method}/{summary_total_order}/{status}/{order_code}',
    'CheckOutController@view_checkout_paypal_success'
);
Route::get('view_checkout_paypal_fail/{order_id}', 'CheckOutController@view_checkout_paypal_fail');

Route::get('check_out_success', 'CheckOutController@check_out_success');
Route::post('get_fee_ship_checkout', 'CheckOutController@get_fee_ship_checkout');

// ADDRESS ADD ADDRESS ADMIN LOAD
Route::post('admin/load_district', 'AddressController@load_district');
Route::post('admin/load_ward', 'AddressController@load_ward');
//ADDRESS UPDATE ADDRESS ADDMIN LOAD
Route::post('admin/load_district_update_address_admin', 'AddressController@load_district');
Route::post('admin/load_ward_update_address_admin', 'AddressController@load_ward');
//ADDRESS UPDATE ADDRESS PROFILE ADDMIN LOAD
Route::post('admin/load_district_update_profile_admin', 'AddressController@load_district');
Route::post('admin/load_ward_update_address_profile_admin', 'AddressController@load_ward');

//ADDRESS ADD TRANS
Route::post('load_district', 'AddressController@load_district');
Route::post('load_ward', 'AddressController@load_ward');


// CKDITOR
Route::post('ckeditor/image_upload', 'CKEditorController@upload')->name('upload');
