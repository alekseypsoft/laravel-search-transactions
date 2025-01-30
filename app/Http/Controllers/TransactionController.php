<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use App\Http\Requests\TransactionRequest;
use App\Services\TransactionService;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;

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
        $users = User::whereHas('userAccount', function ($query) {
            $query->whereHas('transactionsFrom')->orWhereHas('transactionsTo');
        })->get();

        return view('transactions.search', compact('users'));
    }

    /**
     * Получить баланс по AJAX
     *
     * @param TransactionRequest $request
     *
     * @param TransactionService $service
     * @return JsonResponse
     */
   public function balance(TransactionRequest $request, TransactionService $service): JsonResponse
   {
        $user = User::find($request->userId);

        if($request->month !== null){
            $balance = $service->getMonthBalance($user, $request->month);
            $result = ['balance' => $balance];
        }
        else{
            $balance = $service->getYearBalance($user, $request->year);
            $result = ['balance' => $balance];
        }

       return response()->json($result);
   }
}
