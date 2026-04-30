<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Facades\Log;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->redirectGuestsTo(fn () => route('admin.login.show'));
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (Throwable $e, $request) {
            Log::info('exception render hook', [
                'class' => get_class($e),
                'path' => $request->path(),
                'is_admin' => $request->is('admin/*'),
            ]);

            if ($e instanceof TokenMismatchException && $request->is('admin/*')) {
                return redirect()->route('admin.login.show')
                    ->with('error', 'Sesija je istekla. Molimo prijavite se ponovo.');
            }
        });
    })->create();
