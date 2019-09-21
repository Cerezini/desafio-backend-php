<?php

namespace App\Http\Controllers;

use App\Models\Consumer;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    public function createConsumer(Request $request) {
        // Request validation
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'username' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => '422',
                'message' => 'Erro de validação dos campos'
            ], 422);
        }

        $consumerSameUsername = Consumer::where('username', $request->username)->exists();

        $sellerSameUsername = Seller::where('username', $request->username)->exists();     
        
        $userExists = User::where('id', $request->user_id)->exists();

        $userHasConsumer = Consumer::where('user_id', $request->user_id)->exists();; 

        if (!$userExists || $userHasConsumer || $consumerSameUsername || $sellerSameUsername) {
            return response()->json([
                'code' => '422',
                'message' => 'Erro de validação dos campos'
            ], 422);
        } 

        // Save Consumer
        $consumer = new Consumer;

        $consumer->user_id = $request->user_id;
        $consumer->username = $request->username;
        
        $consumer->save();
    
        return $consumer;
    }

    public function createSeller(Request $request) {
        // Request validation
        $validator = Validator::make($request->all(), [
            'cnpj' => 'required|string|regex:/^\d{14}/i',
            'fantasy_name' => 'required|string|max:255',
            'social_name' => 'required|string|max:255',
            'user_id' => 'required|integer',
            'username' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => '422',
                'message' => 'Erro de validação dos campos'
            ], 422);
        }

        $consumerSameUsername = Consumer::where('username', $request->username)->exists();

        $sellerSameUsername = Seller::where('username', $request->username)->exists();     
        
        $userExists = User::where('id', $request->user_id)->exists();

        $userHasSeller = Seller::where('user_id', $request->user_id)->exists();; 

        if (!$userExists || $userHasSeller || $consumerSameUsername || $sellerSameUsername) {
            return response()->json([
                'code' => '422',
                'message' => 'Erro de validação dos campos'
            ], 422);
        }     

        // Save seller
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
        // Request validation
        $validator = Validator::make($request->all(), [
            'cpf' => 'required|string|regex:/^\d{11}/i',
            'email' => 'required|string|email|max:255',
            'full_name' => 'required|string|max:255',
            'password' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => '422',
                'message' => 'Erro de validação dos campos'
            ], 422);
        }

        $cpfOrEmailUsed = User::where('cpf', $request->cpf)
            ->orWhere('email', $request->email)
            ->exists();

        if ($cpfOrEmailUsed) {
            return response()->json([
                'code' => '422',
                'message' => 'Erro de validação dos campos'
            ], 422);
        }

        // Save user
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
            return response()->json([
                'code' => '404',
                'message' => 'Usuário não encontrado'
            ], 404);
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
