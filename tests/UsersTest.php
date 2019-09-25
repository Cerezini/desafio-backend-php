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

    public function testCreateSeller()
    {
        $user = factory('App\Models\User')->create();

        $seller = factory('App\Models\Seller')
            ->make([
                'user_id' => $user->id
            ])
            ->toArray();

        $this->post('/users/sellers', $seller)
            ->seeJson($seller);
    }

    public function testGetUsers()
    {
        $usersMario = factory('App\Models\User', 3)->create([
            'full_name' => 'Mario da Silva Costa'
        ]);

        $usersPedro = factory('App\Models\User', 3)->create([
            'full_name' => 'Pedro Coelho Martins'
        ]);

        $consumer = factory('App\Models\Consumer')->create([
            'user_id' => $usersMario[0]->id,
            'username' => 'Ma1926684'
        ]);

        $seller = factory('App\Models\Seller')->create([
            'user_id' => $usersMario[1]->id,
            'username' => 'MaVendedor58'
        ]);

        $this->get('/users?q=Ma')
            ->seeJson([
                'id' => $seller->user_id    
            ]);
    }

    public function testGetUser()
    {
        $user = factory('App\Models\User')->create();

        $consumer = factory('App\Models\Consumer')->create([
            'user_id' => $user->id,
        ]);

        $seller = factory('App\Models\Seller')->create([
            'user_id' => $user->id,
        ]);

        $userResponse = [
            'accounts' => [
                'consumer' => $consumer->toArray(),
                'seller' => $seller->toArray()
            ],
            'user' => $user->toArray()
        ];

        $this->get('/users/' . $user->id)
            ->seeJson($userResponse);
    }
}
