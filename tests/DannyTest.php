<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class DannyTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test()
    {
        $this->get('/');

//        $this->assertEquals(
//            $this->app->version(), $this->response->getContent()
//        );
        $this->assertEquals(
            $this->app->version(), 'Lumen (5.8.12) (Laravel Components 5.8.*)'
        );
    }
}
