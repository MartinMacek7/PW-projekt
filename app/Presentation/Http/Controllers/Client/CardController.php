<?php

namespace App\Presentation\Http\Controllers\Client;

use App\Application\Services\CardService;
use App\Domain\Models\Card;
use App\Domain\Models\User;
use App\Presentation\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CardController extends Controller
{


    public function __construct(private CardService $cardService)
    {
        parent::__construct();
    }


    public function index()
    {
        $cards = $this->cardService->getUserCards(Auth::id());
        return view('client.cards.index', ['cards' => $cards]);
    }


    public function show(Card $card)
    {
        return view('client.cards.show', ['card' => $card]);
    }

    public function toggle(Request $request, Card $card)
    {
        $card->is_active = !$card->is_active;
        $card->save();

        $status = $card->is_active ? 'odblokována' : 'zablokována';

        return redirect()->route('cards', $card)->with('success', "Karta byla úspěšně {$status}.");
    }




}
