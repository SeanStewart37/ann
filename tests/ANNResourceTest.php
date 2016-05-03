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
     * Test Endpoint Status
     *
     * @return void
     */
    public function testGetAccuracy()
    {
       $this->withoutMiddleware()
           ->json('GET', '/ann/accuracy')
           ->seeJson([
               'status' => 'success'
           ]);

    }

    /**
     * Test Endpoint response structure
     */
    public function testGetAccuracyStructure()
    {
        $this->withoutMiddleware()
            ->json('GET', '/ann/accuracy')
            ->seeJsonStructure([
                'status' ,
                'data' => [
                    'accuracy',
                    'report'
                ]
            ]);
    }

    /**
     * Test ANN Accuracy, insuring 100%
     */
    public function testAccuracy()
    {
        $this->withoutMiddleware()
            ->json('GET', '/ann/accuracy')
            ->seeJson([
                    'accuracy' => '100%'
            ]);
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
            ->seeJsonStructure(['status', 'data' => ['age']]);

        //test failure without gender param
        $this->withoutMiddleware()
            ->json('POST', '/ann/analyze', ['age' => 12])
            ->seeJson([
                'status' => 'fail',
            ])
            ->seeJsonStructure(['status', 'data' => ['gender']]);;

        //test failure without age param.
        $this->withoutMiddleware()
            ->json('POST', '/ann/analyze', ['gender' => 'male'])
            ->seeJson([
                'status' => 'fail',
            ])
            ->seeJsonStructure(['status', 'data' => ['age']]);
    }
}