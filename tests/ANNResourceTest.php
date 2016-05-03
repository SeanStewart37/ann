<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Class ANNResourceTests
 */
class ANNResourceTest extends TestCase
{
    /**
     * Test ANN Accuracy, insuring 100%
     */
    public function testGetAccuracy()
    {
        //Test to insure valid token
        $this->json('GET', '/ann/accuracy')
            ->seeJson(['error' => 'token_not_provided'])
            ->assertResponseStatus(400);

        //Tests accuracy is 100% & response structure
        $this->withoutMiddleware()
            ->json('GET', '/ann/accuracy')
            ->seeJson([
                'accuracy' => '100%'
            ])
            ->seeJson(['status' => 'success'])
            ->seeJsonStructure([
                'status' ,
                'data' => [
                    'accuracy',
                    'report'
                ]
            ])->assertResponseOk();
    }

    /**
     * Test POST Analyze Endpoint, including validation failures
     */
    public function testPostAnalyze()
    {
        //test success with correct params.
        $this->withoutMiddleware()
            ->json('POST', '/ann/analyze', ['gender' => 'female', 'age' => 2])
            ->seeJson([
                'status' => 'success'
            ]);

        //test failure with age > 12.
        $this->withoutMiddleware()
            ->json('POST', '/ann/analyze', ['gender' => 'female', 'age' => 13])
            ->seeJson([
                'status' => 'fail',
            ])
            ->seeJsonStructure(['status', 'data' => ['age']])
            ->assertResponseStatus(400);

        //test failure without gender param
        $this->withoutMiddleware()
            ->json('POST', '/ann/analyze', ['age' => 12])
            ->seeJson([
                'status' => 'fail',
            ])
            ->seeJsonStructure(['status', 'data' => ['gender']])
            ->assertResponseStatus(400);

        //test failure without age param.
        $this->withoutMiddleware()
            ->json('POST', '/ann/analyze', ['gender' => 'male'])
            ->seeJson([
                'status' => 'fail',
            ])
            ->seeJsonStructure(['status', 'data' => ['age']])
            ->assertResponseStatus(400);
    }
}