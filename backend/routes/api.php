<?php

use App\Features\Authentication\Controllers\ForgotPasswordController;
use App\Features\Authentication\Controllers\LoginController;
use App\Features\Authentication\Controllers\RegisterController;
use App\Features\Authentication\Controllers\ResetPasswordController;
use App\Features\Roles\Controllers\RolePaginateController;
use App\Features\Roles\Enums\Roles;
use App\Features\Users\Controllers\UserCreateController;
use App\Features\Users\Controllers\UserDeleteController;
use App\Features\Users\Controllers\UserExportController;
use App\Features\Users\Controllers\UserPaginateController;
use App\Features\Users\Controllers\UserToggleStatusController;
use App\Features\Users\Controllers\UserToggleVerificationController;
use App\Features\Users\Controllers\UserUpdateController;
use App\Features\Users\Controllers\UserViewController;
use App\Features\Charges\Controllers\ChargeCreateController;
use App\Features\Charges\Controllers\ChargeDeleteController;
use App\Features\Charges\Controllers\ChargeExportController;
use App\Features\Charges\Controllers\ChargePaginateController;
use App\Features\Charges\Controllers\ChargeToggleStatusController;
use App\Features\Charges\Controllers\ChargeUpdateController;
use App\Features\Charges\Controllers\ChargeViewController;
use App\Features\Charges\Controllers\ChargeSlugController;
use App\Features\Taxes\Controllers\TaxCreateController;
use App\Features\Taxes\Controllers\TaxDeleteController;
use App\Features\Taxes\Controllers\TaxExportController;
use App\Features\Taxes\Controllers\TaxPaginateController;
use App\Features\Taxes\Controllers\TaxToggleStatusController;
use App\Features\Taxes\Controllers\TaxUpdateController;
use App\Features\Taxes\Controllers\TaxViewController;
use App\Features\Taxes\Controllers\TaxSlugController;
use App\Features\Testimonials\Controllers\TestimonialCreateController;
use App\Features\Testimonials\Controllers\TestimonialDeleteController;
use App\Features\Testimonials\Controllers\TestimonialExportController;
use App\Features\Testimonials\Controllers\TestimonialPaginateController;
use App\Features\Testimonials\Controllers\TestimonialToggleStatusController;
use App\Features\Testimonials\Controllers\TestimonialUpdateController;
use App\Features\Testimonials\Controllers\TestimonialViewController;
use App\Features\DeliverySlots\Controllers\DeliverySlotCreateController;
use App\Features\DeliverySlots\Controllers\DeliverySlotDeleteController;
use App\Features\DeliverySlots\Controllers\DeliverySlotExportController;
use App\Features\DeliverySlots\Controllers\DeliverySlotPaginateController;
use App\Features\DeliverySlots\Controllers\DeliverySlotToggleStatusController;
use App\Features\DeliverySlots\Controllers\DeliverySlotUpdateController;
use App\Features\DeliverySlots\Controllers\DeliverySlotViewController;
use App\Features\Blogs\Controllers\BlogCreateController;
use App\Features\Blogs\Controllers\BlogDeleteController;
use App\Features\Blogs\Controllers\BlogExportController;
use App\Features\Blogs\Controllers\BlogPaginateController;
use App\Features\Blogs\Controllers\BlogToggleStatusController;
use App\Features\Blogs\Controllers\BlogUpdateController;
use App\Features\Blogs\Controllers\BlogViewController;
use App\Features\Blogs\Controllers\BlogSlugController;
use App\Features\Categories\Controllers\CategoryCreateController;
use App\Features\Categories\Controllers\CategoryDeleteController;
use App\Features\Categories\Controllers\CategoryExportController;
use App\Features\Categories\Controllers\CategoryPaginateController;
use App\Features\Categories\Controllers\CategoryToggleStatusController;
use App\Features\Categories\Controllers\CategoryUpdateController;
use App\Features\Categories\Controllers\CategoryViewController;
use App\Features\Categories\Controllers\CategorySlugController;
use App\Features\SubCategories\Controllers\SubCategoryCreateController;
use App\Features\SubCategories\Controllers\SubCategoryDeleteController;
use App\Features\SubCategories\Controllers\SubCategoryExportController;
use App\Features\SubCategories\Controllers\SubCategoryPaginateController;
use App\Features\SubCategories\Controllers\SubCategoryToggleStatusController;
use App\Features\SubCategories\Controllers\SubCategoryUpdateController;
use App\Features\SubCategories\Controllers\SubCategoryViewController;
use App\Features\SubCategories\Controllers\SubCategorySlugController;
use App\Features\Products\Controllers\ProductCreateController;
use App\Features\Products\Controllers\ProductDeleteController;
use App\Features\Products\Controllers\ProductExportController;
use App\Features\Products\Controllers\ProductPaginateController;
use App\Features\Products\Controllers\ProductToggleStatusController;
use App\Features\Products\Controllers\ProductUpdateController;
use App\Features\Products\Controllers\ProductViewController;
use App\Features\Products\Controllers\ProductSlugController;
use App\Features\LegalContents\Controllers\LegalContentCreateController;
use App\Features\LegalContents\Controllers\LegalContentDeleteController;
use App\Features\LegalContents\Controllers\LegalContentExportController;
use App\Features\LegalContents\Controllers\LegalContentPaginateController;
use App\Features\LegalContents\Controllers\LegalContentToggleStatusController;
use App\Features\LegalContents\Controllers\LegalContentUpdateController;
use App\Features\LegalContents\Controllers\LegalContentViewController;
use App\Features\LegalContents\Controllers\LegalContentSlugController;
use App\Features\Features\Controllers\FeatureCreateController;
use App\Features\Features\Controllers\FeatureDeleteController;
use App\Features\Features\Controllers\FeatureExportController;
use App\Features\Features\Controllers\FeaturePaginateController;
use App\Features\Features\Controllers\FeatureToggleStatusController;
use App\Features\Features\Controllers\FeatureUpdateController;
use App\Features\Features\Controllers\FeatureViewController;
use App\Features\Banners\Controllers\BannerCreateController;
use App\Features\Banners\Controllers\BannerDeleteController;
use App\Features\Banners\Controllers\BannerExportController;
use App\Features\Banners\Controllers\BannerPaginateController;
use App\Features\Banners\Controllers\BannerToggleStatusController;
use App\Features\Banners\Controllers\BannerUpdateController;
use App\Features\Banners\Controllers\BannerViewController;
use App\Features\AboutSections\Controllers\AboutSectionCreateController;
use App\Features\AboutSections\Controllers\AboutSectionDeleteController;
use App\Features\AboutSections\Controllers\AboutSectionExportController;
use App\Features\AboutSections\Controllers\AboutSectionPaginateController;
use App\Features\AboutSections\Controllers\AboutSectionToggleStatusController;
use App\Features\AboutSections\Controllers\AboutSectionUpdateController;
use App\Features\AboutSections\Controllers\AboutSectionViewController;
use App\Features\BillingInformations\Controllers\BillingInformationCreateController;
use App\Features\BillingInformations\Controllers\BillingInformationDeleteController;
use App\Features\BillingInformations\Controllers\BillingInformationExportController;
use App\Features\BillingInformations\Controllers\BillingInformationPaginateController;
use App\Features\BillingInformations\Controllers\BillingInformationUpdateController;
use App\Features\BillingInformations\Controllers\BillingInformationViewController;
use App\Features\ContactFormEnquiries\Controllers\ContactFormEnquiryCreateController;
use App\Features\ContactFormEnquiries\Controllers\ContactFormEnquiryDeleteController;
use App\Features\ContactFormEnquiries\Controllers\ContactFormEnquiryExportController;
use App\Features\ContactFormEnquiries\Controllers\ContactFormEnquiryPaginateController;
use App\Features\ContactFormEnquiries\Controllers\ContactFormEnquiryViewController;
use App\Features\PaymentOptions\Controllers\PaymentOptionExportController;
use App\Features\PaymentOptions\Controllers\PaymentOptionPaginateController;
use App\Features\PaymentOptions\Controllers\PaymentOptionSlugController;
use App\Features\PaymentOptions\Controllers\PaymentOptionToggleStatusController;
use App\Features\PaymentOptions\Controllers\PaymentOptionViewController;
use App\Features\TexteditorImages\Controllers\TexteditorImageCreateController;
use App\Http\Enums\Guards;
use App\Http\Enums\Throttle;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->middleware([Throttle::API->middleware()])->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('/login', [LoginController::class, 'index'])->middleware([Throttle::AUTH->middleware()]);
        Route::post('/register', [RegisterController::class, 'index'])->middleware([Throttle::AUTH->middleware()]);
        Route::post('/forgot-password', [ForgotPasswordController::class, 'index'])->middleware([Throttle::AUTH->middleware()]);
        Route::post('/reset-password/{token}', [ResetPasswordController::class, 'index'])->middleware([Throttle::AUTH->middleware()])->whereAlphaNumeric('token')->name('password.reset');
    });

    Route::middleware([Guards::API->middleware(), 'verified'])->group(function () {

        Route::middleware([Roles::SuperAdmin->middleware()])->group(function () {
            Route::prefix('users')->group(function () {
                Route::get('/excel', [UserExportController::class, 'index']);
                Route::get('/paginate', [UserPaginateController::class, 'index']);
                Route::post('/create', [UserCreateController::class, 'index']);
                Route::post('/update/{id}', [UserUpdateController::class, 'index']);
                Route::get('/status/{id}', [UserToggleStatusController::class, 'index']);
                Route::get('/verify/{id}', [UserToggleVerificationController::class, 'index']);
                Route::get('/view/{id}', [UserViewController::class, 'index']);
                Route::delete('/delete/{id}', [UserDeleteController::class, 'index']);
            });
            
            Route::prefix('charges')->group(function () {
                Route::get('/excel', [ChargeExportController::class, 'index']);
                Route::get('/paginate', [ChargePaginateController::class, 'index']);
                Route::post('/create', [ChargeCreateController::class, 'index']);
                Route::post('/update/{id}', [ChargeUpdateController::class, 'index']);
                Route::get('/status/{id}', [ChargeToggleStatusController::class, 'index']);
                Route::get('/view/{id}', [ChargeViewController::class, 'index']);
                Route::get('/slug/{slug}', [ChargeSlugController::class, 'index']);
                Route::delete('/delete/{id}', [ChargeDeleteController::class, 'index']);
            });
            
            Route::prefix('taxes')->group(function () {
                Route::get('/excel', [TaxExportController::class, 'index']);
                Route::get('/paginate', [TaxPaginateController::class, 'index']);
                Route::post('/create', [TaxCreateController::class, 'index']);
                Route::post('/update/{id}', [TaxUpdateController::class, 'index']);
                Route::get('/status/{id}', [TaxToggleStatusController::class, 'index']);
                Route::get('/view/{id}', [TaxViewController::class, 'index']);
                Route::get('/slug/{slug}', [TaxSlugController::class, 'index']);
                Route::delete('/delete/{id}', [TaxDeleteController::class, 'index']);
            });
            
            Route::prefix('testimonials')->group(function () {
                Route::get('/excel', [TestimonialExportController::class, 'index']);
                Route::get('/paginate', [TestimonialPaginateController::class, 'index']);
                Route::post('/create', [TestimonialCreateController::class, 'index']);
                Route::post('/update/{id}', [TestimonialUpdateController::class, 'index']);
                Route::get('/status/{id}', [TestimonialToggleStatusController::class, 'index']);
                Route::get('/view/{id}', [TestimonialViewController::class, 'index']);
                Route::delete('/delete/{id}', [TestimonialDeleteController::class, 'index']);
            });

            Route::prefix('texteditor-images')->group(function () {
                Route::post('/create', [TexteditorImageCreateController::class, 'index']);
            });
            
            Route::prefix('blogs')->group(function () {
                Route::get('/excel', [BlogExportController::class, 'index']);
                Route::get('/paginate', [BlogPaginateController::class, 'index']);
                Route::post('/create', [BlogCreateController::class, 'index']);
                Route::post('/update/{id}', [BlogUpdateController::class, 'index']);
                Route::get('/status/{id}', [BlogToggleStatusController::class, 'index']);
                Route::get('/view/{id}', [BlogViewController::class, 'index']);
                Route::get('/slug/{slug}', [BlogSlugController::class, 'index']);
                Route::delete('/delete/{id}', [BlogDeleteController::class, 'index']);
            });
            
            Route::prefix('categories')->group(function () {
                Route::get('/excel', [CategoryExportController::class, 'index']);
                Route::get('/paginate', [CategoryPaginateController::class, 'index']);
                Route::post('/create', [CategoryCreateController::class, 'index']);
                Route::post('/update/{id}', [CategoryUpdateController::class, 'index']);
                Route::get('/status/{id}', [CategoryToggleStatusController::class, 'index']);
                Route::get('/view/{id}', [CategoryViewController::class, 'index']);
                Route::get('/slug/{slug}', [CategorySlugController::class, 'index']);
                Route::delete('/delete/{id}', [CategoryDeleteController::class, 'index']);
            });
            
            Route::prefix('sub-categories')->group(function () {
                Route::get('/excel', [SubCategoryExportController::class, 'index']);
                Route::get('/paginate', [SubCategoryPaginateController::class, 'index']);
                Route::post('/create', [SubCategoryCreateController::class, 'index']);
                Route::post('/update/{id}', [SubCategoryUpdateController::class, 'index']);
                Route::get('/status/{id}', [SubCategoryToggleStatusController::class, 'index']);
                Route::get('/view/{id}', [SubCategoryViewController::class, 'index']);
                Route::get('/slug/{slug}', [SubCategorySlugController::class, 'index']);
                Route::delete('/delete/{id}', [SubCategoryDeleteController::class, 'index']);
            });
            
            Route::prefix('products')->group(function () {
                Route::get('/excel', [ProductExportController::class, 'index']);
                Route::get('/paginate', [ProductPaginateController::class, 'index']);
                Route::post('/create', [ProductCreateController::class, 'index']);
                Route::post('/update/{id}', [ProductUpdateController::class, 'index']);
                Route::get('/status/{id}', [ProductToggleStatusController::class, 'index']);
                Route::get('/view/{id}', [ProductViewController::class, 'index']);
                Route::get('/slug/{slug}', [ProductSlugController::class, 'index']);
                Route::delete('/delete/{id}', [ProductDeleteController::class, 'index']);
            });
            
            Route::prefix('legal-contents')->group(function () {
                Route::get('/excel', [LegalContentExportController::class, 'index']);
                Route::get('/paginate', [LegalContentPaginateController::class, 'index']);
                Route::post('/create', [LegalContentCreateController::class, 'index']);
                Route::post('/update/{id}', [LegalContentUpdateController::class, 'index']);
                Route::get('/status/{id}', [LegalContentToggleStatusController::class, 'index']);
                Route::get('/view/{id}', [LegalContentViewController::class, 'index']);
                Route::get('/slug/{slug}', [LegalContentSlugController::class, 'index']);
                Route::delete('/delete/{id}', [LegalContentDeleteController::class, 'index']);
            });
            
            Route::prefix('features')->group(function () {
                Route::get('/excel', [FeatureExportController::class, 'index']);
                Route::get('/paginate', [FeaturePaginateController::class, 'index']);
                Route::post('/create', [FeatureCreateController::class, 'index']);
                Route::post('/update/{id}', [FeatureUpdateController::class, 'index']);
                Route::get('/status/{id}', [FeatureToggleStatusController::class, 'index']);
                Route::get('/view/{id}', [FeatureViewController::class, 'index']);
                Route::delete('/delete/{id}', [FeatureDeleteController::class, 'index']);
            });
            
            Route::prefix('banners')->group(function () {
                Route::get('/excel', [BannerExportController::class, 'index']);
                Route::get('/paginate', [BannerPaginateController::class, 'index']);
                Route::post('/create', [BannerCreateController::class, 'index']);
                Route::post('/update/{id}', [BannerUpdateController::class, 'index']);
                Route::get('/status/{id}', [BannerToggleStatusController::class, 'index']);
                Route::get('/view/{id}', [BannerViewController::class, 'index']);
                Route::delete('/delete/{id}', [BannerDeleteController::class, 'index']);
            });

            Route::prefix('delivery-slots')->group(function () {
                Route::get('/excel', [DeliverySlotExportController::class, 'index']);
                Route::get('/paginate', [DeliverySlotPaginateController::class, 'index']);
                Route::post('/create', [DeliverySlotCreateController::class, 'index']);
                Route::post('/update/{id}', [DeliverySlotUpdateController::class, 'index']);
                Route::get('/status/{id}', [DeliverySlotToggleStatusController::class, 'index']);
                Route::get('/view/{id}', [DeliverySlotViewController::class, 'index']);
                Route::delete('/delete/{id}', [DeliverySlotDeleteController::class, 'index']);
            });
            
            Route::prefix('billing-informations')->group(function () {
                Route::get('/excel', [BillingInformationExportController::class, 'index']);
                Route::get('/paginate', [BillingInformationPaginateController::class, 'index']);
                Route::post('/create', [BillingInformationCreateController::class, 'index']);
                Route::post('/update/{id}', [BillingInformationUpdateController::class, 'index']);
                Route::get('/view/{id}', [BillingInformationViewController::class, 'index']);
                Route::delete('/delete/{id}', [BillingInformationDeleteController::class, 'index']);
            });

            Route::prefix('roles')->group(function () {
                Route::get('/paginate', [RolePaginateController::class, 'index']);
            });

            Route::prefix('about-sections')->group(function () {
                Route::get('/excel', [AboutSectionExportController::class, 'index']);
                Route::get('/paginate', [AboutSectionPaginateController::class, 'index']);
                Route::post('/create', [AboutSectionCreateController::class, 'index']);
                Route::post('/update/{id}', [AboutSectionUpdateController::class, 'index']);
                Route::get('/status/{id}', [AboutSectionToggleStatusController::class, 'index']);
                Route::get('/view/{id}', [AboutSectionViewController::class, 'index']);
                Route::delete('/delete/{id}', [AboutSectionDeleteController::class, 'index']);
            });

            Route::prefix('payment-options')->group(function () {
                Route::get('/excel', [PaymentOptionExportController::class, 'index']);
                Route::get('/paginate', [PaymentOptionPaginateController::class, 'index']);
                Route::get('/status/{id}', [PaymentOptionToggleStatusController::class, 'index']);
                Route::get('/view/{id}', [PaymentOptionViewController::class, 'index']);
                Route::get('/slug/{slug}', [PaymentOptionSlugController::class, 'index']);
            });
            
            Route::prefix('contact-form-enquiries')->group(function () {
                Route::get('/excel', [ContactFormEnquiryExportController::class, 'index']);
                Route::get('/paginate', [ContactFormEnquiryPaginateController::class, 'index']);
                Route::get('/view/{id}', [ContactFormEnquiryViewController::class, 'index']);
                Route::delete('/delete/{id}', [ContactFormEnquiryDeleteController::class, 'index']);
            });
        });
    });

    Route::prefix('contact-form-enquiries')->group(function () {
        Route::post('/create', [ContactFormEnquiryCreateController::class, 'index']);
    });
});
