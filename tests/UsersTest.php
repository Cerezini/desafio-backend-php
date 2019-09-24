<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class UsersTest extends TestCase
{
    public function testCreateUser()
    {
        $userRequest = [
            'cpf' => '10133111583',
            'email' => 'potatogirl2@gmail.com',
            'full_name' => 'Potato Girl',
            'password' => '444555',
            'phone_number' => '27992215588'
        ];

        $this->post('/users', $userRequest)
            ->seeJson($userRequest);
    }

    public function testCreateConsumer()
    {
        $consumerRequest = [
            'user_id' => 4,
            'username' => 'potatoGirlConsumer',
        ];

        $this->post('/users/consumers', $consumerRequest)
            ->seeJson($consumerRequest);
    }

    public function testCreateSeller()
    {
        $sellerRequest = [
            'cnpj' => '11111111558524',
            'fantasy_name' => 'Potato Girl Tapiocaria',
            'social_name' => 'Potato Girl Tapiocaria LTDA',
            'user_id' => 4,
            'username' => 'potatoGirlSeller'
        ];

        $this->post('/users/sellers', $sellerRequest)
            ->seeJson($sellerRequest);
    }

    public function testGetUsers()
    {
        $this->get('/users?q=Claudia')
            ->seeJson([ 
                'id' => 1 
            ]);
    }

    public function testGetUser()
    {
        $user = [
            'accounts' => [
                'consumer' => null,
                'seller' => null
            ],
            'user' => [
                'cpf' => '10133111583',
                'email' => 'potatogirl2@gmail.com',
                'full_name' => 'Potato Girl',
                'id' => 6,
                'password' => '444555',
                'phone_number' => '27992215588'
            ]
        ];

        $this->get('/users/6')
            ->seeJson($user);
    }
}
