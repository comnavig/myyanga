<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

//~ Route::get('/', function () {
    //~ return view('welcome');
//~ });

Auth::routes(['verify' => true]);

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index2')->name('home2');
Route::get('/tour', 'HomeController@tour')->name('tour');
Route::get('/today', 'HomeController@today')->name('today');
Route::get('/explore', 'HomeController@explore')->name('explore');
Route::get('/explore/category/{id}/items', 'HomeController@explore_category')->name('explore.category');
Route::get('/search', 'HomeController@search')->name('search');
Route::get('/search/smart', 'HomeController@smart_search')->name('search.smart');
Route::get('/featured/{cat}', 'HomeController@featured_category')->name('featured.category');
Route::get('/featured/{cat}/{id}', 'HomeController@featured')->name('featured.product');
Route::post('/like/product/{id}', 'HomeController@favourite')->name('like.product')->middleware('auth');
Route::post('/like/brand/{id}', 'HomeController@follow')->name('like.brand')->middleware('auth');

//~ Route::get('/emergency/{location}/services', 'HomeController@emergency_services')->name('emergency.services');
//~ Route::get('/discounts', 'HomeController@discounts')->name('home.discounts');
//~ Route::get('/biztips', 'HomeController@biztips')->name('home.biztips');
//~ Route::get('/jobs', 'HomeController@jobs')->name('home.jobs');
//~ Route::get('/events', 'HomeController@events')->name('home.events');

//~ Route::get('/mart/search', 'HomeController@mart_search')->name('mart.search.product');
//~ Route::get('/mart/{id}/product', 'HomeController@mart_product')->name('mart.product');
//~ Route::post('/make/notification', 'HomeController@make_notification')->name('make.notification');
//~ Route::get('/affiliate/register', 'HomeController@affiliate_form')->name('affiliate.form');
//~ Route::post('/affiliate/register', 'HomeController@affiliate_register')->name('affiliate.register');

//Shop
Route::get('/shop', 'ShopController@index')->name('shop');
Route::get('/shop/cart/', 'ShopController@cart')->name('shop.cart');
Route::get('/shop/product/{id}', 'ShopController@product')->name('shop.product');
Route::post('/shop/product/make/review', 'ShopController@product_review')->name('shop.product.review')->middleware('auth');
Route::post('/shop/add/cart', 'ShopController@add_to_cart')->name('shop.add.cart');
Route::post('/shop/remove/item/cart', 'ShopController@remove_from_cart')->name('shop.remove.item.cart');
Route::get('/shop/checkout', 'ShopController@checkout')->name('shop.checkout')->middleware('auth');
Route::get('/shop/process/payment', 'ShopController@cart');
Route::post('/shop/process/payment', 'ShopController@process_payment')->name('shop.process.payment')->middleware('auth');
Route::get('/shop/make/payment/{id}', 'ShopController@make_payment')->name('shop.make.payment')->middleware('auth');
Route::get('/shop/confirm/payment', 'ShopController@confirm_payment')->name('shop.confirm.payment')->middleware('auth');
Route::get('/shop/delete/{id}/order', 'ShopController@delete_order')->name('shop.delete.order')->middleware('auth');

//Tvs
Route::get('/myyangatv', 'HomeController@myyangatv')->name('tvs');
Route::get('/myyangatv/cat/{id}', 'HomeController@myyangatv_category')->name('tvs.category');
Route::get('/myyangatv/{id}', 'HomeController@myyangatv_show')->name('tvs.show');

//Blog
Route::get('/blog', 'HomeController@blog')->name('blog');
Route::get('/blog/cat/{id}', 'HomeController@blog_category')->name('blog.category');
Route::get('/blog/{slug}', 'HomeController@blog_post')->name('blog.post');

