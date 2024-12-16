<?php

namespace Services;

use App\Services\DistanceService;
use PHPUnit\Framework\TestCase;

class DistanceServiceTest extends TestCase
{
    private DistanceService $distanceService;
    private array $startLocation;
    private array $locations;
    private array $expectedDistances;
    private array $expectedRoute;

    protected function setUp(): void
    {
        parent::setUp();
        $this->distanceService = new DistanceService();

        $this->startLocation = ['latitude' => 41.015137, 'longitude' => 28.979530]; // İstanbul
        $this->locations = [
            ['id' => 1, 'latitude' => 40.712776, 'longitude' => -74.005974, 'name' => 'New York'],
            ['id' => 2, 'latitude' => 48.856613, 'longitude' => 2.352222, 'name' => 'Paris'],
            ['id' => 3, 'latitude' => 34.052235, 'longitude' => -118.243683, 'name' => 'Los Angeles']
        ];
        $this->expectedDistances = [8069.41, 2255.27, 11019.36];
        $this->expectedRoute = [2, 1, 3];
    }

    /**
     * @test
     */
    public function itCalculatesDistanceWithHaversineCorrectly()
    {
        // Arrange
        $lat1 = $this->startLocation['latitude']; // İstanbul
        $lon1 = $this->startLocation['longitude'];
        $lat2 = $this->locations[0]['latitude']; // New York
        $lon2 = $this->locations[0]['longitude'];

        // Act
        $distance = $this->distanceService->calculateDistanceWithHaversine(
            $lat1,
            $lon1,
            $lat2,
            $lon2
        );

        // Assert.
        $this->assertEqualsWithDelta(8069, $distance, 1, 'Distance calculation is not accurate');
    }

    /**
     * @test
     */
    public function itCalculatesLocationDistancesCorrectly()
    {
        // Act
        $distances = $this->distanceService->calculateLocationDistances(
            $this->startLocation['latitude'],
            $this->startLocation['longitude'],
            $this->locations
        );

        // Assert
        $this->assertCount(3, $distances);

        $this->assertArrayHasKey('distance', $distances[0]);
        $this->assertArrayHasKey('distance', $distances[1]);
        $this->assertArrayHasKey('distance', $distances[2]);

        foreach ($distances as $index => $distance) {
            $this->assertEqualsWithDelta($this->expectedDistances[$index], $distance['distance'], 1,
                "Distance to {$distance['name']} is incorrect");
        }
    }

    /**
     * @test
     */
    public function itFindsTheNearestLocationCorrectly()
    {
        // Act
        $nearestLocation = $this->distanceService->findNearestLocation(
            $this->startLocation['latitude'],
            $this->startLocation['longitude'],
            $this->locations
        );

        // Assert
        $this->assertNotNull($nearestLocation);
        $this->assertEquals($this->expectedRoute[0], $nearestLocation['id'], 'The nearest location is incorrect');
    }

    /**
     * @test
     */
    public function itGeneratesRouteFromNearestCorrectly()
    {
        // Act
        $route = $this->distanceService->generateRouteFromNearest(
            $this->startLocation['latitude'],
            $this->startLocation['longitude'],
            $this->locations
        );

        // Assert
        $this->assertCount(3, $route);

        $this->assertEquals($this->expectedRoute[0], $route[0]['id'], 'First location in the route is incorrect');
        $this->assertEquals($this->expectedRoute[1], $route[1]['id'], 'Second location in the route is incorrect');
        $this->assertEquals($this->expectedRoute[2], $route[2]['id'], 'Third location in the route is incorrect');
    }
}
