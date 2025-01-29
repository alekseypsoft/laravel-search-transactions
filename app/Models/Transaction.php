<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'account_from', 'account_to', 'amount', "trdate"
    ];

    public $timestamps = false;


    protected function casts(): array
    {
        return [
            'account_from' => 'integer',
            'account_to' => 'integer',
            'amount' => 'float',
            'trdate' => 'date'
        ];
    }


    public function accountFrom(): BelongsTo{
        return $this->belongsTo(UserAccount::class, 'account_from');
    }

    public function accountTo(): BelongsTo{
        return $this->belongsTo(UserAccount::class, 'account_to');
    }


}
