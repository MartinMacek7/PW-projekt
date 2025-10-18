<?php

namespace App\Presentation\Http\Controllers\Admin;

use App\Domain\Models\User;
use App\Presentation\Http\Requests\AdminClientRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminClientController extends AdminController
{

    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%')
                ->orWhere('surname', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        if ($request->filled('phone_number')) {
            $query->where('phone_number', 'like', '%' . $request->phone_number . '%');
        }

        if ($request->filled('birth_number')) {
            $query->where('birth_number', 'like', '%' . $request->birth_number . '%');
        }

        $clients = $query->orderBy('surname')->paginate(15);

        return view('admin.clients.index', compact('clients'));
    }


    public function edit(User $client)
    {
        return view('admin.clients.edit', compact('client'));
    }


    public function update(AdminClientRequest $request, User $client)
    {
        $data = $request->validated();
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $client->update($data);

        return redirect()->route('admin.clients.index')
            ->with('success', 'Klient byl úspěšně upraven.');
    }
}
