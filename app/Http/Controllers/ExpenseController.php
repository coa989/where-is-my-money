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
        $expenses = DB::table('expenses')
            ->join('categories', 'expenses.category_id', '=', 'categories.id')
            ->select('expenses.*', 'categories.name')
            ->where('expenses.user_id', auth()->user()->id)
            ->get();

        return view('home', ['expenses' => $expenses]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('create', [
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
}
