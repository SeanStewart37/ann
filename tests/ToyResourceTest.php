<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Class ToyResourceTest
 */
class ToyResourceTest extends TestCase
{

    public function testGetToys()
    {
        //Test to insure valid token
        $this->json('GET', '/toys')
            ->seeJson(['error' => 'token_not_provided'])
            ->assertResponseStatus(400);

        $this->withoutMiddleware()
            ->json('GET', '/toys')
            ->seeJson([
                'status' => 'success',
            ])
            ->seeJsonStructure(['status', 'data' => ['toys']])
            ->assertResponseOk();
    }

    public function testGetToy()
    {
        //Test to insure valid token
        $this->json('GET', '/toys/2')
            ->seeJson(['error' => 'token_not_provided'])
            ->assertResponseStatus(400);

        $this->withoutMiddleware()
            ->json('GET', '/toys/2')
            ->seeJson([
                'status' => 'success',
            ])
            ->seeJsonStructure(['status', 'data' => ['toy']])
            ->assertResponseOk();
    }



    public function testPutToy()
    {
        //Test to insure valid token
        $this->json('PUT', '/toys/2')
            ->seeJson(['error' => 'token_not_provided'])
            ->assertResponseStatus(400);

        //Test failure without required name parameter
        $this->withoutMiddleware()
            ->json('PUT', '/toys/2')
            ->seeJson([
                'status' => 'fail',
            ])
            ->seeJsonStructure(['status', 'data' => ['name']])
            ->assertResponseStatus(400);


        $this->withoutMiddleware()
            ->json('PUT', '/toys/2', ['name' => 'coloring book'])
            ->seeJson([
                'status' => 'success',
            ])
            ->seeJsonStructure(['status', 'data' => ['toy']])
            ->assertResponseOk();
    }

    public function testPostToy()
    {
        //Test to insure valid token
        $this->json('POST', '/toys')
            ->seeJson(['error' => 'token_not_provided'])
            ->assertResponseStatus(400);

        //Test failure without required name parameter
        $this->withoutMiddleware()
            ->json('POST', '/toys')
            ->seeJson([
                'status' => 'fail',
            ])
            ->seeJsonStructure(['status', 'data' => ['name']])
            ->assertResponseStatus(400);


        $this->withoutMiddleware()
            ->json('POST', '/toys', ['name' => 'coloring book'])
            ->seeJson([
                'status' => 'success',
            ])
            ->seeJsonStructure(['status', 'data' => ['toy']])
            ->assertResponseOk();
    }
}
