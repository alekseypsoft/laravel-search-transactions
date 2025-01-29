<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserAccount extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
    ];

    public $timestamps = false;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'user_id' => 'integer',
        ];
    }

    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function transactionsFrom(): HasMany{
        return $this->hasMany(Transaction::class, 'account_from');
    }

    public function transactionsTo(): HasMany{
        return $this->hasMany(Transaction::class, 'account_to');
    }

}
