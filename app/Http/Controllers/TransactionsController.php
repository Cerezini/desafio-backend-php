<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionsController extends Controller
{
    public function createTransaction(Request $request) {
        
        // Request validation
        $validator = Validator::make($request->all(), [
            'payee_id' => 'required|integer',
            'payer_id' => 'required|integer',
            'value' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => '422',
                'message' => 'Erro de validação dos campos'
            ], 422);
        }

        $users = User::whereIn('id', [$request->payee_id, $request->payer_id])
            ->select('id')
            ->get();

        if ($users->count() != 2) {
            return response()->json([
                'code' => '422',
                'message' => 'Erro de validação dos campos'
            ], 422);
        }

        // Transaction validation
        $http = new Client();
            
        $response = $http->request('GET', 'http://api-node:8001/transaction?value=' . $request->value, ['http_errors' => false]);

        if ($response->getStatusCode() == 401) {
            return response()->json([
                'code' => '401',
                'message' => 'Transação não autorizada'
            ], 401);
        } elseif ($response->getStatusCode() != 200) {
            return response()->json([
                'code' => '500',
                'message' => 'Erro interno do servidor'
            ], 500);
        }
        
        // Save transaction
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
            return response()->json([
                'code' => '404',
                'message' => 'Transação não encontrada'
            ], 404);
        }

        return [
            'id' => $transaction->id,
            'payee_id' => $transaction->payee_id,
            'payer_id' => $transaction->payer_id,
            'transaction_date' => $transaction->transaction_date->toJson(),
            'value' => floatval($transaction->value),
        ];
    }
}
