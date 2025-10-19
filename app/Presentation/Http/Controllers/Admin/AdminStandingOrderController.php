<?php

namespace App\Presentation\Http\Controllers\Admin;

use App\Domain\Models\StandingOrder;
use App\Application\Services\StandingOrderService;
use Illuminate\Http\Request;

class AdminStandingOrderController extends AdminController
{

    public function __construct(private StandingOrderService $standingOrderService) {
        parent::__construct();
    }


    public function index(Request $request)
    {
        $orders = $this->standingOrderService->filterStandingOrders($request->all());
        return view('admin.standing_orders.index', compact('orders'));
    }


    public function show(StandingOrder $standingOrder)
    {
        $standingOrder->load('bankAccount.user');
        return view('admin.standing_orders.show', compact('standingOrder'));
    }


    public function destroy(StandingOrder $standingOrder)
    {
        $this->standingOrderService->deleteStandingOrder($standingOrder);
        return redirect()->route('admin.standing_orders.index')
            ->with('success', 'Trvalý příkaz byl odstraněn.');
    }

}
