<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExpenseRequest;
use App\Models\Account;
use App\Models\Category;
use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $expenses = Expense::with('category', 'user')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('expenses/home', ['expenses' => $expenses]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $categories = Category::where('user_id', auth()->id())
            ->orWhere('user_id', null)
            ->get();

        return view('expenses.create', [
            'categories' => $categories,
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(StoreExpenseRequest $request)
    {
        if (!$request->category_id) {
            $category = Category::firstOrCreate([
                'name' => $request->category,
                'user_id' => $request->user()->id
            ]);
        }

        Expense::create([
            'user_id' => $request->user()->id,
            'date' => $request->date,
            'amount' => $request->amount,
            'category_id' => $request->category_id ?? $category->id,
            'account_id' => $request->user()->account()->first()->id
        ]);

        $account = $request->user()->account()->first();

        $newBalance = $account->balance - $request->amount;

        $account->update(['balance' => $newBalance]);

        return redirect('expenses/home')->with('status', 'Record created successfully');
    }
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function structure()
    {
        $expenses = Expense::where('user_id', auth()->id())
            ->with('category')
            ->get()
            ->groupBy('category_id');

        $expensesByCategory = $expenses->map(function ($group) {
            return [
                'category' => $group->first()->category,
                'amount' => $group->sum('amount'),
            ];
        });

        return view('expenses.structure.total', ['expenses' => $expensesByCategory]);
    }

    /**
     * @param $days
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function structureByDays($days)
    {
        $date = \Carbon\Carbon::today()->subDays($days);

        $expenses = Expense::where('date', '>=', $date)
            ->where('user_id', auth()->id())
            ->with('category')
            ->get()
            ->groupBy('category_id');

        $expensesByCategory = $expenses->map(function ($group) {
            return [
                'category' => $group->first()->category,
                'amount' => $group->sum('amount'),
            ];
        });

        return view('expenses.structure.days', ['expenses' => $expensesByCategory]);
    }
}
