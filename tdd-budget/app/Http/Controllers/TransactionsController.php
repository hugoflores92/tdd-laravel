<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\Category;

use Illuminate\Http\Request;

class TransactionsController extends Controller{
    public function index(Category $category){
        $transactions = Transaction::byCategory($category)->get();
        
        return view('transactions.index', compact('transactions'));
    }

    public function store(){
        $this->validate(request(), [
            'description' => 'required',
            'category_id' => 'required',
            'amount' => 'required|numeric'
        ]);

        Transaction::create(request()->all());
        return redirect('/transactions');
    }
}