//Groom Tips
Route::get('/grooming/tips', 'HomeController@groomingtip')->name('groomtips');
Route::get('/grooming/tips/cat/{id}', 'HomeController@groomingtip_category')->name('groomtips.category');
Route::get('/grooming/tip/{slug}', 'HomeController@groomingtip_tip')->name('groomtips.tip');

//Premium
Route::get('/premiums', 'HomeController@premiums')->name('premiums')->middleware('auth','only.subscriber');
Route::get('/premiums/cat/{id}', 'HomeController@premium_category')->name('premiums.category')->middleware('auth','only.subscriber');
Route::get('/premiums/{id}', 'HomeController@premium_story')->name('premiums.story')->middleware('auth','only.subscriber');

//Discover
Route::get('/discovers', 'HomeController@discovers')->name('discovers');
Route::get('/discovers/cat/{id}', 'HomeController@discover_category')->name('discovers.category');
Route::get('/discovers/{slug}', 'HomeController@discover_story')->name('discovers.story');

//PYL
Route::get('/post/your/look', 'HomeController@pyl')->name('pyls')->middleware('auth');
Route::post('/post/your/look', 'HomeController@pyl_upload')->name('pyl.upload');
Route::get('/pyls/{slug}', 'HomeController@pyl_competition')->name('pyls.competition');
Route::get('/pyls/{slug}/{id}', 'HomeController@pyl_entry')->name('pyls.competition.entry');
Route::post('/pyls/cast/vote', 'HomeController@pyl_entry_vote')->name('pyls.competition.entry.vote');



//Auth Individual Section
Route::get('/user', 'Individual\DashboardController@index')->name('user');
Route::get('/user/dashboard', 'Individual\DashboardController@index')->name('user.dashboard');
Route::get('/user/profile', 'Individual\DashboardController@index')->name('user.profile');
Route::get('/user/profile/edit', 'Individual\DashboardController@edit_profile')->name('user.profile.edit');
Route::post('/user/profile/update', 'Individual\DashboardController@update_profile')->name('user.profile.update');
Route::post('/user/profile/password/update', 'Individual\DashboardController@update_password')->name('user.profile.update.password');
Route::get('/user/notification/edit', 'Individual\DashboardController@edit_notification')->name('user.notification.edit');
Route::post('/user/notification/update', 'Individual\DashboardController@update_notification')->name('user.notification.update');
Route::get('/user/activities', 'Individual\DashboardController@activities')->name('user.activities');
Route::get('/user/favourites', 'Individual\DashboardController@favourites')->name('user.favourites');
Route::get('/user/notifications', 'Individual\DashboardController@notificationList')->name('user.notifications');
Route::get('/user/notification/{id}', 'Individual\DashboardController@notificationSingle')->name('user.notifications.single')->middleware('auth','only.subscriber');
Route::get('/user/orders', 'Individual\DashboardController@orders')->name('user.orders');
Route::get('/user/order/{product_id}/item/', 'Individual\DashboardController@order_view_item')->name('user.order.view.item');
Route::get('/user/following', 'Individual\DashboardController@follows')->name('user.following');
Route::get('/user/pyls', 'Individual\DashboardController@pyls')->name('user.pyls');
Route::post('/user/pyl/upload', 'Individual\DashboardController@pyl_upload_look')->name('user.pyl.upload');
Route::get('/user/premium/subscriptions', 'Individual\DashboardController@premium_subscriptions')->name('user.premium.subscriptions');
Route::get('/user/premium/subscriptions/calculation', 'Individual\DashboardController@premium_subscriptions');
Route::post('/user/premium/subscriptions/calculation', 'Individual\DashboardController@premium_subscriptions_calculation')->name('user.premium.subscription.calculation');
Route::get('/user/premium/subscriptions/confirm/payment', 'Individual\DashboardController@premium_subscriptions_confirm_payment')->name('user.premium.subscription.confirm.payment');

//Auth Business Section
Route::get('/business', 'Business\DashboardController@index')->name('business');
Route::get('/business/dashboard', 'Business\DashboardController@index')->name('business.dashboard');

