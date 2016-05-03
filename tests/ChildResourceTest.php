<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/*
 *
 *
 */
class ChildResourceTest extends TestCase
{
    /**
     * Tests GET Children Endpoint
     *
     * @return void
     */
    public function testGetChildren()
    {
        //Test to insure valid token
        $this->json('GET', '/children')
            ->seeJson(['error' => 'token_not_provided'])
            ->assertResponseStatus(400);

        $this->withoutMiddleware()
            ->json('GET', '/children')
            ->seeJson([
                'status' => 'success',
            ])
            ->seeJsonStructure(['status', 'data' => ['children']])
            ->assertResponseOk();
    }


    /**
     * Test PUT Children endpoint
     */
    public function testPutChild()
    {
        //Test to insure valid token
        $this->json('PUT', '/children/2')
            ->seeJson(['error' => 'token_not_provided'])
            ->assertResponseStatus(400);

        //Test failure without required parameter
        $this->withoutMiddleware()
        ->json('PUT', '/children/2')
        ->seeJson([
            'status' => 'fail',
        ])
        ->seeJsonStructure(['status', 'data' => ['toy_id']])
        ->assertResponseStatus(400);

        //Test success update with toy_id param
        $this->withoutMiddleware()
            ->json('PUT', '/children/2', ['toy_id' => 1])
            ->seeJson([
                'status' => 'success',
            ])
            ->seeJsonStructure(['status', 'data' => ['child']])
            ->assertResponseOk();

    }
}
