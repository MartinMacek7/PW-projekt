<?php

namespace Presentation\Http\Controllers\Admin;

use Application\Services\Interface\IStandingOrderService;
use Domain\Models\StandingOrder;
use Illuminate\Http\Request;

class AdminStandingOrderController extends AdminController
{

    public function __construct(private IStandingOrderService $standingOrderService) {
        parent::__construct();
    }


    public function index(Request $request)
    {
        $orders = $this->standingOrderService->filterStandingOrders($request->all());
        return view('presentation::admin.standing_orders.index', compact('orders'));
    }


    public function show(StandingOrder $standingOrder)
    {
        $standingOrder->load('bankAccount.user');
        return view('presentation::admin.standing_orders.show', compact('standingOrder'));
    }


    public function destroy(StandingOrder $standingOrder)
    {
        $this->standingOrderService->deleteStandingOrder($standingOrder);
        return redirect()->route('admin.standing_orders.index')
            ->with('success', 'Trvalý příkaz byl odstraněn.');
    }

}
