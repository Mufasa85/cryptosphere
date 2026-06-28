<?php

namespace App\Providers;

use App\Models\LoginHistory;
use App\Models\User;
use App\Services\MobileMoney\LabPayService;
use App\Services\MobileMoney\MockService;
use App\Services\MobileMoney\PaymentGatewayInterface;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PaymentGatewayInterface::class, function () {
            return config('services.labpay.driver') === 'labpay'
                ? new LabPayService()
                : new MockService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(Login::class, function (Login $event) {
            LoginHistory::create([
                'user_id' => $event->user->id,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'success' => true,
            ]);
        });

        Event::listen(Failed::class, function (Failed $event) {
            $user = User::where('email', $event->credentials['email'] ?? '')->first();

            // login_histories.user_id is NOT NULL
            if ($user) {
                LoginHistory::create([
                    'user_id' => $user->id,
                    'ip_address' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                    'success' => false,
                ]);
            }

            // If the user doesn't exist, we can't record the login attempt in login_histories.
            // (This avoids an Integrity constraint violation.)
        });
    }
}
