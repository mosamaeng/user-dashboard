<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\User;
use Tests\TestCase;

class SearchTest extends TestCase
{
    // use RefreshDatabase;
    /**
     * A basic search.
     */
    public function test_search_functionality()
    {
        $result = User::updateorCreate([
            'name' => 'unique name',
            'occupation' => 'test occupation',
            'email' => 'user@testgmail.com',
            'password' => bcrypt('password')
        ]);

        // Make a GET request to your search endpoint
        $response = $this->get('/?search=unique');

        // Assert that the response has a successful status code
        $response->assertStatus(200);

        // Assert that the response contains the expected search result
        $response->assertSee($result->name);

        //Delete record
        $result->delete();
    }
}
