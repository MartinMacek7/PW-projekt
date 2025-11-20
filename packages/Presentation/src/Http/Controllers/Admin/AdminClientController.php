<?php

namespace Presentation\Http\Controllers\Admin;

use Application\Services\Interface\IUserService;
use Domain\Models\User;
use Illuminate\Http\Request;
use Presentation\Http\Requests\AdminClientRequest;

class AdminClientController extends AdminController
{

    public function __construct(private IUserService $userService)
    {}


    public function index(Request $request)
    {
        $clients = $this->userService->getFilteredUsers($request->all());
        return view('presentation::admin.clients.index', compact('clients'));
    }


    public function edit(User $client)
    {
        return view('presentation::admin.clients.edit', compact('client'));
    }


    public function update(AdminClientRequest $request, User $client)
    {
        $this->userService->updateUser($client, $request);

        return redirect()->route('admin.clients.index')
            ->with('success', 'Klient byl úspěšně upraven.');
    }

}
