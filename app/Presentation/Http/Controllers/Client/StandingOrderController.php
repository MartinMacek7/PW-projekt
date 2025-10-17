<?php

namespace App\Presentation\Http\Controllers\Client;

use App\Domain\Models\StandingOrder;
use App\Presentation\Http\Controllers\Controller;
use App\Presentation\Http\Requests\StandingOrderRequest;
use Illuminate\Support\Facades\Auth;

class StandingOrderController extends Controller
{


    public function __construct()
    {
        parent::__construct();
    }


    public function index()
    {
        $orders = StandingOrder::with('bankAccount')
        ->whereHas('bankAccount', function ($bankAccount) {
            $bankAccount->where('user_id', Auth::id());
        })
        ->get();

        return view('client.standing_orders.index', compact('orders'));
    }


    public function create()
    {
        $accounts = Auth::user()->bankAccounts;
        return view('client.standing_orders.create', compact('accounts'));
    }


    public function store(StandingOrderRequest $request)
    {
        StandingOrder::create([
            'user_id' => Auth::id(),
            ...$request->validated(),
        ]);

        return redirect()->route('standing_orders')->with('success', 'Trvalý příkaz byl vytvořen.');
    }

    public function show(StandingOrder $standingOrder)
    {
        return view('client.standing_orders.show', compact('standingOrder'));
    }

    public function destroy(StandingOrder $standingOrder)
    {
        $standingOrder->delete();
        return redirect()->route('standing_orders')->with('success', 'Trvalý příkaz byl smazán.');
    }




}
