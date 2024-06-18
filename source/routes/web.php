<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

use Illuminate\Http\Request;

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

Auth::routes([
    'register' => false,
    'login' => false
]);

Route::get('/login', function () {
    return view('home');
})->name('login');

Route::prefix('/it-portal')->group(function () {
    Route::get('/knowledge-base', function () {
        return view('home');
    });
    Route::get('/office-users', function () {
        return view('home');
    });
    Route::get('/asset-register', function () {
        return view('home');
    });
    Route::get('/user-stations', function () {
        return view('home');
    });
    Route::get('/it-notices', function () {
        return view('home');
    });

    // IT Portal - Dev Support Routes //
    Route::prefix('/dev-support-jobs')->group(function () {
        Route::get('/fss-unlock-client-file', function () {
            return view('home');
        });
        Route::get('/dm-debtsolv-unlock-client-file', function () {
            return view('home');
        });
        Route::get('/iva-debtsolv-unlock-client-file', function () {
            return view('home');
        });
    });
});

Route::prefix('/bw-portal')->group(function () {
    // BW Portal - Dashboard Routes //
    Route::get('/dashboard', function () {
        return view('home');
    });

    // BW Portal - My Training Routes //
    Route::prefix('/my-training')->group(function () {
        Route::get('/completed', function () {
            return view('home');
        });
        Route::get('/session-history', function () {
            return view('home');
        });
        Route::get('/self-study-history', function () {
            return view('home');
        });
        Route::get('/my-audits', function () {
            return view('home');
        });
    });

    // BW Portal - Management Routes //
    Route::prefix('/management')->group(function () {
        Route::get('/users', function () {
            return view('home');
        });
        Route::get('/user-audits', function () {
            return view('home');
        });
        Route::get('/re-assign-tasks', function () {
            return view('home');
        });
        Route::get('/team-holidays', function () {
            return view('home');
        });
        Route::get('/hr-holidays', function () {
            return view('home');
        });
        Route::get('/starter-form', function () {
            return view('home');
        });
    });

    // BW Portal - Training Routes //
    Route::prefix('/training')->group(function () {
        Route::get('/set-up-new-training', function () {
            return view('home');
        });
        Route::get('/training-sessions', function () {
            return view('home');
        });
        Route::get('/issue-self-study', function () {
            return view('home');
        });
    });

    // BW Portal - Account Routes //
    Route::prefix('/account')->group(function () {
        Route::get('/users', function () {
            return view('home');
        });
        Route::get('/users-admin', function () {
            return view('home');
        });
        Route::get('/user-groups', function () {
            return view('home');
        });
        Route::get('/new-user-form', function () {
            return view('home');
        });
        Route::get('/quest-templates', function () {
            return view('home');
        });
    });

    // BW Portal - Reports Routes //
    Route::prefix('/reports')->group(function () {
        Route::get('/session-history', function () {
            return view('home');
        });
        Route::get('/training-history', function () {
            return view('home');
        });
        Route::get('/employee-list', function () {
            return view('home');
        });
        Route::get('/last-access', function () {
            return view('home');
        });
        Route::get('/cpd-hours-report', function () {
            return view('home');
        });
        Route::get('/self-study-outstanding-report', function () {
            return view('home');
        });
        Route::get('/training-and-self-study', function () {
            return view('home');
        });
    });

    // BW Portal - BW Trainings Routes //
    Route::prefix('/bw-trainings')->group(function () {
        Route::get('/set-up-new-training', function () {
            return view('home');
        });
        Route::get('/training-sessions', function () {
            return view('home');
        });
        Route::get('/issue-self-study', function () {
            return view('home');
        });
    });

    // BW Portal - My Account Routes //
    Route::prefix('/my-account')->group(function () {
        Route::get('/personal-information', function () {
            return view('home');
        });
        Route::get('/cv', function () {
            return view('home');
        });
        Route::get('/my-documents', function () {
            return view('home');
        });
        Route::get('/holiday-requests', function () {
            return view('home');
        });
        Route::get('/team-calendar', function () {
            return view('home');
        });
    });

    // BW Portal - Company Docs Routes //
    Route::prefix('/company-docs')->group(function () {
        Route::get('/document-manager', function () {
            return view('home');
        });
        Route::get('/team-document-manager', function () {
            return view('home');
        });
    });
});

Route::get('/logout', function (Request $request) {
    $token = $request->user()->token();
    $token->revoke();

    return response()->noContent(200);

})->middleware(['auth:api']);


Route::fallback(function(){
    return view('home');
});
