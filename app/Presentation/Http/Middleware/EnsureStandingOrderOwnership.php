<?php

namespace App\Presentation\Http\Middleware;

use App\Domain\Models\StandingOrder;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureStandingOrderOwnership
{


    public function handle(Request $request, Closure $next)
    {
        /** @var StandingOrder $standingOrder */
        $standingOrder = $request->route('standingOrder');

        $belongs = $standingOrder->getBankAccount()->user_id == Auth::id();

        if (!$belongs) {
            return redirect()->route('standing_orders')
                ->with('error', 'Tento příkaz vám nepatří!');

        }

        return $next($request);
    }
}
