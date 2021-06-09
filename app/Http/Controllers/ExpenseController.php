<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $expenses = Expense::with('category', 'user')->where('user_id', auth()->user()->id)->latest()->get();

        return view('expenses/home', ['expenses' => $expenses]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('expenses/create', [
            'categories' => Category::where('user_id', auth()->user()->id)
                ->orWhere('user_id', null)
                ->get(),
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {;
        $this->validate($request, [
            'date' => 'required|date',
            'amount' => 'required|integer',
            'category_id' => 'required_without:category',
            'category' => 'required_without:category_id'
        ]);

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
            'category_id' => $request->category_id ?? $category->id
        ])->save();

        return redirect('home');
    }
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function structure()
    {
        $expenses = Expense::where('user_id', auth()->user()->id)->with('category')->get();

        $categoryExp = $expenses->groupBy('category_id');

        $categoryExpWithCount = $categoryExp->map(function ($group) {
            return [
                'category' => $group->first()->category,
                'amount' => $group->sum('amount'),
            ];
        });

        return view('expenses/total-structure', ['expenses' => $categoryExpWithCount]);
    }

    /**
     * @param $days
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function structureByDays($days)
    {
        $date = \Carbon\Carbon::today()->subDays($days);

        $expenses = Expense::where('date', '>=', $date)->where('user_id', auth()->user()->id)->with('category')->get();

        $categoryExp = $expenses->groupBy('category_id');

        $categoryExpWithCount = $categoryExp->map(function ($group) {
            return [
                'category' => $group->first()->category,
                'amount' => $group->sum('amount'),
            ];
        });

        return view('expenses/days-structure', ['expenses' => $categoryExpWithCount]);
    }
}
