<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\Category;

use Illuminate\Http\Request;

class TransactionsController extends Controller{
    const TRANSACTIONS_INDEX_NAMED_ROUTE = 'transactions.index';

    public function __construct(){
        $this->middleware('auth');
    }
    
    public function index(Category $category){
        $transactions = Transaction::byCategory($category)->get();
        
        return view('transactions.index', compact('transactions'));
    }

    public function create(){
        $categories = Category::all();

        return view('transactions.create', compact('categories'));
    }

    public function store(Request $request){
        $attributes = $request->all();

        Transaction::validate($attributes);
        Transaction::create($attributes);
        return redirect(route(self::TRANSACTIONS_INDEX_NAMED_ROUTE));
    }

    public function update(Request $request, Transaction $transaction){
        $attributes = $request->all();

        Transaction::validate($attributes);
        $transaction->update($attributes);
        return redirect(route(self::TRANSACTIONS_INDEX_NAMED_ROUTE));
    }
}
