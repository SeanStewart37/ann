<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserResourceTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testGetMe()
    {
        $user = factory(App\User::class)->create();

        $this->withoutMiddleware()
            ->actingAs($user)
            ->json('GET', '/users/me')
            ->seeJson([
                'status' => 'success',
            ]);
    }
}
