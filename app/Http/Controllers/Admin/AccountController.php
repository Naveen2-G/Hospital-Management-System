<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query()->where('role', 'patient');

        if ($request->filled('search')) {
            $s = trim((string) $request->search);
            $query->where(function ($q) use ($s) {
                $q->where('email', 'like', "%{$s}%")
                    ->orWhere('name', 'like', "%{$s}%")
                    ->orWhere('phone', 'like', "%{$s}%");
            });
        }

        $accounts = $query->orderByDesc('created_at')->paginate(20)->withQueryString();

        return view('admin.accounts.index', compact('accounts'));
    }
}

