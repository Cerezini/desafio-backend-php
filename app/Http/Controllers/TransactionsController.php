<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    public function createTransaction(Request $request) {
        // Validate if users exist
        // Validate value in external http service

        $transaction = new Transaction;

        $transaction->payee_id = $request->payee_id;
        $transaction->payer_id = $request->payer_id;
        $transaction->value = $request->value;
        $transaction->transaction_date = Carbon::now();
        
        $transaction->save();
    
        return $transaction;
    }

    public function getTransaction($transaction_id) {
        return Transaction::find($transaction_id);
    }
}
