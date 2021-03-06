<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use NohYooHan\Domain\User\User;
use Tests\TestCase;

/**
 * @property string authString
 */
class ProductTest extends TestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $user = factory(User::class)->create([
            'name' => 'Foo',
            'email' => 'foo@foo.com',
            'password' => bcrypt('password'),
        ]);

        $this->authString = base64_encode("{$user->email}:password");

    }

    /** @test */
    public function can_create_product()
    {
        $this->post('api/products', [
            'name' => 'title',
            'description' => 'description',
            'price' => 1000,
            'stock' => 10,
        ], ['Authorization' => 'Basic ' . $this->authString])
        ->assertStatus(200);
    }

    /** @test */
    public function cannot_create_product_when_request_is_invalid()
    {
        $this->post('api/products', [
            'name' => 'title',
            'description' => 'description',
        ], ['Authorization' => 'Basic ' . $this->authString])
            ->assertStatus(422);
    }
}
