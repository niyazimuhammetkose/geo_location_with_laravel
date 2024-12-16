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

    public function testIndexDisplaysUserGeoLocations()
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

    public function testIndexReturnsEmptyWhenNoGeoLocations()
    {
        // Arrange
        $this->actingAs($this->user, 'sanctum');

        // Act
        $response = $this->getJson(route('api.geo-location.index'));

        // Assert
        $response->assertStatus(200);
        $response->assertJsonCount(0, 'data');
    }

    public function testIndexRequiresAuthentication()
    {
        // Act
        $response = $this->getJson(route('api.geo-location.index'));

        // Assert
        $response->assertStatus(401);
    }

    public function testIndexFailsOnPostRequest()
    {
        // Act
        $this->actingAs($this->user, 'sanctum');
        $response = $this->postJson(route('api.geo-location.index'));

        // Assert
        $response->assertStatus(405);
    }

    public function testIndexHandlesLargeNumberOfRecords()
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
