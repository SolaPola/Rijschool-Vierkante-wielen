<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array<int, class-string|string>
     */
    protected $middleware = [
        \App\Http\Middleware\TrustHosts::class,
        \App\Http\Middleware\TrustProxies::class,
        \App\Http\Middleware\HandleCors::class,
        \App\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \App\Http\Middleware\StartSession::class,
        \Illuminate\Session\Middleware\AuthenticateSession::class,
        \App\Http\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\VerifyCsrfToken::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\RedirectIfAuthenticated::class,
        \App\Http\Middleware\CheckRole::class,
        \App\Http\Middleware\StudentMiddleware::class,
        \App\Http\Middleware\InstructorMiddleware::class,
        \App\Http\Middleware\AdminMiddleware::class,
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array<string, class-string|string>
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \App\Http\Middleware\EnsurePasswordIsConfirmed::class,
        'signed' => \App\Http\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'role' => \App\Http\Middleware\CheckRole::class,
        'student' => \App\Http\Middleware\StudentMiddleware::class,
        'instructor' => \App\Http\Middleware\InstructorMiddleware::class,
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
    ];
}
