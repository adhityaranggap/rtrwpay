<?php

use Illuminate\Support\Facades\Route;

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
/* Temporary */
Route::get('/', function () {
    return view('login');
})->name('login');

Route::get('/login', function () {
    return view('login');
})->name('login');


Route::post('/login-post', 'Web\LoginController@auth')->name('login-post');


Route::get('/register', function () {
    return view('register');
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', 'Web\DashboardController@index')->name('dashboard-index')->middleware('AdminOnly');
    Route::get('/dashboard/chart', 'Web\DashboardController@chart')->name('dashboard-chart')->middleware('AdminOnly');
    Route::get('/logout', 'Web\LoginController@logout')->name('logout');

    Route::prefix('profile')->group(function () {
        Route::get('/index', 'Web\UserController@index')->name('profile-index');
        Route::post('/update/{id}', 'Web\UserController@update')->name('profile-update');
 
    });
    // Route::middleware('AdminBillingOnly')->group(function () {

    Route::prefix('transactions')->group(function () {

        Route::prefix('all-transaction')->group(function () {//==
            Route::get('/', 'Web\AllTransactionController@index')->name('all-transaction-index');//done
            Route::get('/datatables', 'Web\AllTransactionController@datatables')->name('all-transaction-datatables');//done
            Route::get('/create', 'Web\AllTransactionController@create')->name('all-transaction-create');//done
            Route::get('/sync', 'Web\AllTransactionController@sync')->name('all-transaction-sync');//done
            Route::post('/store', 'Web\AllTransactionController@store')->name('all-transaction-store');//done
            Route::get('/edit/{id}', 'Web\AllTransactionController@edit')->name('all-transaction-edit');//done
            Route::get('/detail/{id}', 'Web\AllTransactionController@detail')->name('all-transaction-detail');//done
            Route::post('/update/{id}', 'Web\AllTransactionController@update')->name('all-transaction-update');//done
            Route::get('/destroy/{id}', 'Web\AllTransactionController@destroy')->name('all-transaction-destroy');
            Route::delete('/destroy/{id}', 'Web\AllTransactionController@destroy')->name('all-transaction-destroy');
        });
        Route::prefix('unpaid')->group(function () {
            Route::get('/', 'Web\UnpaidController@index')->name('unpaid-index');
            Route::get('/datatables', 'Web\UnpaidController@datatables')->name('unpaid-datatables');
            Route::get('/create', 'Web\UnpaidController@create')->name('unpaid-create');
            Route::post('/store', 'Web\UnpaidController@store')->name('unpaid-store');
            Route::get('/edit/{id}', 'Web\UnpaidController@edit')->name('unpaid-edit');
            Route::post('/update/{id}', 'Web\UnpaidController@update')->name('unpaid-update');
            Route::delete('/destroy/{id}', 'Web\UnpaidController@destroy')->name('unpaid-destroy');              
        });
    });
       

        // Route::prefix('payments')->group(function () {//==
        //     Route::get('/', 'Web\PaymentsController@index')->name('payments-index');
        //     Route::get('/datatables', 'Web\PaymentsController@datatables')->name('payments-datatables');
        //     Route::get('/create', 'Web\PaymentsController@create')->name('payments-create');
        //     Route::post('/store', 'Web\PaymentsController@store')->name('payments-store');
        //     Route::get('/edit/{id}', 'Web\PaymentsController@edit')->name('payments-edit');
        //     Route::post('/update/{id}', 'Web\PaymentsController@update')->name('payments-update');
        //     Route::delete('/destroy/{id}', 'Web\PaymentsController@destroy')->name('payments-destroy'); //only admin
        // });
    
    });

    Route::prefix('users')->group(function () {

        Route::prefix('warga')->group(function () {
            Route::get('/', 'Web\WargaController@index')->name('warga-index');//done
            Route::get('/router', 'Web\WargaController@router')->name('warga-router');//done
            Route::get('/datatables', 'Web\WargaController@datatables')->name('warga-datatables');//done
            Route::get('/create', 'Web\WargaController@create')->name('warga-create');//done
            Route::get('/import', 'Web\WargaController@import')->name('warga-import');//done
            Route::post('/store', 'Web\WargaController@store')->name('warga-store');//done
            Route::post('/store/import', 'Web\WargaController@storeImport')->name('warga-store-import');//done
            Route::get('/load', 'Web\WargaController@loadData')->name('warga-load');//done
            Route::get('/edit/{id}', 'Web\WargaController@edit')->name('warga-edit');//done
            Route::post('/update/{id}', 'Web\WargaController@update')->name('warga-update');//done
            Route::delete('/destroy/{id}', 'Web\WargaController@destroy')->name('warga-destroy'); //done
        });

        Route::prefix('billing')->group(function () {
            Route::get('/', 'Web\BillingController@index')->name('billing-index');//done
            Route::get('/datatables', 'Web\BillingController@datatables')->name('billing-datatables');//done
            Route::get('/create', 'Web\BillingController@create')->name('billing-create');//done
            Route::post('/store', 'Web\BillingController@store')->name('billing-store');//done
            Route::get('/edit/{id}', 'Web\BillingController@edit')->name('billing-edit');//done
            Route::post('/update/{id}', 'Web\BillingController@update')->name('billing-update');//done
            Route::delete('/destroy/{id}', 'Web\BillingController@destroy')->name('billing-destroy'); //done
        });

        Route::prefix('active-user')->group(function () {
            Route::get('/', 'Web\ActiveUserController@index')->name('active-user-index');
            Route::get('/datatables', 'Web\ActiveUserController@datatables')->name('active-user-datatables');
            Route::get('/detail/{id}', 'Web\ActiveUserController@detail')->name('active-user-detail');
            Route::delete('/destroy/{id}', 'Web\ActiveUserController@destroy')->name('active-user-destroy'); 
        });

    });

    Route::prefix('subscription')->group(function () {

        Route::prefix('warga-subscription-index')->group(function () {
            Route::get('/', 'Web\WargaSubscriptionController@index')->name('warga-subscription-index');//done
            Route::get('/datatables', 'Web\WargaSubscriptionController@datatables')->name('warga-subscription-datatables');//done
            Route::get('/create', 'Web\WargaSubscriptionController@create')->name('warga-subscription-create');//done
            Route::get('/load', 'Web\WargaSubscriptionController@loadData')->name('warga-subscription-load');//done

            Route::post('/store', 'Web\WargaSubscriptionController@store')->name('warga-subscription-store');//done
            Route::get('/edit/{id}', 'Web\WargaSubscriptionController@edit')->name('warga-subscription-edit');//done
            
            Route::post('/update/{id}', 'Web\WargaSubscriptionController@update')->name('warga-subscription-update');//done
            Route::delete('/destroy/{id}', 'Web\WargaSubscriptionController@destroy')->name('warga-subscription-destroy');  //only admin
        });
        Route::prefix('list-subscriptions')->group(function () {
            Route::get('/', 'Web\ListSubscriptionController@index')->name('list-subscription-index');//done
            Route::get('/datatables', 'Web\ListSubscriptionController@datatables')->name('list-subscription-datatables');//done
            Route::get('/create', 'Web\ListSubscriptionController@create')->name('list-subscription-create');//done
            Route::post('/store', 'Web\ListSubscriptionController@store')->name('list-subscription-store');//done
            Route::get('/edit/{id}', 'Web\ListSubscriptionController@edit')->name('list-subscription-edit');//done
            Route::post('/update/{id}', 'Web\ListSubscriptionController@update')->name('list-subscription-update');//done
            Route::delete('/destroy/{id}', 'Web\ListSubscriptionController@destroy')->name('list-subscription-destroy');  //only admin
        });

        Route::prefix('package-track')->group(function () {
            Route::get('/', 'Web\PackageTrackController@index')->name('package-track-index');
            Route::get('/datatables', 'Web\PackageTrackController@datatables')->name('package-track-datatables');
            Route::get('/edit/{id}', 'Web\PackageTrackController@edit')->name('package-track-edit');
            Route::post('/update/{id}', 'Web\PackageTrackController@update')->name('package-track-update');
        });

    });

    Route::prefix('ticket')->group(function () {

        Route::prefix('all-ticket')->group(function () {
            Route::get('/', 'Web\AllTicketController@index')->name('all-ticket-index');
            Route::get('/datatables', 'Web\AllTicketController@datatables')->name('all-ticket-datatables');       
            Route::get('/create', 'Web\AllTicketController@create')->name('all-ticket-create');
            Route::get('/edit/{id}', 'Web\AllTicketController@edit')->name('all-ticket-edit');
            Route::post('/update/{id}', 'Web\AllTicketController@update')->name('all-ticket-update');      
            Route::post('/store', 'Web\AllTicketController@store')->name('all-ticket-store');      
            Route::delete('/destroy/{id}', 'Web\AllTicketController@destroy')->name('all-ticket-destroy');  //only admin
        });

      
        Route::prefix('unsolved-ticket')->group(function () {
            Route::get('/', 'Web\UnsolvedTicketController@index')->name('unsolved-ticket-index');
            Route::get('/datatables', 'Web\UnsolvedTicketController@datatables')->name('unsolved-ticket-datatables');        
            Route::get('/create', 'Web\UnsolvedTicketController@create')->name('unsolved-ticket-create');
            Route::post('/store', 'Web\UnsolvedTicketController@store')->name('unsolved-ticket-store');      
        });

    // });

    Route::prefix('router')->group(function () {
        Route::prefix('all-router')->group(function () {
            Route::get('/', 'Web\RouterController@index')->name('all-router-index');
            Route::get('/datatables', 'Web\RouterController@datatables')->name('all-router-datatables');
            Route::get('/create', 'Web\RouterController@create')->name('all-router-create');
            Route::get('/detail/{id}', 'Web\RouterController@detail')->name('all-router-detail');
            Route::get('/edit/{id}', 'Web\RouterController@edit')->name('all-router-edit');
            Route::post('/update/{id}', 'Web\RouterController@update')->name('all-router-update');
            Route::post('/store', 'Web\RouterController@store')->name('all-router-store');    
            Route::delete('/destroy/{id}', 'Web\RouterController@destroy')->name('all-router-destroy'); 
        });
        
       
    });
});

