<?php

use App\Http\Controllers\Api\CurrencyController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\PackageController;
use App\Http\Controllers\Api\LeadController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\SupplementController;
use App\Http\Controllers\Api\PartnerController;
use App\Http\Controllers\Api\TestimonialController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\FeatureController;
use App\Http\Controllers\Api\FaqController;
use App\Http\Controllers\Api\SectionController;
use App\Http\Controllers\Api\SiteSettingsController;
use Illuminate\Support\Facades\Route;

Route::get('/features', [FeatureController::class, 'index']);
Route::get('/faqs', [FaqController::class, 'index']);
Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/{slug}', [PostController::class, 'show']);
Route::get('/currencies', [CurrencyController::class, 'index']);
Route::get('/menus', [MenuController::class, 'index']);
Route::get('/packages', [PackageController::class, 'index']);
Route::get('/packages/{slug}', [PackageController::class, 'show']);
Route::get('/supplements', [SupplementController::class, 'index']);
Route::get('/pages', [PageController::class, 'index']);
Route::get('/pages/{slug}', [PageController::class, 'show']);
Route::get('/partners', [PartnerController::class, 'index']);
Route::get('/testimonials', [TestimonialController::class, 'index']);
Route::get('/sections', [SectionController::class, 'index']);
Route::get('/site-settings', [SiteSettingsController::class, 'index']);
Route::post('/leads', [LeadController::class, 'store']);
