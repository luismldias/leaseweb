<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiTest extends TestCase
{
    /**
     * Simpre response working test.
     */
    public function test_the_api_returns_a_successful_response(): void
    {
        $response = $this->get('/api/servers');

        $response->assertStatus(200);
    }


    /**
     * Basic api structure test
     */
    public function test_the_api_return_structure(): void
    {
        
        $expectedStructure = [
            'data',
            'pagination'
        ];

        $response      = $this->get('/api/servers');
        $data          = $response->getData();
        $responseArray = json_decode(json_encode($data),true);
        $responseKeys  = array_keys($responseArray);
        $this->assertEquals($expectedStructure, $responseKeys);

    }
}
