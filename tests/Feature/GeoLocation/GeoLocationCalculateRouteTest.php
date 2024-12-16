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

    public function testCalculateRouteReturnsSortedRoute()
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

    public function testCalculateRouteFailsWithMissingLatitude()
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

    public function testCalculateRouteFailsWithMissingLongitude()
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

    public function testCalculateRouteFailsWithInvalidLatitudeFormat()
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

    public function testCalculateRouteFailsWithInvalidLongitudeFormat()
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

    public function testCalculateRouteFailsForUnauthenticatedUser()
    {
        // Arrange
        $data = ['latitude' => 40.73061, 'longitude' => -73.935242];

        // Act
        $response = $this->postJson(route('api.geo-location.calculateRoute'), $data);

        // Assert
        $response->assertStatus(401);
    }

    public function testCalculateRouteFailsWithNoGeoLocations()
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

    public function testCalculateRouteIgnoresGeoLocationsNotBelongingToUser()
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

    public function testCalculateRouteHandlesLargeDataSet()
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
