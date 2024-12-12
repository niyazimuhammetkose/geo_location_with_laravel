<?php

namespace Tests\Feature\GeoLocation;

use App\Models\GeoLocation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GeoLocationCalculateRouteTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a test user
        $this->user = User::factory()->create();
    }

    public function test_calculate_route_returns_sorted_route()
    {
        // Arrange
        GeoLocation::factory(3)->create(['created_by' => $this->user->id]);
        GeoLocation::factory(5)->create();

        $data = ['latitude' => 40.73061, 'longitude' => -73.935242];

        // Act
        $this->actingAs($this->user, 'sanctum');
        $response = $this->postJson(route('api.geo-location.calculateRoute'), $data);

        // Assert
        $response->assertStatus(200);
        $this->assertCount(3, $response->json());
    }

    public function test_calculate_route_fails_with_missing_latitude()
    {
        // Arrange
        $data = ['longitude' => -73.935242];

        // Act
        $this->actingAs($this->user, 'sanctum');
        $response = $this->postJson(route('api.geo-location.calculateRoute'), $data);

        // Assert
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['latitude']);
    }

    public function test_calculate_route_fails_with_missing_longitude()
    {
        // Arrange
        $data = ['latitude' => 40.73061];

        // Act
        $this->actingAs($this->user, 'sanctum');
        $response = $this->postJson(route('api.geo-location.calculateRoute'), $data);

        // Assert
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['longitude']);
    }

    public function test_calculate_route_fails_with_invalid_latitude_format()
    {
        // Arrange
        $data = ['latitude' => 'invalid_latitude', 'longitude' => -73.935242];

        // Act
        $this->actingAs($this->user, 'sanctum');
        $response = $this->postJson(route('api.geo-location.calculateRoute'), $data);

        // Assert
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['latitude']);
    }

    public function test_calculate_route_fails_with_invalid_longitude_format()
    {
        // Arrange
        $data = ['latitude' => 40.73061, 'longitude' => 'invalid_longitude'];

        // Act
        $this->actingAs($this->user, 'sanctum');
        $response = $this->postJson(route('api.geo-location.calculateRoute'), $data);

        // Assert
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['longitude']);
    }

    public function test_calculate_route_fails_for_unauthenticated_user()
    {
        // Arrange
        $data = ['latitude' => 40.73061, 'longitude' => -73.935242];

        // Act
        $response = $this->postJson(route('api.geo-location.calculateRoute'), $data);

        // Assert
        $response->assertStatus(401);
    }

    public function test_calculate_route_fails_with_no_geo_locations()
    {
        // Arrange
        $data = ['latitude' => 40.73061, 'longitude' => -73.935242]; // Starting point

        // Act
        $this->actingAs($this->user, 'sanctum');
        $response = $this->postJson(route('api.geo-location.calculateRoute'), $data);

        // Assert
        $response->assertStatus(200);
        $this->assertEmpty($response->json());
    }

    public function test_calculate_route_ignores_geo_locations_not_belonging_to_user()
    {
        // Arrange
        GeoLocation::factory()->create(['created_by' => User::factory()->create()->id, 'latitude' => 40.73061, 'longitude' => -73.935242]);

        $data = ['latitude' => 40.73061, 'longitude' => -73.935242];

        // Act
        $this->actingAs($this->user, 'sanctum');
        $response = $this->postJson(route('api.geo-location.calculateRoute'), $data);

        // Assert
        $response->assertStatus(200);
        $this->assertEmpty($response->json());
    }

    public function test_calculate_route_handles_large_data_set()
    {
        // Arrange
        GeoLocation::factory()->count(1000)->create(['created_by' => $this->user->id]); // Büyük veri seti
        $data = ['latitude' => 40.73061, 'longitude' => -73.935242];

        // Act
        $this->actingAs($this->user, 'sanctum');
        $response = $this->postJson(route('api.geo-location.calculateRoute'), $data);

        // Assert
        $response->assertStatus(200);
        $this->assertCount(1000, $response->json());
    }
}
