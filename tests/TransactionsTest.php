<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class TransactionsTest extends TestCase
{
    public function testCreateTransaction()
    {
        $transactionRequest = [
            'payee_id' => 5,
            'payer_id' => 6,
            'value' => 25.69
        ];

        $this->post('/transactions', $transactionRequest)
            ->seeJson($transactionRequest);
    }

    public function testGetTransaction()
    {
        $transactionRequest = [
            'payee_id' => 5,
            'payer_id' => 6,
            'value' => 25.69
        ];

        $this->get('/transactions/3')
            ->seeJson($transactionRequest);
    }
}
