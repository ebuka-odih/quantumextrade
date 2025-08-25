<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CopiedTrade extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'copy_trader_id',
        'amount',
        'status',
        'stopped_at'
    ];

    protected $casts = [
        'stopped_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function copy_trader()
    {
        return $this->belongsTo(CopyTrader::class, 'copy_trader_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isActive()
    {
        return $this->status == 1;
    }

    public function isStopped()
    {
        return $this->status == 0;
    }
}