//Listings
Route::get('/business/listings', 'Business\ListingController@index')->name('listings');
Route::get('/business/listings/create', 'Business\ListingController@create')->name('listings.create');
Route::post('/business/listings/add', 'Business\ListingController@add')->name('listings.add');
Route::post('/business/listings/change/ownership', 'Business\ListingController@change_ownership')->name('listings.change.ownership');
Route::get('/business/listings/{id}/edit', 'Business\ListingController@edit')->name('listings.edit');
Route::post('/business/listings/update', 'Business\ListingController@update')->name('listings.update');
Route::get('/business/listings/{id}/products', 'Business\ListingController@product')->name('listings.products');
Route::get('/business/listings/{id}/product/create', 'Business\ListingController@create_product')->name('listings.create.product');
Route::post('/business/listings/{id}/product/create', 'Business\ListingController@add_product')->name('listings.add.product');
Route::get('/business/listings/{id}/product/edit', 'Business\ListingController@edit_product')->name('listings.edit.product');
Route::post('/business/listings/product/update', 'Business\ListingController@update_product')->name('listings.update.product');
Route::post('/business/listings/product/delete', 'Business\ListingController@delete_product')->name('listings.delete.product');





//Products
Route::get('/business/products', 'Business\ProductController@index')->name('products');
Route::get('/business/products/sold', 'Business\ProductController@sold')->name('products.sold');
Route::get('/business/products/sold/delivery/note', 'Business\ProductController@sold');
Route::post('/business/products/sold/delivery/note', 'Business\ProductController@add_delivery_note')->name('products.sold.delivery.note');

//business bulk Delete added by Max
Route::post('/business/products/bulk-delete', 'Business\ProductController@bulkDeleteProducts')->name('listings.bulk.delete.products');


// Route::post('/listings/products/delete-multiple', [ProductController::class, 'bulkDelete'])->name('listings.delete.multiple.products');





//Admin Section
Route::get('/admin', 'Admin\DashboardController@index')->name('admin');
Route::get('/admin/dashboard', 'Admin\DashboardController@index')->name('admin.dashboard');

//Admin Users
Route::get('/admin/users/individual', 'Admin\DashboardController@individual_users')->name('admin.individual.users');
Route::get('/admin/users/individual/{id}/delete', 'Admin\DashboardController@delete_individual_users')->name('admin.individual.users.delete');
Route::get('/admin/users/business', 'Admin\DashboardController@business_users')->name('admin.business.users');
Route::get('/admin/users/business/{id}/delete', 'Admin\DashboardController@delete_business_users')->name('admin.business.users.delete');
Route::get('/admin/users/premium/subscriptions', 'Admin\DashboardController@premium_subscriptions')->name('admin.users.premium.subscriptions');

//Admin Listings
Route::get('/admin/listings', 'Admin\ListingController@index')->name('admin.listings');
Route::get('/admin/listings/{id}/edit', 'Admin\ListingController@edit')->name('admin.listings.edit');
Route::get('/admin/listings/{id}/delete', 'Admin\ListingController@delete')->name('admin.listings.delete');
Route::post('/admin/listings/update', 'Admin\ListingController@update')->name('admin.listings.update');
Route::get('/admin/listings/{id}/view', 'Admin\ListingController@view')->name('admin.view.listing');
Route::get('/admin/listings/{id}/products', 'Admin\ListingController@products')->name('admin.listing.products');
Route::get('/admin/listings/{id}/branch/view', 'Admin\ListingController@branch_view')->name('admin.listing.branch.view');
Route::post('/admin/listings/action', 'Admin\ListingController@action')->name('admin.listing.action');
Route::post('/admin/listings/featured', 'Admin\ListingController@featured')->name('admin.listing.featured');

