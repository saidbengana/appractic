<?php

use Illuminate\Support\Facades\Route;
use Inovector\Appractic\Http\Controllers\AccountEntitiesController;
use Inovector\Appractic\Http\Controllers\AccountsController;
use Inovector\Appractic\Http\Controllers\AddAccountController;
use Inovector\Appractic\Http\Controllers\AuthenticatedController;
use Inovector\Appractic\Http\Controllers\CalendarController;
use Inovector\Appractic\Http\Controllers\CallbackSocialProviderController;
use Inovector\Appractic\Http\Controllers\CreateMastodonAppController;
use Inovector\Appractic\Http\Controllers\DashboardController;
use Inovector\Appractic\Http\Controllers\UpdateAuthUserController;
use Inovector\Appractic\Http\Controllers\UpdateAuthUserPasswordController;
use Inovector\Appractic\Http\Controllers\ProfileController;
use Inovector\Appractic\Http\Controllers\ReportsController;
use Inovector\Appractic\Http\Controllers\DeletePostsController;
use Inovector\Appractic\Http\Controllers\DuplicatePostController;
use Inovector\Appractic\Http\Controllers\MediaController;
use Inovector\Appractic\Http\Controllers\MediaDownloadExternalController;
use Inovector\Appractic\Http\Controllers\MediaFetchGifsController;
use Inovector\Appractic\Http\Controllers\MediaFetchStockController;
use Inovector\Appractic\Http\Controllers\MediaFetchUploadsController;
use Inovector\Appractic\Http\Controllers\MediaUploadFileController;
use Inovector\Appractic\Http\Controllers\PostsController;
use Inovector\Appractic\Http\Controllers\SchedulePostController;
use Inovector\Appractic\Http\Controllers\ServicesController;
use Inovector\Appractic\Http\Controllers\SettingsController;
use Inovector\Appractic\Http\Controllers\TagsController;
use Inovector\Appractic\Http\Middleware\Auth as AppracticAuthMiddleware;
use Inovector\Appractic\Http\Middleware\HandleInertiaRequests;

Route::middleware([
    'web',
    AppracticAuthMiddleware::class,
    HandleInertiaRequests::class
])->prefix('appractic')
    ->name('appractic.')
    ->group(function () {
        Route::get('/', DashboardController::class)->name('dashboard');
        Route::get('reports', ReportsController::class)->name('reports');

        Route::prefix('accounts')->name('accounts.')->group(function () {
            Route::get('/', [AccountsController::class, 'index'])->name('index');
            Route::post('add/{provider}', AddAccountController::class)->name('add');
            Route::put('update/{account}', [AccountsController::class, 'update'])->name('update');
            Route::delete('{account}', [AccountsController::class, 'delete'])->name('delete');

            Route::prefix('entities')->name('entities.')->group(function () {
                Route::get('{provider}', [AccountEntitiesController::class, 'index'])->name('index');
                Route::post('{provider}', [AccountEntitiesController::class, 'store'])->name('store');
            });
        });

        Route::prefix('posts')->name('posts.')->group(function () {
            Route::get('/', [PostsController::class, 'index'])->name('index');
            Route::get('create/{schedule_at?}', [PostsController::class, 'create'])
                ->name('create')
                ->where('schedule_at', '^(\d{4})-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]) (0\d|1\d|2[0-3]):([0-5]\d)$');
            Route::post('store', [PostsController::class, 'store'])->name('store');
            Route::get('{post}', [PostsController::class, 'edit'])->name('edit');
            Route::put('{post}', [PostsController::class, 'update'])->name('update');
            Route::delete('{post}', [PostsController::class, 'destroy'])->name('delete');

            Route::post('schedule/{post}', SchedulePostController::class)->name('schedule');
            Route::post('duplicate/{post}', DuplicatePostController::class)->name('duplicate');
            Route::delete('/', DeletePostsController::class)->name('multipleDelete');
        });

        Route::get('calendar/{date?}/{type?}', [CalendarController::class, 'index'])
            ->name('calendar')
            ->where('date', '^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01])$')
            ->where('type', '^(?:month|week)$');

        Route::prefix('media')->name('media.')->group(function () {
            Route::get('/', [MediaController::class, 'index'])->name('index');
            Route::delete('/', [MediaController::class, 'destroy'])->name('delete');
            Route::get('fetch/uploaded', MediaFetchUploadsController::class)->name('fetchUploads');
            Route::get('fetch/stock', MediaFetchStockController::class)->name('fetchStock');
            Route::get('fetch/gifs', MediaFetchGifsController::class)->name('fetchGifs');
            Route::post('download', MediaDownloadExternalController::class)->name('download');
            Route::post('upload', MediaUploadFileController::class)->name('upload');
        });

        Route::prefix('tags')->name('tags.')->group(function () {
            Route::post('/', [TagsController::class, 'store'])->name('store');
            Route::put('{tag}', [TagsController::class, 'update'])->name('update');
            Route::delete('{tag}', [TagsController::class, 'destroy'])->name('delete');
        });

        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('/', [SettingsController::class, 'index'])->name('index');
            Route::put('/', [SettingsController::class, 'update'])->name('update');
        });

        Route::prefix('services')->name('services.')->group(function () {
            Route::get('/', [ServicesController::class, 'index'])->name('index');
            Route::put('{service}', [ServicesController::class, 'update'])->name('update');

            Route::post('create-mastodon-app', CreateMastodonAppController::class)->name('createMastodonApp');
        });

        Route::prefix('profile')->name('profile.')->group(function () {
            Route::get('/', [ProfileController::class, 'index'])->name('index');
            Route::put('user', UpdateAuthUserController::class)->name('updateUser');
            Route::put('password', UpdateAuthUserPasswordController::class)->name('updatePassword');
        });

        Route::post('logout', [AuthenticatedController::class, 'destroy'])
            ->name('logout');

        Route::get('callback/{provider}', CallbackSocialProviderController::class)->name('callbackSocialProvider');
    });
