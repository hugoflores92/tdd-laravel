<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\Category;

use Illuminate\Http\Request;
use Carbon\Carbon;

class TransactionsController extends Controller{
    const TRANSACTIONS_INDEX_NAMED_ROUTE = 'transactions.index';

    public function __construct(){
        $this->middleware('auth');
    }
    
    public function index(Request $request, Category $category){
        $transactionsQuery = Transaction::byCategory($category);
        $currentMonth = $request->input('month') ?: Carbon::now()->format('M');
        if ($request->has('month')){
            $transactionsQuery->byMonth($request->input('month'));
        }
        else{
            $transactionsQuery->byMonth();
        }

        $transactions = $transactionsQuery->paginate();
        
        return view('transactions.index', compact('transactions', 'currentMonth'));
    }

    public function create(){
        $categories = Category::all();
        $transaction = new Transaction;

        return view('transactions.create', compact('categories', 'transaction'));
    }

    public function store(Request $request){
        $attributes = $request->all();

        Transaction::validate($attributes);
        Transaction::create($attributes);
        return redirect(route(self::TRANSACTIONS_INDEX_NAMED_ROUTE));
    }

    public function edit(Transaction $transaction){
        $categories = Category::all();
        return view('transactions.edit', compact('transaction', 'categories'));
    }

    public function update(Request $request, Transaction $transaction){
        $attributes = $request->all();

        Transaction::validate($attributes);
        $transaction->update($attributes);
        return redirect(route(self::TRANSACTIONS_INDEX_NAMED_ROUTE));
    }

    public function destroy(Transaction $transaction){
        $transaction->delete();
        return redirect(route(self::TRANSACTIONS_INDEX_NAMED_ROUTE));
    }
}
