<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Helpers\CartHelper;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{

    use RefreshDatabase;

    /**
     * Dependencies
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
        //$this->manager = app('session');

        $this->request = $this->app['request'];
        $sessionProp = new \ReflectionProperty($this->request, 'session');
        $sessionProp->setAccessible(true);
        $sessionProp->setValue($this->request, $this->app['session']->driver('array'));
    }

    /**
     * A basic unit test example.
     *
     * @return void
     * @test
     */
    public function cartHelperCountMethodExpectedOne()
    {
        #$request = $this->app['request'];
        #$sessionProp = new \ReflectionProperty($request, 'session');
        #$sessionProp->setAccessible(true);
        #$sessionProp->setValue($request, $this->app['session']->driver('array'));

        // $controller = app(\App\Http\Controllers\Api\V1\CartController::class);
        $helper = app(\App\Helpers\CartHelper::class);

        $cart = [
            'products' => [
                [
                    "id" => 2,
                    "slug" => "nam",
                    "name" => "nam",
                    "description" => "In adipisci hic est iusto itaque vel. 
                        Et molestias voluptas et est. Est tempore magni rem.",
                    "price" => "38500",
                    "created_at" => "2021-10-12T10:11:53.000000Z",
                    "updated_at" => "2021-10-12T10:11:53.000000Z",
                    "amount" => 1,
                    "price_sum" => "38500",
                ],
            ]
        ];

        $this->request->session()->put('cart', $cart);
        $result = $helper->count($this->request);

        $this->assertEquals(1, $result, 'expect one product in this user session');
    }

    /**
     * A basic unit test example.
     *
     * @return void
     * @test
     */
    public function cartHelperClearMethodExpectedClearTheUserCartSession()
    {
        $helper = app(\App\Helpers\CartHelper::class);
        $cart = [
            'products' => [
                [
                    "id" => 2,
                    "slug" => "nam",
                    "name" => "nam",
                    "description" => "In adipisci hic est iusto itaque vel. 
                        Et molestias voluptas et est. Est tempore magni rem.",
                    "price" => "38500",
                    "created_at" => "2021-10-12T10:11:53.000000Z",
                    "updated_at" => "2021-10-12T10:11:53.000000Z",
                    "amount" => 1,
                    "price_sum" => "38500",
                ],
            ]
        ];

        $this->request->session()->put('cart', $cart);
        $before = $helper->count($this->request);
        $helper->clear($this->request);
        $after = $helper->count($this->request);
        $this->assertNotEquals($before, $after);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     * @test
     */
    public function cartHelperRemoveMethodExpectedDeletedCartItem()
    {
        $helper = app(\App\Helpers\CartHelper::class);
        $cart = [
            'products' => [
                [
                    "id" => 2,
                    "slug" => "nam",
                    "name" => "nam",
                    "description" => "In adipisci hic est iusto itaque vel. 
                        Et molestias voluptas et est. Est tempore magni rem.",
                    "price" => "38500",
                    "created_at" => "2021-10-12T10:11:53.000000Z",
                    "updated_at" => "2021-10-12T10:11:53.000000Z",
                    "amount" => 1,
                    "price_sum" => "38500",
                ],
            ]
        ];

        $this->request->session()->put('cart', $cart);
        $before = $helper->count();
        $helper->clear($this->request);
        $after = $helper->count();
        $this->assertNotEquals($before, $after);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     * @test
     */
    public function cartHelperGetMethod()
    {
        $helper = app(\App\Helpers\CartHelper::class);
        $cart = [
            'products' => [
                [
                    "id" => 2,
                    "slug" => "nam",
                    "name" => "nam",
                    "description" => "In adipisci hic est iusto itaque vel. 
                        Et molestias voluptas et est. Est tempore magni rem.",
                    "price" => "38500",
                    "created_at" => "2021-10-12T10:11:53.000000Z",
                    "updated_at" => "2021-10-12T10:11:53.000000Z",
                    "amount" => 1,
                    "price_sum" => "38500",
                ],
            ]
        ];
        // before
        $this->assertCount(0, $helper->get()['products']);
        // add product to cart
        $this->request->session()->put('cart', $cart);
        // after
        $this->assertCount(1, $helper->get()['products']);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     * @test
     */
    public function cartHelperRemoveMethod()
    {
        $helper = app(\App\Helpers\CartHelper::class);
        $cart = [
            'products' => [
                [
                    "id" => 2,
                    "slug" => "nam",
                    "name" => "nam",
                    "description" => "In adipisci hic est iusto itaque vel. 
                        Et molestias voluptas et est. Est tempore magni rem.",
                    "price" => "38500",
                    "created_at" => "2021-10-12T10:11:53.000000Z",
                    "updated_at" => "2021-10-12T10:11:53.000000Z",
                    "amount" => 1,
                    "price_sum" => "38500",
                ],
                [
                    "id" => 3,
                    "slug" => "nama",
                    "name" => "nama",
                    "description" => "In adipisci hic est iusto itaque vel. 
                        Et molestias voluptas et est. Est tempore magni rem.",
                    "price" => "38500",
                    "created_at" => "2021-10-12T10:11:53.000000Z",
                    "updated_at" => "2021-10-12T10:11:53.000000Z",
                    "amount" => 1,
                    "price_sum" => "38500",
                ],
            ]
        ];
        // before
        $this->assertCount(0, $helper->get()['products']);
        // add product to cart
        $this->request->session()->put('cart', $cart);
        // after
        $helper->remove(3);
        $this->assertCount(1, $helper->get()['products']);
    }

    /**
     * Increase Product by one
     *
     * @return void
     * @test
     */
    public function cartHelperAddMethod()
    {
        $helper = app(\App\Helpers\CartHelper::class);
        $cart = [
            'products' => [
                [
                    "id" => 2,
                    "slug" => "nam",
                    "name" => "nam",
                    "description" => "In adipisci hic est iusto itaque vel. 
                     Et molestias voluptas et est. Est tempore magni rem.",
                    "price" => "38500",
                    "created_at" => "2021-10-12T10:11:53.000000Z",
                    "updated_at" => "2021-10-12T10:11:53.000000Z",
                    "amount" => 1,
                    "price_sum" => "38500",
                ],
            ]
        ];

        $this->request->session()->put('cart', $cart);
        $this->assertEquals(1, $helper->get()['products'][0]['amount'], 'expect 1 amount');
        $helper->add(Product::find(2));
        $this->assertEquals(2, $helper->get()['products'][0]['amount'], 'expect 2 amount');
    }

    /**
     * Increase Product by one
     *
     * @return void
     * @test
     */
    public function cartHelperDecreaseMethod()
    {
        $helper = app(\App\Helpers\CartHelper::class);
        $cart = [
            'products' => [
                [
                    "id" => 2,
                    "slug" => "nam",
                    "name" => "nam",
                    "description" => "In adipisci hic est iusto itaque vel. 
                        Et molestias voluptas et est. Est tempore magni rem.",
                    "price" => "38500",
                    "created_at" => "2021-10-12T10:11:53.000000Z",
                    "updated_at" => "2021-10-12T10:11:53.000000Z",
                    "amount" => 2,
                    "price_sum" => "38500",
                ],
            ]
        ];

        $this->request->session()->put('cart', $cart);
        $this->assertEquals(2, $helper->get()['products'][0]['amount'], 'expect 2 amount');
        $helper->decrease(Product::find(2));
        $this->assertEquals(1, $helper->get()['products'][0]['amount'], 'expect 1 amount');
    }
}
