<?php

namespace App\Presentation\Http\Middleware;

use App\Domain\Models\StandingOrder;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureLoanOwnership
{


    public function handle(Request $request, Closure $next)
    {
        /** @var Loan $loan */
        $loan = $request->route('loan');

        $belongs = $loan->user_id == Auth::id();

        if (!$belongs) {
            return redirect()->route('loans')
                ->with('error', 'Tento úvěr není váš!');

        }

        return $next($request);
    }
}
