<?php

namespace Tests\Feature\GeoLocation;

use App\Models\GeoLocation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GeoLocationUpdateTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a test user
        $this->user = User::factory()->create();
    }

    public function testUpdateModifiesGeoLocation()
    {
        // Arrange
        $geoLocation = GeoLocation::factory()->create(['created_by' => $this->user->id]);
        $updateData = ['name' => 'Updated Location'];

        // Act
        $this->actingAs($this->user, 'sanctum');
        $response = $this->postJson(route('api.geo-location.update', ['geoLocation' => $geoLocation->id]), $updateData);

        // Assert
        $response->assertStatus(200);
        $this->assertDatabaseHas('geo_locations', array_merge($updateData, ['id' => $geoLocation->id]));
    }

    public function testUpdateReturns403ForUnauthorizedUser()
    {
        // Arrange
        $anotherUser = User::factory()->create();
        $geoLocation = GeoLocation::factory()->create(['created_by' => $this->user->id]);

        $updateData = ['name' => 'Updated Location'];

        // Act
        $this->actingAs($anotherUser, 'sanctum');
        $response = $this->postJson(route('api.geo-location.update', ['geoLocation' => $geoLocation->id]), $updateData);

        // Assert
        $response->assertStatus(403);
    }

    public function testUpdateReturns404ForNonExistingGeoLocation()
    {
        // Arrange
        $nonExistingId = 999999;  // Var olmayan bir id
        $updateData = ['name' => 'Updated Location'];

        // Act
        $this->actingAs($this->user, 'sanctum');
        $response = $this->postJson(route('api.geo-location.update', ['geoLocation' => $nonExistingId]), $updateData);

        // Assert
        $response->assertStatus(404);
    }

    public function testUpdateReturns422ForInvalidData()
    {
        // Arrange
        $geoLocation = GeoLocation::factory()->create(['created_by' => $this->user->id]);

        $updateData = ['name' => ''];

        // Act
        $this->actingAs($this->user, 'sanctum');
        $response = $this->postJson(route('api.geo-location.update', ['geoLocation' => $geoLocation->id]), $updateData);

        // Assert
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('name');
    }

    public function testUpdateReturns400ForMissingRequiredField()
    {
        // Arrange
        $geoLocation = GeoLocation::factory()->create(['created_by' => $this->user->id]);

        $updateData = [];

        // Act
        $this->actingAs($this->user, 'sanctum');
        $response = $this->postJson(route('api.geo-location.update', ['geoLocation' => $geoLocation->id]), $updateData);

        // Assert
        $response->assertStatus(400);
    }
}