//Admin Pages Section
Route::get('/admin/pages', 'Admin\PagesController@index')->name('admin.pages');
Route::get('/admin/pages/create', 'Admin\PagesController@create')->name('admin.pages.create');
Route::get('/admin/pages/{id}/edit', 'Admin\PagesController@edit')->name('admin.pages.edit');
Route::post('/admin/pages/save', 'Admin\PagesController@save')->name('admin.pages.save');
Route::post('/admin/pages/delete', 'Admin\PagesController@delete')->name('admin.pages.delete');

//Admin Ads Section
Route::get('/admin/ads', 'Admin\AdsController@index')->name('admin.ads');
Route::get('/admin/ads/new', 'Admin\AdsController@create')->name('admin.ad.new');
Route::post('/admin/ads/new', 'Admin\AdsController@add')->name('admin.ad.add');
Route::get('/admin/ads/edit/{id}', 'Admin\AdsController@edit')->name('admin.ad.edit');
Route::post('/admin/ads/update', 'Admin\AdsController@update')->name('admin.ad.update');
Route::get('/admin/ads/unapprove/{id}', 'Admin\AdsController@unapprove')->name('admin.ad.unapprove');
Route::get('/admin/ads/approve/{id}', 'Admin\AdsController@approve')->name('admin.ad.approve');

//Admin Blog Section
Route::get('/admin/blog/posts', 'Admin\BlogController@post')->name('admin.blog.posts');
Route::get('/admin/blog/post/create', 'Admin\BlogController@create_post')->name('admin.blog.create.post');
Route::post('/admin/blog/post/create', 'Admin\BlogController@add_post')->name('admin.blog.add.post');
Route::get('/admin/blog/post/{id}/edit', 'Admin\BlogController@edit_post')->name('admin.blog.edit.post');
Route::post('/admin/blog/post/update', 'Admin\BlogController@update_post')->name('admin.blog.update.post');
Route::post('/admin/blog/post/delete', 'Admin\BlogController@delete_post')->name('admin.blog.delete.post');

//Admin Grooming Tips Section
Route::get('/admin/groomingtips', 'Admin\GroomTipsController@index')->name('admin.groomingtips');
Route::get('/admin/groomingtips/create', 'Admin\GroomTipsController@create')->name('admin.groomingtip.create');
Route::post('/admin/groomingtips/create', 'Admin\GroomTipsController@add')->name('admin.groomingtip.add');
Route::get('/admin/groomingtips/{id}/edit', 'Admin\GroomTipsController@edit')->name('admin.groomingtip.edit');
Route::post('/admin/groomingtips/update', 'Admin\GroomTipsController@update')->name('admin.groomingtip.update');
Route::post('/admin/groomingtips/delete', 'Admin\GroomTipsController@delete')->name('admin.groomingtip.delete');
Route::get('/admin/groomingtips/categories', 'Admin\GroomTipsController@categories')->name('admin.groomingtip.categories');
Route::get('/admin/groomingtips/category/new', 'Admin\GroomTipsController@category_create')->name('admin.groomingtip.category.new');
Route::post('/admin/groomingtips/category/new', 'Admin\GroomTipsController@category_add')->name('admin.groomingtip.category.add');
Route::get('/admin/groomingtips/category/edit/{id}', 'Admin\GroomTipsController@category_edit')->name('admin.groomingtip.category.edit');
Route::post('/admin/groomingtips/category/update', 'Admin\GroomTipsController@category_update')->name('admin.groomingtip.category.update');

//Admin Discovers Section
Route::get('/admin/discovers', 'Admin\DiscoverController@index')->name('admin.discovers');
Route::get('/admin/discovers/create', 'Admin\DiscoverController@create')->name('admin.discover.create');
Route::post('/admin/discovers/create', 'Admin\DiscoverController@add')->name('admin.discover.add');
Route::get('/admin/discovers/{id}/edit', 'Admin\DiscoverController@edit')->name('admin.discover.edit');
Route::post('/admin/discovers/update', 'Admin\DiscoverController@update')->name('admin.discover.update');
Route::post('/admin/discovers/delete', 'Admin\DiscoverController@delete')->name('admin.discover.delete');

