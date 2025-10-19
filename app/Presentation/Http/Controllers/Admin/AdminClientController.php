<?php

namespace App\Presentation\Http\Controllers\Admin;

use App\Domain\Models\User;
use App\Application\Services\UserService;
use App\Presentation\Http\Requests\AdminClientRequest;
use Illuminate\Http\Request;

class AdminClientController extends AdminController
{

    public function __construct(private UserService $userService)
    {}


    public function index(Request $request)
    {
        $clients = $this->userService->getFilteredUsers($request->all());
        return view('admin.clients.index', compact('clients'));
    }


    public function edit(User $client)
    {
        return view('admin.clients.edit', compact('client'));
    }


    public function update(AdminClientRequest $request, User $client)
    {
        $this->userService->updateUser($client, $request);

        return redirect()->route('admin.clients.index')
            ->with('success', 'Klient byl úspěšně upraven.');
    }

}
