<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;
use Illuminate\Support\Facades\Auth;
use Inertia\Middleware;

class Authenticate extends  Middleware
{
    const NAME = 'auth';

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return route('home');
        }
    }

    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            if ($this->redirectTo($request)) {
                return redirect($this->redirectTo($request));
            }
            return response('', 401);
        }
        return parent::handle($request, $next);
    }

    public function share(Request $request)
    {
        return array_merge(parent::share($request), [
            'userInfo' => fn () => auth()->user()
                ->get(['name', 'email', 'avatar'])->first()
        ]);
    }
}
