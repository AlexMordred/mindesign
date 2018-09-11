<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function most_popuplar_20_products_are_displayed_on_the_home_page()
    {
        // There are 30 offers (with 30 corresponding products)
        // Each offer has random number of sales, which determines product's
        // popularity
        $offers = factory('App\Offer', 30)->create();

        $actual = $this->getJson(route('home'))
            ->assertStatus(200)
            ->json();

        $expected = $offers->sortByDesc('sales')
            ->values()
            ->pluck('product_id')
            ->take(20)
            ->toArray();

        $actual = collect($actual)->pluck('id')->toArray();

        $this->assertEquals($expected, $actual);
    }

    /** @test */
    public function popularity_determined_as_a_sum_of_sales_of_all_the_products_offers()
    {
        // There is a product
        $product = factory('App\Product')->create();

        // Which has 2 offers
        $offers = factory('App\Offer', 2)->create([
            'product_id' => $product->id,
        ]);

        // The products popularity should be determined as the sum of the sales
        // of its offers
        $actual = $this->getJson(route('home'))
            ->assertStatus(200)
            ->json();

        $expected = $offers[0]['sales'] + $offers[1]['sales'];

        $this->assertEquals($expected, $actual[0]['popularity']);
    }
}
