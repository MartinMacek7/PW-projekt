<?php

namespace App\Presentation\Http\Controllers\Admin;

use App\Domain\Enums\UserRole;
use App\Domain\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends AdminController
{

    public function __construct()
    {
        $this->middleware('admin');
    }


    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('email')) {
            $query->where('email', 'like', '%'.$request->email.'%');
        }

        if ($request->filled('name')) {
            $query->where('name', 'like', '%'.$request->name.'%');
        }

        if ($request->filled('surname')) {
            $query->where('surname', 'like', '%'.$request->surname.'%');
        }

        $users = $query->orderBy('id', 'desc')->get();

        return view('admin.users.index', compact('users'));
    }

    public function updateRole(User $user, Request $request)
    {
        $newRole = $request->input('role');

        if (!UserRole::tryFrom((int)$newRole)) {
            return redirect()->route('admin.users.index')->with('error', 'Neplatná role.');
        }

        $user->permission_level = (int)$newRole;
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Role byla aktualizována.');
    }

    public function destroy(User $user)
    {
        if ($user->permission_level === UserRole::ADMIN->value) {
            return redirect()->route('admin.users.index')->with('error', 'Administrátora nelze smazat.');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Uživatel byl smazán.');
    }
}
