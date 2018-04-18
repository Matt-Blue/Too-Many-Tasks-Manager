<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{

    /**
     * A functional database test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        //make sure that only the user that has been created exists in the database
        $this->assertDatabaseHas('users', [
            'email' => 'matthewbluestein88@gmail.com'
        ]);
        $this->assertDatabaseMissing('users', [
            'email' => 'wackemail@yahoo.com'
        ]);

        //CREATE

        //READ

        //UPDATE

        //REMOVE

    }
}
