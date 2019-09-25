<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class UsersTest extends TestCase
{
    use DatabaseTransactions;

    public function testCreateUser()
    {
        $user = factory('App\Models\User')
            ->make()
            ->toArray();

        $this->post('/users', $user)
            ->seeJson($user);
    }

    public function testCreateConsumer()
    {
        $user = factory('App\Models\User')->create();
        
        $consumer = factory('App\Models\Consumer')
            ->make([
                'user_id' => $user->id
            ])
            ->toArray();

        $this->post('/users/consumers', $consumer)
            ->seeJson($consumer);
    }

    // public function testCreateSeller()
    // {
    //     $sellerRequest = [
    //         'cnpj' => '11111111558524',
    //         'fantasy_name' => 'Potato Girl Tapiocaria',
    //         'social_name' => 'Potato Girl Tapiocaria LTDA',
    //         'user_id' => 1,
    //         'username' => 'potatoGirlSeller'
    //     ];

    //     $this->post('/users/sellers', $sellerRequest)
    //         ->seeJson($sellerRequest);
    // }

    // public function testGetUsers()
    // {
    //     $this->get('/users?q=Potato')
    //         ->seeJson([ 
    //             'id' => 1 
    //         ]);
    // }

    // public function testGetUser()
    // {
    //     $user = [
    //         'accounts' => [
    //             'consumer' => null,
    //             'seller' => null
    //         ],
    //         'user' => [
    //             'cpf' => '10133111583',
    //             'email' => 'potatogirl2@gmail.com',
    //             'full_name' => 'Potato Girl',
    //             'id' => 1,
    //             'password' => '444555',
    //             'phone_number' => '27992215588'
    //         ]
    //     ];

    //     $this->get('/users/1')
    //         ->seeJson($user);
    // }
}
