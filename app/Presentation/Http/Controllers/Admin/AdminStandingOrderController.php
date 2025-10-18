<?php

namespace App\Presentation\Http\Controllers\Admin;

use App\Domain\Models\StandingOrder;
use Illuminate\Http\Request;

class AdminStandingOrderController extends AdminController
{
    public function index(Request $request)
    {
        $query = StandingOrder::with(['bankAccount.user']);

        if ($request->filled('account_number')) {
            $query->whereHas('bankAccount', function ($q) use ($request) {
                $q->where('account_number', 'like', '%' . $request->account_number . '%');
            });
        }

        if ($request->filled('client_name')) {
            $query->whereHas('bankAccount.user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->client_name . '%')
                  ->orWhere('surname', 'like', '%' . $request->client_name . '%');
            });
        }

        $orders = $query->orderByDesc('created_at')->paginate(20);

        return view('admin.standing_orders.index', compact('orders'));
    }

    public function show(StandingOrder $standingOrder)
    {
        $standingOrder->load('bankAccount.user');
        return view('admin.standing_orders.show', compact('standingOrder'));
    }

    public function destroy(StandingOrder $standingOrder)
    {
        $standingOrder->delete();
        return redirect()->route('admin.standing_orders.index')->with('success', 'Trvalý příkaz byl odstraněn.');
    }
}
