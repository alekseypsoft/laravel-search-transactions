<?php

namespace App\Services;

use App\Models\User;

class TransactionService
{
    /**
     * Получение месячного баланса
     *
     * @param User $user Пользователь
     * @param string $month Месяц
     *
     * @return float Месячный баланс
     */
    public function getMonthBalance(User $user, string $month): float
    {
        $user = $user->with(['userAccount.transactionsFrom' => function ($query) use ($month) {
            $query->where('trdate', 'like', $month . '%');
        }])->where('id', $user->id)->first();
        $balance1 = array_reduce($user->userAccount->transactionsFrom->toArray(), function ($acc, $t) {
            return $acc + $t['amount'];
        });
        $balance2 = array_reduce($user->userAccount->transactionsTo->toArray(), function ($acc, $t) {
            return $acc + $t['amount'];
        });

        return $balance1 - $balance2;
    }
}
