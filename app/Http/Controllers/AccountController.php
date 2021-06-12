<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use voku\helper\ASCII;

class AccountController extends Controller
{
    // TODO Only account owner can access
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('account.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string'],
            'balance' => ['required', 'integer'],
        ]);

        Account::create([
            'user_id' => $request->user()->id,
            'name' => $request->name,
            'balance' => $request->balance,
        ])->save();

        return redirect('expenses/create');
    }

    /**
     * Display the specified resource
     * @param Account $account
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Account $account)
    {
        return view('account.show', ['account' => $account]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Account $account
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Account $account)
    {
        return view('account.edit', ['account' => $account]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Account $account
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Account $account)
    {
        $this->validate($request, [
            'name' => ['required', 'string'],
            'balance' => ['required', 'integer'],
        ]);

        Account::find($account->id)->update([
            'name' => $request->name,
            'balance' => $request->balance
        ]);

        return redirect()->route('account.show', $account);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Account $account
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Account $account)
    {
        Account::find($account->id)->delete();

        return redirect('expenses/home');
    }
}
