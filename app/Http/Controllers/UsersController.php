<?php

namespace App\Http\Controllers;

class UsersController extends Controller
{
    public function createCostumer() {
        return "Test createCostumer";
    }

    public function createSeller() {
        return "Test createSeller";
    }
    
    public function createUser() {
        return "Test createUser";
    }

    public function getUser($id) {
        return "Test getUser id = " . $id;
    }

    public function getUsers() {
        return "Test getUsers";
    }
}
