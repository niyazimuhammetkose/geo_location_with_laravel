<?php

namespace Tests\Feature\GeoLocation;

use App\Models\GeoLocation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Tests\TestCase;

class GeoLocationDestroyTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a test user
        $this->user = User::factory()->create();
    }

    public function testDestroyRemovesGeoLocation()
    {
        // Arrange
        $geoLocation = GeoLocation::factory()->create(['created_by' => $this->user->id]);

        // Act
        $this->actingAs($this->user, 'sanctum');
        $response = $this->deleteJson(route('api.geo-location.destroy', ['geoLocation' => $geoLocation->id]));

        // Assert
        $response->assertStatus(204);
        $this->assertSoftDeleted($geoLocation);
    }

    public function testDestroyFailsForUnauthenticatedUser()
    {
        // Arrange
        $geoLocation = GeoLocation::factory()->create(['created_by' => $this->user->id]);

        // Act
        $response = $this->deleteJson(route('api.geo-location.destroy', ['geoLocation' => $geoLocation->id]));

        // Assert
        $response->assertStatus(401);
    }

    public function testDestroyFailsForGeoLocationNotBelongingToUser()
    {
        // Arrange
        $otherUser = User::factory()->create();
        $geoLocation = GeoLocation::factory()->create(['created_by' => $otherUser->id]);

        // Act
        $this->actingAs($this->user, 'sanctum');
        $response = $this->deleteJson(route('api.geo-location.destroy', ['geoLocation' => $geoLocation->id]));

        // Assert
        $response->assertStatus(403);
    }

    public function testDestroyFailsForNonexistentGeoLocation()
    {
        // Act
        $this->actingAs($this->user, 'sanctum');
        $response = $this->deleteJson(route('api.geo-location.destroy', ['geoLocation' => 9999]));

        // Assert
        $response->assertStatus(404);
    }

    public function testDestroyFailsForSoftDeletedGeoLocation()
    {
        // Arrange
        $geoLocation = GeoLocation::factory()->create(['created_by' => $this->user->id]);
        $geoLocation->delete();

        // Act
        $this->actingAs($this->user, 'sanctum');
        $response = $this->deleteJson(route('api.geo-location.destroy', ['geoLocation' => $geoLocation->id]));

        // Assert
        $response->assertStatus(404);
    }

    public function testDestroyHandlesLargeDataSet()
    {
        // Arrange
        $this->withoutMiddleware(ThrottleRequests::class);
        $geoLocations = GeoLocation::factory()->count(100)->create(['created_by' => $this->user->id]);

        // Act & Assert
        $this->actingAs($this->user, 'sanctum');
        foreach ($geoLocations as $geoLocation) {
            $response = $this->deleteJson(route('api.geo-location.destroy', ['geoLocation' => $geoLocation->id]));
            $response->assertStatus(204);
            $this->assertSoftDeleted($geoLocation);
        }
    }
}
