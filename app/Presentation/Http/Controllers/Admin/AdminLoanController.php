<?php

namespace App\Presentation\Http\Controllers\Admin;

use App\Domain\Models\Loan;
use App\Domain\Models\User;
use App\Presentation\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;

class AdminLoanController extends AdminController
{
    public function index(Request $request)
    {
        $query = Loan::with(['user']);

        if ($request->filled('approved')) {
            $query->where('approved', $request->approved);
        }

        if ($request->filled('user')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->user . '%')
                  ->orWhere('surname', 'like', '%' . $request->user . '%')
                  ->orWhere('email', 'like', '%' . $request->user . '%');
            });
        }

        $loans = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.loans.index', compact('loans'));
    }

    public function show(Loan $loan)
    {
        $loan->load('user');
        return view('admin.loans.show', compact('loan'));
    }

    public function approve(Loan $loan)
    {
        $loan->update(['approved' => true]);
        return redirect()->route('admin.loans.index')->with('success', 'Úvěr byl schválen.');
    }

    public function destroy(Loan $loan)
    {
        $loan->delete();
        return redirect()->route('admin.loans.index')->with('success', 'Úvěr byl odstraněn.');
    }
}