Route::prefix('review')->group(function () {
    Route::get('/', 'Web\AllReviewController@index')->name('review-index');
    Route::get('/datatables', 'Web\AllReviewController@datatables')->name('review-datatables');
    Route::get('/create', 'Web\AllReviewController@create')->name('review-create');
    Route::post('/store', 'Web\AllReviewController@store')->name('review-store');    
    Route::delete('/destroy/{id}', 'Web\AllReviewController@destroy')->name('review-destroy');  //only admin
});

//Akhir Routing







Route::prefix('paket')->group(function () {
    Route::get('/', 'Base\PaketController@index')->name('paket-index');
    //Route::post('/status-changes', 'Base\PaketController@StatusChanges')->name('setting-group-status');
    Route::get('/datatables', 'Base\PaketController@datatables');
    Route::get('/create', 'Base\PaketController@formCreate')->name('paket-create');
    Route::post('/store', 'Base\PaketController@store')->name('paket-store');
    Route::get('/edit/{id}', 'Base\PaketController@formEdit')->name('paket-edit');
    Route::post('/update/{id}', 'Base\PaketController@update')->name('paket-update');
});

Route::prefix('tiket')->group(function () {
    Route::get('/', 'Base\TiketController@index')->name('tiket-index');
    //Route::post('/status-changes', 'Base\PaketController@StatusChanges')->name('setting-group-status');
    //Route::get('/datatables', 'Base\PaketController@datatables');
    //Route::get('/create', 'Base\PaketController@formCreate')->name('paket-create');
    //Route::post('/store', 'Base\PaketController@store')->name('paket-store');
    //Route::get('/edit/{id}', 'Base\PaketController@formEdit')->name('paket-edit');
    //Route::post('/update/{id}', 'Base\PaketController@update')->name('paket-update');
});


