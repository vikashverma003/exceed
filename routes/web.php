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
Route::any('/ckfinder/connector', '\CKSource\CKFinderBridge\Controller\CKFinderController@requestAction')
    ->name('ckfinder_connector');

Route::any('/ckfinder/browser', '\CKSource\CKFinderBridge\Controller\CKFinderController@browserAction')
    ->name('ckfinder_browser');

// admin Routes Start here --------------------------------------------------------------
Route::group(['prefix'=>'admin'], function(){
    
    Route::middleware(['admin.guest'])->group(function () {
        Route::get('/login', function () {
            return view('admin.auth.login');    
        });
        Route::post('/login', 'Admin\DashboardController@login')->name('admin.login');
    });

	Route::middleware(['admin.auth'])->group(function () {
        Route::get('/', function () {
            return redirect('admin/login');    
        });

        Route::get('logout', 'Admin\DashboardController@logout')->name('admin.logout');
        Route::get('/dashboard','Admin\DashboardController@index')->name('admin.dashboard'); 
        Route::get('/dashboardGraphs','Admin\DashboardController@dashboardGraphs')->name('admin.dashboardGraphs'); 
        
        Route::get('/profile', 'Admin\DashboardController@getProfile')->name('admin.profile');
        Route::post('/profile', 'Admin\DashboardController@postProfile')->name('admin.postProfile');

        Route::get('/users','Admin\UsersController@index'); // users listing
        Route::get('/users/export','Admin\UsersController@export');
        Route::get('/user/detail/{id}','Admin\UsersController@userDetail'); // user detail
        Route::post('/user/status','Admin\UsersController@userStatusUpdate'); // user Status update

        Route::get('/contactus','Admin\QueryController@listContactQueries');
        Route::get('/contactus/export','Admin\QueryController@exportContacts');
        Route::get('/quotes','Admin\QueryController@listQuotesQueries');
        Route::get('/quotes/export','Admin\QueryController@exportQuotes');


        Route::resource('/manufacturers','Admin\ManufacturerController'); // manufacturers routes
        Route::post('/manufacturer/status','Admin\ManufacturerController@changeStatus');
        Route::get('manufacturer-categories/{id}','Admin\ManufacturerController@assignCategory');
        Route::post('manufacturer-categories','Admin\ManufacturerController@saveAssignCategories');
        Route::get('manufacturercategory','Admin\ManufacturerController@getSelectedManufacturerCategory');
        Route::get('manufacturerproducts','Admin\ManufacturerController@getSelectedManufacturerProducts');
        

        Route::resource('/products','Admin\ProductController');
        Route::post('product/status','Admin\ProductController@status');

        Route::resource('courses','Admin\CourseController');
        Route::post('course/status','Admin\CourseController@status');
        Route::get('course/schedule','Admin\CourseController@schedule');
        Route::get('courses-export','Admin\CourseController@export');


        Route::get('outlines/{id}','Admin\CourseController@outlines');
        Route::get('outline/create/{id}','Admin\CourseController@createOutline');
        Route::post('outline', 'Admin\CourseController@storeOutline');
        Route::get('outline/edit/{id}','Admin\CourseController@editOutline');
        Route::post('outline/update','Admin\CourseController@updateOutline');
        Route::post('outline/status','Admin\CourseController@updateOutlineStatus');
        Route::post('outline/delete','Admin\CourseController@deleteOutline');


        // timings
        Route::get('course-time/{id}','Admin\CourseController@getTimelist');
        Route::post('course-time/create','Admin\CourseController@saveTimelist');
        Route::post('course-time/update','Admin\CourseController@updateTimelist');

        Route::resource('/categories','Admin\CategoryController'); // categories routes
        Route::post('/category/status','Admin\CategoryController@changeStatus');

        Route::get('cms','Admin\CmsController@index');
        Route::post('cms-content','Admin\CmsController@update');
        Route::post('service-content','Admin\CmsController@updateServiceContent');
        
        Route::resource('locations','Admin\LocationController'); // location routes
        Route::post('location/status','Admin\LocationController@status'); // location routes

        Route::resource('training-types','Admin\TrainingTypeController'); // location routes
        Route::post('training-type/status','Admin\TrainingTypeController@status'); // location routes
        
        Route::resource('coupons','Admin\CouponController'); // location routes
        Route::post('coupon/status','Admin\CouponController@status'); // location routes
        Route::get('coupon/user','Admin\CouponController@getUsers'); // location routes
        
        Route::resource('/servicecards','Admin\ServiceCardContentController');
        Route::resource('/faqs','Admin\FaqController');

        Route::resource('/testimonials','Admin\TestimonialController'); // testimonials routes
        Route::post('/testimonial/status','Admin\TestimonialController@changeStatus');

        // sub categories routes
        Route::get('/subcategories/{category_id}','Admin\CategoryController@listSubCategories');
        Route::post('/subcategory/add','Admin\CategoryController@addSubCategory');
        Route::post('/subcategory/status','Admin\CategoryController@subCategoryStatus');

        Route::resource('/companylogos','Admin\CompanyLogoController'); // testimonials routes
        Route::post('/companylogo/status','Admin\CompanyLogoController@changeStatus');

        Route::get('settings/contact-mails','Admin\MasterSettingController@getContactMails');
        Route::post('settings/contact-mails','Admin\MasterSettingController@updateContactMails');

        Route::get('settings/termspage','Admin\MasterSettingController@getTermContent');
        Route::post('settings/updatetermspage','Admin\MasterSettingController@updateTermContent');

        Route::get('settings/privacypage','Admin\MasterSettingController@getPrivacyContent');
        Route::post('settings/updateprivacypage','Admin\MasterSettingController@updatePrivacyContent');

        Route::get('settings/cookiepage','Admin\MasterSettingController@getCookieContent');
        Route::post('settings/updatecookiepage','Admin\MasterSettingController@updateCookieContent');

        Route::get('settings/training-sites','Admin\MasterSettingController@getAllTrainingSitesContent');
        Route::get('settings/training-site/create','Admin\MasterSettingController@createTrainingSiteContent');
        Route::post('settings/training-site/store','Admin\MasterSettingController@saveTrainingSiteContent');
        Route::get('settings/training-site/{id}/edit','Admin\MasterSettingController@editTrainingSiteContent');
        Route::post('settings/training-site/update','Admin\MasterSettingController@updateTrainingSiteContent');
        Route::post('settings/training-site/status','Admin\MasterSettingController@statusTrainingSiteContent');

        Route::get('/orders','Admin\OrderController@index');
        Route::get('/order/detail/{id}','Admin\OrderController@view');
        
        Route::middleware(['superadmin'])->group(function () {
            Route::resource('sub-admin','Admin\SubAdminController');
            Route::post('sub-admin/status','Admin\SubAdminController@status');
        });
	});
});