//Admin PYLs Section
Route::get('/admin/pyls', 'Admin\PYLController@index')->name('admin.pyls');
Route::get('/admin/pyls/uploads', 'Admin\PYLController@uploads')->name('admin.pyls.uploads');
Route::get('/admin/pyls/create', 'Admin\PYLController@create')->name('admin.pyl.create');
Route::post('/admin/pyls/create', 'Admin\PYLController@add')->name('admin.pyl.add');
Route::get('/admin/pyls/{id}/edit', 'Admin\PYLController@edit')->name('admin.pyl.edit');
Route::post('/admin/pyls/update', 'Admin\PYLController@update')->name('admin.pyl.update');
Route::post('/admin/pyls/delete', 'Admin\PYLController@delete')->name('admin.pyl.delete');

//Admin TV Section
Route::get('/admin/tvs', 'Admin\TVsController@index')->name('admin.tvs');
Route::get('/admin/tvs/new', 'Admin\TVsController@create')->name('admin.tv.new');
Route::post('/admin/tvs/new', 'Admin\TVsController@add')->name('admin.tv.add');
Route::get('/admin/tvs/edit/{id}', 'Admin\TVsController@edit')->name('admin.tv.edit');
Route::post('/admin/tvs/update', 'Admin\TVsController@update')->name('admin.tv.update');
Route::get('/admin/tvs/unapprove/{id}', 'Admin\TVsController@unapprove')->name('admin.tv.unapprove');
Route::get('/admin/tvs/approve/{id}', 'Admin\TVsController@approve')->name('admin.tv.approve');
Route::get('/admin/tvs/categories', 'Admin\TVsController@categories')->name('admin.tv.categories');
Route::get('/admin/tvs/category/new', 'Admin\TVsController@category_create')->name('admin.tv.category.new');
Route::post('/admin/tvs/category/new', 'Admin\TVsController@category_add')->name('admin.tv.category.add');
Route::get('/admin/tvs/category/edit/{id}', 'Admin\TVsController@category_edit')->name('admin.tv.category.edit');
Route::post('/admin/tvs/category/update', 'Admin\TVsController@category_update')->name('admin.tv.category.update');
Route::post('/admin/tvs/delete', 'Admin\TVsController@delete')->name('admin.tv.delete');

//Admin Featured Category Section
Route::get('/admin/featured/categories', 'Admin\FeaturedCategoryController@index')->name('admin.featured.categories');
Route::get('/admin/featured/category/new', 'Admin\FeaturedCategoryController@create')->name('admin.featured.category.new');
Route::post('/admin/featured/category/new', 'Admin\FeaturedCategoryController@add')->name('admin.featured.category.add');
Route::get('/admin/featured/category/edit/{id}', 'Admin\FeaturedCategoryController@edit')->name('admin.featured.category.edit');
Route::post('/admin/featured/category/update', 'Admin\FeaturedCategoryController@update')->name('admin.featured.category.update');
Route::post('/admin/featured/category/action', 'Admin\FeaturedCategoryController@action')->name('admin.featured.category.action');

//Admin Blog Category Section
Route::get('/admin/blog/categories', 'Admin\BlogCategoryController@index')->name('admin.blog.categories');
Route::get('/admin/blog/category/new', 'Admin\BlogCategoryController@create')->name('admin.blog.category.new');
Route::post('/admin/blog/category/new', 'Admin\BlogCategoryController@add')->name('admin.blog.category.add');
Route::get('/admin/blog/category/edit/{id}', 'Admin\BlogCategoryController@edit')->name('admin.blog.category.edit');
Route::post('/admin/blog/category/update', 'Admin\BlogCategoryController@update')->name('admin.blog.category.update');

