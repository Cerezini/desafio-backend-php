<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    public function createTransaction(Request $request) {
        // Validate if users exist
        // Validate value in external http service

        $http = new Client();
            
        $response = $http->request('GET', 'http://api-node:8001/transaction?value=' . $request->value, ['http_errors' => false]);

        if ($response->getStatusCode() != 200) {
            return 'Transação não autorizada'; 
        }
    	
        $transaction = new Transaction;

        $transaction->payee_id = $request->payee_id;
        $transaction->payer_id = $request->payer_id;
        $transaction->value = $request->value;
        $transaction->transaction_date = Carbon::now();
        
        $transaction->save();

        return [
            'id' => $transaction->id,
            'payee_id' => $transaction->payee_id,
            'payer_id' => $transaction->payer_id,
            'transaction_date' => $transaction->transaction_date->toJson(),
            'value' => $transaction->value,
        ];
    }

    public function getTransaction($transaction_id) {

        $transaction = Transaction::find($transaction_id);

        if ($transaction == null) {
            return 'ERRO 404';
        }

        return [
            'id' => $transaction->id,
            'payee_id' => $transaction->payee_id,
            'payer_id' => $transaction->payer_id,
            'transaction_date' => $transaction->transaction_date->toJson(),
            'value' => $transaction->value,
        ];
    }
}
