<?php namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel {

	/**
	 * The application's global HTTP middleware stack.
	 *
	 * @var array
	 */
	protected $middleware = [
		'Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode',
		'Illuminate\Cookie\Middleware\EncryptCookies',
		'Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse',

        //'Illuminate\Foundation\Http\Middleware\VerifyCsrfToken'
	];

	/**
	 * The application's route middleware.
	 *
	 * @var array
	 */
	protected $routeMiddleware = [
		'auth' => 'App\Http\Middleware\Authenticate',
		'auth.basic' => 'Illuminate\Auth\Middleware\AuthenticateWithBasicAuth',
		'guest' => 'App\Http\Middleware\RedirectIfAuthenticated',
        'general_auth' => 'App\Http\Middleware\AuthMiddleware',
        'admin' => 'App\Http\Middleware\AdminMiddleware',
        'student' => 'App\Http\Middleware\StudentMiddleware',
        'single_test' => 'App\Http\Middleware\SingleTest',
        'have_attempts' => 'App\Http\Middleware\StudentAccessForTest',
        'test_is_available' => 'App\Http\Middleware\GeneralAccessForTest',
        'access_for_library' => 'App\Http\Middleware\AccessForLibrary',
        'can' => 'Illuminate\Auth\Middleware\Authorize',
        'bindings' => '\Illuminate\Routing\Middleware\SubstituteBindings',
        'OrderBookLibrary' => 'App\Http\Middleware\OrderBookLibrary',
        'studentLibrary' => 'App\Http\Middleware\StudentLibraryMiddleware',


	];

    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
        'api' => [
            'throttle:60,1',
            'bindings',
        ],
    ];

}
