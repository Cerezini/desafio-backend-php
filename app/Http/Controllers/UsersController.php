<?php

namespace App\Http\Controllers;

use App\Models\Consumer;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function createConsumer(Request $request) {
        // Validate the request...
        // Validate user already have consumer

        $consumerSameUsername = Consumer::where('username', $request->username)->first();

        if ($consumerSameUsername != null) {
            return "ERROR 422";
        }

        $sellerSameUsername = Seller::where('username', $request->username)->first();

        if ($sellerSameUsername != null) {
            return "ERROR 422";
        }

        $consumer = new Consumer;

        $consumer->user_id = $request->user_id;
        $consumer->username = $request->username;
        
        $consumer->save();
    
        return $consumer;
    }

    public function createSeller(Request $request) {
        // Validate the request...
        // Validate user already have seller

        $consumerSameUsername = Consumer::where('username', $request->username)->first();

        if ($consumerSameUsername != null) {
            return "ERROR 422";
        }

        $sellerSameUsername = Seller::where('username', $request->username)->first();

        if ($sellerSameUsername != null) {
            return "ERROR 422";
        }

        $seller = new Seller;

        $seller->cnpj = $request->cnpj;
        $seller->fantasy_name = $request->fantasy_name;
        $seller->social_name = $request->social_name;
        $seller->user_id = $request->user_id;
        $seller->username = $request->username;
        
        $seller->save();
    
        return $seller;
    }
    
    public function createUser (Request $request) {
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

    public function getUser($user_id) {
        $user = User::find($user_id);
        
        if ($user == null) {
            return "ERROR 422";
        } 
        
        $result = [
            'user' => $user,
            'accounts' => [
                'consumer' => null,
                'seller' => null
            ]
        ];

        $result['accounts']['consumer'] = Consumer::where('user_id', $user_id)->first();
        $result['accounts']['seller'] = Seller::where('user_id', $user_id)->first();

        return $result;
    }

    public function getUsers(Request $request) {
        if (!$request->filled('q') || $request->q[0] == '/') {
            return User::orderBy('full_name', 'asc')->get();
        }

        $query = $request->q . '%';

        return User::leftJoin('consumers', 'users.id', '=', 'consumers.user_id')
            ->leftJoin('sellers', 'users.id', '=', 'sellers.user_id')
            ->where('users.full_name', 'like', $query)
            ->orWhere('consumers.username', 'like', $query)
            ->orWhere('sellers.username', 'like', $query)
            ->select('users.*')
            ->orderBy('full_name', 'asc')
            ->get();
    }
}
