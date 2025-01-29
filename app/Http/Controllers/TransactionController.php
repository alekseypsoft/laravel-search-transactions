<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TransactionController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * Поиск транзакций
     *
     * @return View
     */
    public function search(): View
    {
        $balances = Transaction::get();

        $users = User::whereHas('userAccount', function ($query) {
            $query->whereHas('transactionsFrom')->orWhereHas('transactionsTo');
        });

        return view('transactions.search', compact('balances', 'users'));
    }
}
