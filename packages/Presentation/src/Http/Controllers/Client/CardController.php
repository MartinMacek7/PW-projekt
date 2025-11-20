<?php

namespace Presentation\Http\Controllers\Client;

use Application\Services\Interface\ICardService;
use Domain\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Presentation\Http\Controllers\Controller;

class CardController extends Controller
{


    public function __construct(private ICardService $cardService)
    {
        parent::__construct();
    }


    public function index()
    {
        $cards = $this->cardService->getUserCards(Auth::id());
        return view('presentation::client.cards.index', ['cards' => $cards]);
    }


    public function show(Card $card)
    {
        return view('presentation::client.cards.show', ['card' => $card]);
    }

    public function toggle(Request $request, Card $card)
    {
        $this->cardService->toggleCard($card);
        $status = $card->is_active ? 'odblokována' : 'zablokována';
        return redirect()->route('cards', $card)->with('success', "Karta byla úspěšně {$status}.");
    }




}
