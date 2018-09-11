<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SearchProductsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function users_can_search_for_products_by_title()
    {
        $word = 'qwerty';

        // A product to be found
        $product = factory('App\Product')->create([
            'title' => str_random(5) . $word . str_random(5)
        ]);
        
        // Some other product
        factory('App\Product')->create();

        $results = $this->getJson(route('products.search', $word))
            ->assertStatus(200)
            ->json()['products'];

        // Assert the correct product was returned
        $this->assertEquals(1, $results['total']);
        $this->assertCount(1, $results['data']);
        $this->assertEquals($product->id, $results['data'][0]['id']);
    }

    /** @test */
    public function users_can_search_for_products_by_description()
    {
        $word = 'qwerty';

        // A product to be found
        $product = factory('App\Product')->create([
            'description' => str_random(5) . $word . str_random(5)
        ]);

        // Some other product
        factory('App\Product')->create();

        $results = $this->getJson(route('products.search', $word))
            ->assertStatus(200)
            ->json()['products'];

        // Assert the correct product was returned
        $this->assertEquals(1, $results['total']);
        $this->assertCount(1, $results['data']);
        $this->assertEquals($product->id, $results['data'][0]['id']);
    }
}
