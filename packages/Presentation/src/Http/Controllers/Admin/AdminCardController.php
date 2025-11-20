<?php

namespace Presentation\Http\Controllers\Admin;

use Application\Services\Interface\ICardService;
use Domain\Models\Card;
use Illuminate\Http\Request;

class AdminCardController extends AdminController
{
    public function __construct(private ICardService $cardService)
    {}

    public function index(Request $request)
    {
        $cards = $this->cardService->filterCards($request->all());
        return view('presentation::admin.cards.index', compact('cards'));
    }

    public function show(Card $card)
    {
        $card->load('bankAccount.user');
        return view('presentation::admin.cards.show', compact('card'));
    }

    public function toggle(Card $card)
    {
        $this->cardService->toggleCard($card);

        $status = $card->is_active ? 'odblokována' : 'zablokována';

        return redirect()
            ->route('admin.cards.show', $card)
            ->with('success', "Karta byla úspěšně {$status}.");
    }
}
