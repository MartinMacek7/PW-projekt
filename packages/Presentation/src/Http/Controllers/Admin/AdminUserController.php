<?php

namespace Presentation\Http\Controllers\Admin;

use Application\Services\UserService;
use Domain\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends AdminController
{

    public function __construct(private UserService $userService)
    {
        parent::__construct();
    }


    public function index(Request $request)
    {
        $users = $this->userService->getFilteredUsers($request->only(['email', 'name', 'surname']));
        return view('presentation::admin.users.index', compact('users'));
    }


    public function updateRole(User $user, Request $request)
    {
        $newRole = (int)$request->input('role');
        $updated = $this->userService->updateUserRole($user, $newRole);

        if (! $updated) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Neplatná role.');
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'Role byla aktualizována.');
    }


    public function destroy(User $user)
    {
        $this->userService->deleteUser($user);

        return redirect()->route('admin.users.index')
            ->with('success', 'Uživatel byl smazán.');
    }
}
