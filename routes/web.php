<?php

use App\Http\Controllers\DummyController;
use App\Http\Controllers\MikrotikController;
use App\Http\Controllers\OvpnController;
use App\Models\Customer;
use App\Models\Ticket;
use Illuminate\Support\Facades\Route;

Route::domain('{subdomain}.ispkenya.xyz')->middleware(['tenant.db', 'subdomain.access'])->group(function () {

    Route::get('/', function () {
        return view('admins.auth.login');
    });

    Route::prefix('admin/auth')->group(function () {
        Route::get('/login', function () {
            return view('admins.auth.login');
        })->name('admin.login');
    });

    Route::get('/admin/auth/register', function () {
        return view('admins.auth.register');
    })->name('admin.register');

    Route::get('/router/check-status', [MikrotikController::class, 'checkStatus']);
    Route::get('/test', function () {
        return view('admins.pages.test');
    });
    Route::prefix('admin')->middleware('admin:admin')->group(function () {
        // Route::get('/login', [AdminLoginController::class, 'loginForm'])->name('admin.login');
        // Route::post('/login', [AdminLoginController::class, 'store'])->name('admin.post.login');
    });

    Route::get('/admin/auth/recover-password', function () {
        return view('admins.auth.recover-password');
    })->name('admin.password-recovery');

    Route::get('reset-password/{token}', function ($token) {
        return view('admins.auth.reset-password', compact('token'));
    })->name('password.reset');

    Route::get('admin/auth/reset-password/{token}', function () {
        return view('admins.auth.reset-password');
    })->name('admin.password.reset');

    Route::post('/admin-logout', function () {
        auth()->guard('admin')->logout();
        return redirect()->route('admin.login');
    })->name('admin.logout');

    Route::get('/account/locked', function () {
        return view('admins.pages.settings.account-locked');
    })->name('account.locked');

    Route::prefix('admin')->middleware(['admin', 'account_status'])->group(function () {
        Route::get('/', function () {
            return redirect()->route('admin.dashboard');
        });

        // Dashboard route
        Route::get('/dashboard', function () {
            return view('admins.pages.dashboard');
        })->name('admin.dashboard');

        // profile route
        // Route::get('/profile', [UserProfileController::class, 'show'])->name('admin.profile.show');
        Route::get('/profile', [DummyController::class, 'adminProfile'])->name('admin.profile.show');

        Route::get('/check-guard', function () {
            dd(auth()->guard());
        });

        // Routes related to isp
        Route::get('/customers/add/isp', function () {
            return view('admins.pages.customer.add-isp.addIsp');
        })->name('customers.add');
        Route::get('/customers/add-bulk', function () {
            return view('admins.pages.customer.add-bulk-isp/addBulk');
        })->name('customers.bulk');
        Route::get('/customers/all-static', function () {
            return view('admins.pages.customer.all-static.allStatic');
        })->name('customers.static');
        Route::get('/customers/{id}/view', function ($id) {
            return view('admins.pages.customer.view.customer', ['customerId' => $id]);
        })->name('customer.view.one');

        Route::get('/customers/view-all', function () {
            $customers = Customer::count();
            $staticUsersCount = Customer::whereHas('staticUser')->count();
            $pppoeUsersCount = Customer::whereHas('pppoeUser')->count();

            return view('admins.pages.customer.all-customers.viewAllCustomers', compact('customers', 'staticUsersCount', 'pppoeUsersCount'));
        })->name('customers.view-all-customers');

        // Routes related to services
        Route::get('/services/add', function () {
            return view('admins.pages.services.add.addService');
        })->name('services.add');
        Route::get('/services/all-services', function () {
            return view('admins.pages.services.view-services.viewServices');
        })->name('services.all');
        Route::get('/services/active-services', function () {
            return view('admins.pages.services.active-services.activeServices');
        })->name('services.active');
        Route::get('/services/services-logs', function () {
            return view('admins.pages.services.service-logs.serviceLogs');
        })->name('services.logs');

        //  Routes related to Mikrotiks
        Route::get('/mikrotiks/add', function () {
            return view('admins.pages.mikrotiks.add.addMikrotik');
        })->name('mikrotiks.add');
        Route::get('/mikrotiks/all', function () {
            return view('admins.pages.mikrotiks.view-mikrotiks.viewMikrotiks');
        })->name('mikrotiks.all');

        // Routes related to Hotspot
        Route::get('/hotspot/overview', function () {
            return view('admins.pages.hotspot.overview.hspOverview');
        })->name('hotspot.overview');
        Route::get('/hotspot/add', function () {
            return view('admins.pages.hotspot.add.addVouchers');
        })->name('hotspot.add');
        Route::get('/hotspot/epay-packages-&-vouchers', function () {
            return view('admins.pages.hotspot.view-epay.packages_n_vouchers');
        })->name('hotspot.epay');
        Route::get('/hotspot/cash-vouchers', function () {
            return view('admins.pages.hotspot.view-vouchers.cashVouchers');
        })->name('hotspot.cash');
        Route::get('/hotspot/recurring-vouchers', function () {
            return view('admins.pages.hotspot.view-vouchers.recurringVouchers');
        })->name('hotspot.recurring');
        Route::get('/hotspot/grouped-vouchers', function () {
            return view('admins.pages.hotspot.grouped-vouchers.groupedVouchers');
        })->name('hotspot.grouped');

        // Routes related to SMS
        Route::get('/sms/new-sms', function () {
            return view('admins.pages.sms.compose-new.composeSms');
        })->name('sms.new');
        Route::get('/sms/sent-sms', function () {
            return view('admins.pages.sms.sent-sms.viewSms');
        })->name('sms.sent');
        Route::get('/sms/expiry-sms', function () {
            return view('admins.pages.sms.expiry-sms.expirySms');
        })->name('sms.expiry');
        Route::get('/sms/sms-templates', function () {
            return view('admins.pages.sms.sms-templates.smsTemplates');
        })->name('sms.templates');

        // Routes related to Payments
        Route::get('/payments/all-transactions', function () {
            return view('admins.pages.payments.transactions.transactions');
        })->name('payments.all');
        Route::get('/payments/cash-purchase', function () {
            return view('admins.pages.payments.cash-purchase.cashPurchase');
        })->name('payments.cash');
        Route::get('/payments/hotspot-transactions', function () {
            return view('admins.pages.payments.hotspot-transactions.hotspotTransactions');
        })->name('payments.hotspot');
        Route::get('/payments/wallet-transactions', function () {
            return view('admins.pages.payments.wallet.walletTransactions');
        })->name('payments.wallet');

        // Routes related to Reports
        Route::prefix('reports')->group(function () {
            Route::get('/customers', function () {
                return view('admins.pages.reports.customers.customer-reports');
            })->name('reports.customers');
            Route::get('/mikrotiks', function () {
                return view('admins.pages.reports.mikrotiks.mikrotik-reports');
            })->name('reports.mikrotiks');
            Route::get('/locations', function () {
                return view('admins.pages.reports.locations.location-reports');
            })->name('reports.locations');
        });

        // Routes related to Expenses
        Route::get('/expenses/expense-types', function () {
            return view('admins.pages.expenses.expense-types');
        })->name('expenses.types');
        Route::get('/expenses/view-expenses', function () {
            return view('admins.pages.expenses.view-expenses');
        })->name('expenses.view');

        // Routes related to Invoicing
        // Route::get('/invoicing/invoices', Invoice::class)->name('invoices');

        Route::get('/invoicing/invoices', function () {
            return view('admins.pages.invoicing.invoices.invoices');
        })->name('admin.invoicing.invoices');

        Route::get('/invoice/{id?}', function () {
            return view('admins.pages.invoicing.invoices.edit-invoice');
        })->name('invoice.edit');

        Route::get('/invoice/view/{id}', function ($id) {
            return view('admins.pages.invoicing.invoices.view-invoice', compact('id'));
        })->name('invoice.view');
        // Route::get('/invoce/{id?}', EditInvoice::class)->name('invoice.edit');


        Route::get('/expenses/view-expenses', function () {
            return view('admins.pages.expenses.view-expenses');
        })->name('expenses.view');

        // Routes related to Tickets
        Route::get('/tickets', function () {
            return view('admins.pages.tickets.tickets');
        })->name('admin.tickets');


        // Routes related to Settings
        Route::get('/settings/setup-account', function () {
            $data = [
                'sms_configs' => \App\Models\SmsConfig::all(),
                'payment_configs' => \App\Models\PaymentConfig::all(),
            ];
            return view('admins.pages.settings.setup.setupAccount', $data);
        })->name('settings.setup');

        Route::get('/settings/account', function () {
            return view('admins.pages.settings.account');
        })->name('admin.settings.account');

        // Routes related to Downloading Files in the web app
        Route::get('/download/{file}', [OvpnController::class, 'downloadFile'])
            ->name('download.file');
    });



    Route::prefix('client/auth')->group(function () {
        Route::get('/login', action: function () {
            return view('clients.pages.auth.login');
        })->name('client.login');
    });

    Route::post('/client-logout', function () {
        auth()->guard('client')->logout();
        return redirect()->route('client.login');
    })->name('client.logout');


    Route::prefix('client')->name('client.')->middleware('client')->group(function () {

        Route::get('/check-guard', function () {
            dd(auth()->guard());
        });
        // Start of the protected routes
        Route::get('/overview', function () {
            return view('clients.pages.overview.view-summary');
        })->name('overview');
        Route::get('/make-payment', function () {
            return view('clients.pages.billing.make-payment');
        })->name('make-payment');
        Route::get('/transaction-history', function () {
            return view('clients.pages.billing.transaction-history');
        })->name('transaction-history');
        Route::get('/support', function () {
            return view('clients.pages.support.tickets');
        })->name('support');
        Route::get('/profile', function () {
            return view('clients.pages.profile.profile');
        })->name('profile');

        // Route::get('/support', Support::class)->name('support');
        // Route::post('/support/store', [DummyController::class, 'storeClientTicket'])->name('ticket.store');
    });

    Route::get('/client/auth/recover-password', function () {
        return view('clients.pages.auth.password-recovery');
    })->name('client.password-recovery');

    Route::get('client/auth/reset-password/{token}', function () {
        return view('clients.pages.auth.reset-password');
    })->name('client.reset');
});

require_once 'main.php';