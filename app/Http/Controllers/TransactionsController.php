<?php

namespace App\Http\Controllers;

class TransactionsController extends Controller
{
    public function createTransaction() {
        return "Test createTransaction";
    }

    public function getTransaction($id) {
        return "Test getTransaction id = " . $id;
    }
}
