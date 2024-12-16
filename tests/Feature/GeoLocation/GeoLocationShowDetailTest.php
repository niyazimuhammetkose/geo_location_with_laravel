<?php

namespace Tests\Feature\GeoLocation;

use App\Models\GeoLocation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GeoLocationShowDetailTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a test user
        $this->user = User::factory()->create();
    }

    public function testShowReturnsGeoLocationForAuthorizedUser()
    {
        // Arrange
        $geoLocation = GeoLocation::factory()->create(['created_by' => $this->user->id]);

        // Act
        $this->actingAs($this->user, 'sanctum');
        $response = $this->getJson(route('api.geo-location.show', ['geoLocation' => $geoLocation->id]));

        // Assert
        $response->assertStatus(200);
        $response->assertJson([
            'id' => $geoLocation->id,
            'name' => $geoLocation->name,
            'latitude' => $geoLocation->latitude,
            'longitude' => $geoLocation->longitude,
            'marker_color' => $geoLocation->marker_color,
        ]);
    }

    public function testShowReturns404ForNonExistentGeoLocation()
    {
        // Act
        $this->actingAs($this->user, 'sanctum');
        $response = $this->getJson(route('api.geo-location.show', ['geoLocation' => 999999]));

        // Assert
        $response->assertStatus(404);
    }

    public function testShowReturns403ForUnauthorizedUser()
    {
        // Arrange
        $anotherUser = User::factory()->create();
        $geoLocation = GeoLocation::factory()->create(['created_by' => $anotherUser->id]);

        // Act
        $this->actingAs($this->user, 'sanctum');
        $response = $this->getJson(route('api.geo-location.show', ['geoLocation' => $geoLocation->id]));

        // Assert
        $response->assertStatus(403);
    }
}
