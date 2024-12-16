<?php

namespace Tests\Feature\GeoLocation;

use App\Models\GeoLocation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GeoLocationStoreTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a test user
        $this->user = User::factory()->create();
    }

    public function testStoreCreatesANewGeoLocation()
    {
        // Arrange
        $data = [
            'name' => 'Test Location',
            'latitude' => 40.7128,
            'longitude' => -74.0060,
            'marker_color' => '#FF0000',
        ];

        // Act
        $this->actingAs($this->user, 'sanctum');
        $response = $this->postJson(route('api.geo-location.store'), $data);

        // Assert
        $response->assertStatus(201);
        $this->assertDatabaseHas('geo_locations', array_merge($data, ['created_by' => $this->user->id]));
    }

    public function testStoreReturns422ForMissingNameField()
    {
        // Arrange
        $data = [
            'latitude' => 40.7128,
            'longitude' => -74.0060,
            'marker_color' => '#FF0000',
        ];

        // Act
        $this->actingAs($this->user, 'sanctum');
        $response = $this->postJson(route('api.geo-location.store'), $data);

        // Assert
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('name');
    }

    public function testStoreReturns422ForMissingLatitudeField()
    {
        // Arrange
        $data = [
            'name' => "Test Location",
            'longitude' => -74.0060,
            'marker_color' => '#FF0000',
        ];

        // Act
        $this->actingAs($this->user, 'sanctum');
        $response = $this->postJson(route('api.geo-location.store'), $data);

        // Assert
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('latitude');
    }

    public function testStoreReturns422ForMissingLongitudeField()
    {
        // Arrange
        $data = [
            'name' => "Test Location",
            'latitude' => 40.7128,
            'marker_color' => '#FF0000',
        ];

        // Act
        $this->actingAs($this->user, 'sanctum');
        $response = $this->postJson(route('api.geo-location.store'), $data);

        // Assert
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('longitude');
    }

    public function testStoreReturns422ForInvalidMarkerColor()
    {
        // Arrange
        $data = [
            'name' => 'Test Location',
            'latitude' => 40.7128,
            'longitude' => -74.0060,
            'marker_color' => 'invalid-color',
        ];

        // Act
        $this->actingAs($this->user, 'sanctum');
        $response = $this->postJson(route('api.geo-location.store'), $data);

        // Assert
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('marker_color');
    }

    public function testStoreReturns401ForUnauthorizedUser()
    {
        // Arrange
        $data = [
            'name' => 'Test Location',
            'latitude' => 40.7128,
            'longitude' => -74.0060,
            'marker_color' => '#FF0000',
        ];

        // Act
        $response = $this->postJson(route('api.geo-location.store'), $data);

        // Assert
        $response->assertStatus(401);
    }
}
