<?php

namespace Presentation\Http\Middleware;

use Domain\Models\BankAccount;
use Domain\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureAccountOwnership
{


    public function handle(Request $request, Closure $next)
    {
        /** @var BankAccount $account */
        $account = $request->route('account');

        /** @var User $user */
        $user = Auth::user();

        if (!$user->bankAccounts()->where('id', $account->id)->exists()) {
            return redirect()->route('accounts')
                ->with('error', 'Tento účet vám nepatří!');
        }

        return $next($request);
    }
}
