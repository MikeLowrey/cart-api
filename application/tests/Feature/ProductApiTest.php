<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Response;

class ProductApiTest extends TestCase
{
    use RefreshDatabase;

    /** Dependencies */
    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
        $this->withHeaders([
            'Accept' => 'application/json',
            'X-Requested-With' => 'XMLHttpRequest'
        ]);
    }

    /**
     * feature test.
     *
     * @return void
     * @test
     */
    public function productGetAll()
    {
        $response = $this->get('/api/v1/products');
        $response->assertStatus(200);
    }

    /**
     * feature test.
     *
     * @return void
     * @test
     */
    public function productGetBySlugSuccesfully()
    {
        $response = $this->get('/api/v1/products/test');
        $response->assertStatus(200);
    }

    /**
     * feature test.
     *
     * @return void
     * @test
     */
    public function productGetBySlugFailed()
    {
        $response = $this->get('/api/v1/products/testFail');
        $response->assertStatus(404);
    }

    /**
     * feature test.
     *
     * @return void
     * @test
     */
    public function productStoreInDatabaseSuccessfully()
    {
        $productData = [
            'name' => 'New',
            'description' => 'New Description',
            'price' => 9995,
        ];

        $response = $this->post('/api/v1/products', $productData);
        $response->assertStatus(201);
    }

    /**
     * feature test.
     *
     * @return void
     * @test
     */
    public function productStoreInDatabaseFailed()
    {
        $productData = [
            'description' => 'New Description',
            'price' => 9995,
        ];

        $response = $this->post('/api/v1/products', $productData)->assertStatus(422);

        $this->assertArrayHasKey('errors', json_decode($response->getContent(), 1));

        $this->assertArrayHasKey('name', json_decode($response->getContent(), 1)['errors']);

        #$res = $this->followRedirects($response)->assertStatus(422);
        #$this->followRedirects($response)->assertSee('Ok!');
        #->assertResponseStatus(422);
        #$response = $this->post('/api/v1/products', $productData);
        #$response->dump();
        #$response->assertStatus(302);
    }

    /**
     * feature test.
     *
     * @return void
     * @test
     */
    public function productDeleteSuccessfully()
    {
        $response = $this->delete('/api/v1/products/test');
        $response->assertStatus(200);
    }

    /**
     * feature test.
     *
     * @return void
     * @test
     */
    public function productDeleteFailed()
    {
        $response = $this->delete('/api/v1/products/testFail');
        $response->assertStatus(404);
    }
}
