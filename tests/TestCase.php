<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase, WithFaker;


    /**
     * Set up the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Configurações específicas para testes
        $this->withoutExceptionHandling();
    }

    /**
     * Create and authenticate a user for testing.
     *
     * @param array $attributes
     * @return \App\Models\User
     */
    protected function actingAsUser(array $attributes = []): \App\Models\User
    {
        $user = \App\Models\User::factory()->create($attributes);
        $this->actingAs($user);
        return $user;
    }
}
