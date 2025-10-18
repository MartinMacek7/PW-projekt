<?php

namespace App\Presentation\Http\Controllers\Admin;

use App\Domain\Models\Card;
use Illuminate\Http\Request;

class AdminCardController extends AdminController
{


    public function index(Request $request)
    {
        $query = Card::query()->with(['bankAccount.user']);

        if ($request->filled('account')) {
            $query->whereHas('bankAccount', function ($q) use ($request) {
                $q->where('account_number', 'like', '%' . $request->account . '%');
            });
        }

        if ($request->filled('client')) {
            $query->whereHas('bankAccount.user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->client . '%')
                  ->orWhere('surname', 'like', '%' . $request->client . '%');
            });
        }

        if ($request->filled('status')) {
            $isActive = $request->status === 'active';
            $query->where('is_active', $isActive);
        }

        $cards = $query->orderByDesc('created_at')->paginate(15);

        return view('admin.cards.index', compact('cards'));
    }


    public function show(Card $card)
    {
        $card->load('bankAccount.user');
        return view('admin.cards.show', compact('card'));
    }


    public function toggle(Card $card)
    {
        $card->is_active = !$card->is_active;
        $card->save();

        $status = $card->is_active ? 'odblokována' : 'zablokována';

        return redirect()
            ->route('admin.cards.show', $card)
            ->with('success', "Karta byla úspěšně {$status}.");
    }
}
