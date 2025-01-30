<?php

namespace App\Services;

use App\Models\User;

class TransactionService
{
    /**
     * Получение месячного баланса
     *
     * @param User $user Пользователь для которого получается баланс
     * @param string $month Месяц
     *
     * @return float Месячный баланс
     */
    public function getMonthBalance(User $user, string $month): float
    {
        $user = $user->with(['userAccount.transactionsFrom' => function ($query) use ($month) {
            $query->where('trdate', 'like', $month . '%');
        }])
            ->with(['userAccount.transactionsTo' => function ($query) use ($month) {
                $query->where('trdate', 'like', $month . '%');
            }])
            ->where('id', $user->id)->first();
        $balance1 = array_reduce($user->userAccount->transactionsFrom->toArray(), function ($acc, $t) {
            return $acc + $t['amount'];
        });
        $balance2 = array_reduce($user->userAccount->transactionsTo->toArray(), function ($acc, $t) {
            return $acc + $t['amount'];
        });

        return $balance1 - $balance2;
    }

    /**
     * Поолучить годовой баланс
     *
     * @param User $user Пользователь для которого получается баланс
     * @param string $year Год
     *
     * @return array
     */
    public function getYearBalance(User $user, string $year): array{
        $list = [];

        for($i = 0; $i < 12; $i++){
            $str = sprintf('%02d', $i);
            $list[$year . '-' .  $str] =  $this->getMonthBalance($user, $year . '-' .  $str);
        }

        return $list;
    }
}
