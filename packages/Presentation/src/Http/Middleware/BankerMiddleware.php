<?php

namespace Presentation\Http\Middleware;

use Domain\Models\BankAccount;
use Domain\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BankerMiddleware
{


    public function handle(Request $request, Closure $next)
    {

        /** @var User $user */
        $user = Auth::user();

        if (!$user->isBanker()) {
            return redirect()->route('homepage')
                ->with('error', 'Do této sekce nemáte přístup!');
        }

        return $next($request);
    }
}
