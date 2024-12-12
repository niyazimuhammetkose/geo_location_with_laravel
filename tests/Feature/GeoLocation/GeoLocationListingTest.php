<?php

namespace Tests\Feature\GeoLocation;

use App\Models\GeoLocation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GeoLocationListingTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a test user
        $this->user = User::factory()->create();
    }

    public function test_index_displays_user_geo_locations()
    {
        // Arrange
        GeoLocation::factory(10)->create(['created_by' => $this->user->id]);
        GeoLocation::factory(5)->create();

        // Act
        $this->actingAs($this->user, 'sanctum');
        $response = $this->getJson(route('api.geo-location.index'));

        // Assert
        $response->assertStatus(200);
        $response->assertJsonCount(10, 'data');
    }

    public function test_index_returns_empty_when_no_geo_locations()
    {
        // Arrange
        $this->actingAs($this->user, 'sanctum');

        // Act
        $response = $this->getJson(route('api.geo-location.index'));

        // Assert
        $response->assertStatus(200);
        $response->assertJsonCount(0, 'data');
    }

    public function test_index_requires_authentication()
    {
        // Act
        $response = $this->getJson(route('api.geo-location.index'));

        // Assert
        $response->assertStatus(401);
    }

    public function test_index_fails_on_post_request()
    {
        // Act
        $this->actingAs($this->user, 'sanctum');
        $response = $this->postJson(route('api.geo-location.index'));

        // Assert
        $response->assertStatus(405);
    }

    public function test_index_handles_large_number_of_records()
    {
        // Arrange
        GeoLocation::factory(1000)->create(['created_by' => $this->user->id]);

        // Act
        $this->actingAs($this->user, 'sanctum');
        $response = $this->getJson(route('api.geo-location.index') . '?perPage=1000');

        // Assert
        $response->assertStatus(200);
        $response->assertJsonCount(1000, 'data');
    }
}
