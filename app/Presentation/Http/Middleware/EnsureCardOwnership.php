<?php

namespace App\Presentation\Http\Middleware;

use App\Domain\Models\Card;
use App\Domain\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureCardOwnership
{


    public function handle(Request $request, Closure $next)
    {
        /** @var Card $card */
        $card = $request->route('card');

        /** @var User $user */
        $user = Auth::user();

        $belongs = $user
            ->bankAccounts()
            ->whereHas('cards', function ($q) use ($card) {
                $q->where('id', $card->id);
            })
            ->exists();

        if (!$belongs) {
            return redirect()->route('cards')
                ->with('error', 'Tato karta vám nepatří!');

        }

        return $next($request);
    }
}