// User Routes Start here -------------------------------------------------------------
Route::middleware(['user.guest'])->group(function () {

    Route::get('/', 'HomeController@index')->name('user.landing');
    Route::post('forgot-password', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('resend-account-activation', 'Auth\ForgotPasswordController@sendAccountActivationLink');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset','Auth\ResetPasswordController@reset')->name('password.update');
    Route::get('reset-success','Auth\ResetPasswordController@resetSuccess')->name('resetSuccess');
    
    Route::post('register','Auth\RegisterController@register');
    Route::post('login','Auth\LoginController@login');
    Route::get('verifyemail/{token}','User\ProfileController@verifyEmail')->name('verifyemail');
    
    // facebook
    Route::get('/login/{provider}','User\SocialAuthController@redirect')->name('login.social.redirect');
    Route::get('/login/{provider}/callback', 'User\SocialAuthController@callback');

    Route::get('about-us','HomeController@aboutUsPage');
    Route::get('gallery','HomeController@galleryPage');
    Route::get('press-release','HomeController@pressReleasePage');
    Route::get('terms','HomeController@getTermsPage');
    Route::get('privacy-policy','HomeController@getPrivacyPolicyPage');
    Route::get('cookie-policy','HomeController@getCookiePolicyPage');
    Route::get('training-site/{slug}','HomeController@getTrainingSiteInfo');
    Route::get('help','HomeController@getHelpPage');
    
    Route::post('contact-us', 'HomeController@contactUs');
    Route::post('quote-query', 'HomeController@quoteQuery');
    Route::post('locations-quote-query', 'HomeController@quoteQueryLocationsModal');

    Route::post('cart-quote-query', 'HomeController@cartQuoteQuery');
    Route::get('manufacturers/{name}','HomeController@manufacturerCourses');
    Route::get('services/{title}','HomeController@services');
    
    Route::get('course/{title}','HomeController@courseDetails');
    Route::get('outline-pdf','HomeController@coursePdf');
    Route::get('course-timings','HomeController@courseLocationTimings');

    // list courses
    Route::match(['get', 'post'], 'products','HomeController@courseListing')->name('user.products');
    Route::match(['get', 'post'], 'courseListingAjax','HomeController@courseListingAjax')->name('user.courseListingAjax');
    
    Route::post('products-filter', 'HomeController@courseListingBasedOnFilter');
    Route::get('products-filter-course/{id}/{name}', 'HomeController@productsFilterCourse');
    Route::post('products-append-course', 'HomeController@productsAppendCourse')->name('products-append-course');



    Route::post('shareCourse','HomeController@shareCourse');
    Route::get('ly/{slug}','HomeController@shortenLink');
    Route::get('advance-filter-manufactuer-data','HomeController@advanceFilterManufactuerData');
    Route::get('advance-filter-catgory-data','HomeController@advanceFilterCategoryData');

    // quote
    Route::get('quote-manufacturers','HomeController@getQuoteManufacturers');
    Route::get('quote-products','HomeController@getQuoteProducts');
    Route::get('quote-courses','HomeController@getQuoteCourses');
    Route::get('country-code','HomeController@getCountryCode');
    Route::get('course-locations','HomeController@getCourseLocations');
    

    // unauth routes
    Route::get('cart','User\ProductController@getCart');
    Route::post('save-attendence','User\ProductController@saveAttedences');
    Route::post('addToCart','User\ProductController@addUpdateCart');
    Route::post('addToCartMultiple','User\ProductController@addUpdateMultipleCart');
    Route::post('removeCartCourse','User\ProductController@removeCourseFromCart');
    Route::post('update-course-seats','User\ProductController@updateCourseSeats');
    Route::get('check-course-cart','User\ProductController@checkCourseInCart');
});

Route::middleware(['user.auth'])->group(function () {
    Route::get('logout', 'Auth\LoginController@logout')->name('user.logout');
    Route::post('save-customer-type', 'User\ProfileController@saveCustomerType');
    Route::get('/profile','User\ProfileController@showProfilePage');
    Route::post('/change-password', 'User\ProfileController@changePassword');
    Route::post('/update-profile', 'User\ProfileController@updateProfile');
    Route::get('/mycourses','User\ProfileController@myCourses');
    Route::get('checkout','User\ProductController@getCheckout');

    Route::post('payment','User\ProductController@payment');
    Route::post('apply-coupon','User\ProductController@applyCoupon');
    Route::post('remove-coupon','User\ProductController@removeCoupon');
    
    Route::get('transactions', 'User\ProfileController@transactions');
    Route::get('transaction-detail/{id}', 'User\ProfileController@transactionDetails');
});