<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function createCostumer() {
        return "Test createCostumer";
    }

    public function createSeller() {
        return "Test createSeller";
    }
    
    public function createUser (Request $request)
    {
        // Validate the request...

        $userSameCpf = User::where('cpf', $request->cpf)->first();

        if ($userSameCpf != null) {
            return "ERROR 422";
        }

        $userSameEmail = User::where('email', $request->email)->first();

        if ($userSameEmail != null) {
            return "ERROR 422";
        }

        $user = new User;

        $user->cpf = $request->cpf;
        $user->email = $request->email;
        $user->full_name = $request->full_name;
        $user->password = $request->password;
        $user->phone_number = $request->phone_number;
        
        $user->save();
    
        return $user;
    }

    public function getUser($id) {
        return "Test getUser id = " . $id;
    }

    public function getUsers() {
        return "Test getUsers";
    }
}
