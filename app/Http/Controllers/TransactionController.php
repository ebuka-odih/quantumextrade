<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use App\Models\Withdrawal;
use App\Models\FundTransfer;
use App\Models\Trade;
use App\Models\HoldingTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get all transaction types
        $deposits = Deposit::where('user_id', $user->id)->latest()->get();
        $withdrawals = Withdrawal::where('user_id', $user->id)->latest()->get();
        $transfers = FundTransfer::where('user_id', $user->id)->latest()->get();
        $trades = Trade::where('user_id', $user->id)->with('trade_pair')->latest()->get();
        $holdingTransactions = HoldingTransaction::where('user_id', $user->id)->with('asset')->latest()->get();
        
        return view('dashboard.transactions.index', compact(
            'deposits',
            'withdrawals', 
            'transfers',
            'trades',
            'holdingTransactions'
        ));
    }
}
