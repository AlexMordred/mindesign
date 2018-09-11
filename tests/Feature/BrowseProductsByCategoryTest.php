<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BrowseProductsByCategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function users_can_browse_products_by_category()
    {
        // There are 2 categories
        $categories = factory('App\Category', 2)->create();

        // Each category has 20 products in it
        $productsA = factory('App\Product', 20)->create();
        $categories[0]->products()->attach($productsA->pluck('id')->toArray());

        $productsB = factory('App\Product', 20)->create();
        $categories[1]->products()->attach($productsA->pluck('id')->toArray());

        // When we get products for the first category
        $actual = $this->getJson(route('products', $categories[0]->alias))
            ->assertStatus(200)
            ->json()['products'];

        // Assert pagination works
        $this->assertEquals(count($productsA), $actual['total']);
        $this->assertCount(10, $actual['data']);

        // We should only see the appropriate products
        $actual = collect($actual['data'])->pluck('id')->toArray();
        $expected = $productsA->pluck('id')->take(10)->toArray();

        $this->assertEquals($expected, $actual);
    }
}