//Admin Discover Category Section
Route::get('/admin/discover/categories', 'Admin\DiscoverCategoryController@index')->name('admin.discover.categories');
Route::get('/admin/discover/category/new', 'Admin\DiscoverCategoryController@create')->name('admin.discover.category.new');
Route::post('/admin/discover/category/new', 'Admin\DiscoverCategoryController@add')->name('admin.discover.category.add');
Route::get('/admin/discover/category/edit/{id}', 'Admin\DiscoverCategoryController@edit')->name('admin.discover.category.edit');
Route::post('/admin/discover/category/update', 'Admin\DiscoverCategoryController@update')->name('admin.discover.category.update');
Route::get('/admin/discover/category/{id}/delete', 'Admin\DiscoverCategoryController@delete')->name('admin.discover.category.delete');

//Admin Category Section
Route::get('/admin/categories', 'Admin\CategoryController@index')->name('admin.categories');
Route::get('/admin/category/new', 'Admin\CategoryController@create')->name('admin.category.new');
Route::post('/admin/category/new', 'Admin\CategoryController@add')->name('admin.category.add');
Route::get('/admin/category/edit/{id}', 'Admin\CategoryController@edit')->name('admin.category.edit');
Route::get('/admin/category/{id}/subcategories', 'Admin\CategoryController@subcategory')->name('admin.category.subcategory');
Route::get('/admin/category/{id}/add/subcategory', 'Admin\CategoryController@create_subcategory')->name('admin.subcategory.add');
Route::post('/admin/category/save/subcategory', 'Admin\CategoryController@add_subcategory')->name('admin.subcategory.save');
Route::get('/admin/category/subcategory/edit/{id}', 'Admin\CategoryController@edit_subcategory')->name('admin.subcategory.edit');
Route::post('/admin/category/update', 'Admin\CategoryController@update')->name('admin.category.update');
Route::post('/admin/subcategory/update', 'Admin\CategoryController@update_subcategory')->name('admin.subcategory.update');

//Admin Location Section
Route::get('/admin/locations', 'Admin\LocationController@index')->name('admin.locations');
Route::get('/admin/location/new', 'Admin\LocationController@create')->name('admin.location.new');
Route::post('/admin/location/new', 'Admin\LocationController@add')->name('admin.location.add');
Route::get('/admin/location/{id}/areas', 'Admin\LocationController@area')->name('admin.location.areas');
Route::get('/admin/location/edit/{id}', 'Admin\LocationController@edit')->name('admin.location.edit');
Route::post('/admin/location/update', 'Admin\LocationController@update')->name('admin.location.update');
Route::get('/admin/location/{id}/add/area', 'Admin\LocationController@create_area')->name('admin.area.add');
Route::post('/admin/location/save/area', 'Admin\LocationController@add_area')->name('admin.area.save');
Route::get('/admin/location/area/edit/{id}', 'Admin\LocationController@edit_area')->name('admin.area.edit');
Route::post('/admin/area/update', 'Admin\LocationController@update_area')->name('admin.area.update');
Route::post('/admin/location/action', 'Admin\LocationController@action')->name('admin.location.action');

//Admin Product Section
Route::get('/admin/products', 'Admin\ProductController@index')->name('admin.products');
Route::get('/admin/products/orders', 'Admin\ProductController@orders')->name('admin.products.orders');
Route::get('/admin/products/sold', 'Admin\ProductController@sold')->name('admin.products.sold');
Route::get('/admin/products/sold/{id}/deliverynotes', 'Admin\ProductController@deliverynotes')->name('admin.products.sold.deliverynotes');
Route::get('/admin/products/sold/{id}/delivered', 'Admin\ProductController@deliverynotes');
Route::post('/admin/products/sold/delivered', 'Admin\ProductController@delivered')->name('admin.products.sold.delivered');
Route::get('/admin/products/{id}/view', 'Admin\ProductController@view')->name('admin.products.view.product');
Route::post('/admin/products/action', 'Admin\ProductController@action')->name('admin.product.action');
Route::post('/admin/products/delete', 'Admin\ProductController@delete')->name('admin.product.delete');
Route::post('/admin/products/featured', 'Admin\ProductController@featured')->name('admin.product.featured');

