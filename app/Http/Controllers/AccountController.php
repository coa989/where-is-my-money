<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function create()
    {
        return view('account.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'balance' => 'required|integer',
        ]);

        Account::create([
            'user_id' => $request->user()->id,
            'name' => $request->name,
            'balance' => $request->balance,
        ])->save();

        return redirect('account/index');
    }
}
