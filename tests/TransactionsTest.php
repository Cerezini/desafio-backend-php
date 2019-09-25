<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class TransactionsTest extends TestCase
{
    use DatabaseTransactions;

    public function testCreateTransaction()
    {
        $users = factory('App\Models\User', 2)->create();

        $transaction = factory('App\Models\Transaction')
            ->make([
                'payee_id' => $users[0]->id,
                'payer_id' => $users[1]->id,
            ])
            ->toArray();

        unset($transaction['transaction_date']);

        $this->post('/transactions', $transaction)
            ->seeJson($transaction);
    }

    public function testGetTransaction()
    {
        $users = factory('App\Models\User', 2)->create();

        $transaction = factory('App\Models\Transaction')
            ->create([
                'payee_id' => $users[0]->id,
                'payer_id' => $users[1]->id,
            ]);

        $this->get('/transactions/' . $transaction->id)
            ->seeJson([
                'id' => $transaction->id,
                'payee_id' => $transaction->payee_id,
                'payer_id' => $transaction->payer_id,
                'transaction_date' => $transaction->transaction_date->toJson(),
                'value' => $transaction->value
            ]);
    }
}