//Admin Product Category Section
Route::get('/admin/products/categories', 'Admin\ProductCategoryController@index')->name('admin.products.categories');
Route::get('/admin/products/category/new', 'Admin\ProductCategoryController@create')->name('admin.products.category.new');
Route::post('/admin/products/category/new', 'Admin\ProductCategoryController@add')->name('admin.products.category.add');
Route::get('/admin/products/category/edit/{id}', 'Admin\ProductCategoryController@edit')->name('admin.products.category.edit');
Route::get('/admin/products/category/{id}/subcategories', 'Admin\ProductCategoryController@subcategory')->name('admin.products.category.subcategory');
Route::get('/admin/products/category/{id}/add/subcategory', 'Admin\ProductCategoryController@create_subcategory')->name('admin.products.subcategory.add');
Route::post('/admin/products/category/save/subcategory', 'Admin\ProductCategoryController@add_subcategory')->name('admin.products.subcategory.save');
Route::get('/admin/products/category/subcategory/edit/{id}', 'Admin\ProductCategoryController@edit_subcategory')->name('admin.products.subcategory.edit');
Route::post('/admin/products/category/update', 'Admin\ProductCategoryController@update')->name('admin.products.category.update');
Route::post('/admin/products/subcategory/update', 'Admin\ProductCategoryController@update_subcategory')->name('admin.products.subcategory.update');

//Admin Premium Section
Route::get('/admin/premium/categories', 'Admin\PremiumController@category_index')->name('admin.premium.categories');
Route::get('/admin/premium/category/new', 'Admin\PremiumController@category_create')->name('admin.premium.category.new');
Route::post('/admin/premium/category/new', 'Admin\PremiumController@category_add')->name('admin.premium.category.add');
Route::get('/admin/premium/category/edit/{id}', 'Admin\PremiumController@category_edit')->name('admin.premium.category.edit');
Route::post('/admin/premium/category/update', 'Admin\PremiumController@category_update')->name('admin.premium.category.update');
Route::get('/admin/premia', 'Admin\PremiumController@index')->name('admin.premia');
Route::get('/admin/premia/create', 'Admin\PremiumController@create')->name('admin.premium.create');
Route::post('/admin/premia/create', 'Admin\PremiumController@add')->name('admin.premium.add');
Route::get('/admin/premia/{id}/edit', 'Admin\PremiumController@edit')->name('admin.premium.edit');
Route::post('/admin/premia/update', 'Admin\PremiumController@update')->name('admin.premium.update');
Route::post('/admin/premia/delete', 'Admin\PremiumController@delete')->name('admin.premium.delete');

//Admin Settings Section
Route::get('/admin/settings', 'Admin\SettingsController@index')->name('admin.settings');
Route::get('/admin/settings/{name}/edit/image', 'Admin\SettingsController@edit_image')->name('admin.settings.edit.image');
Route::post('/admin/settings/update/image', 'Admin\SettingsController@update_image')->name('admin.settings.update.image');
Route::get('/admin/settings/{name}/edit', 'Admin\SettingsController@edit')->name('admin.settings.edit');
Route::post('/admin/settings/update', 'Admin\SettingsController@update')->name('admin.settings.update');

//Black Ops
Route::get('/blackops', 'HomeController@blackops');

//Notification
Route::get('/cronwork', 'HomeController@notify');

//Pages that not coded into the system 
Route::get('/{slug}', 'HomeController@page')->name('pages');
Route::get('/{slug}/{product_slug}', 'HomeController@product')->name('brand.product');


