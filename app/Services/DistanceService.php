<?php

namespace App\Services;

class DistanceService
{
    private const EARTH_RADIUS_KM = 6371;

    /**
     * Haversine algoritmasını kullanarak iki koordinat arasındaki mesafeyi hesaplar.
     *
     * @param float $lat1 Başlangıç noktası enlemi
     * @param float $lon1 Başlangıç noktası boylamı
     * @param float $lat2 Bitiş noktası enlemi
     * @param float $lon2 Bitiş noktası boylamı
     * @return float Mesafe (kilometre cinsinden)
     */
    public function calculateDistanceWithHaversine(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $phi1 = deg2rad($lat1);
        $phi2 = deg2rad($lat2);
        $deltaPhi = deg2rad($lat2 - $lat1);
        $deltaLambda = deg2rad($lon2 - $lon1);

        $a = sin($deltaPhi / 2) ** 2 +
            cos($phi1) * cos($phi2) *
            sin($deltaLambda / 2) ** 2;

        return self::EARTH_RADIUS_KM * (2 * atan2(sqrt($a), sqrt(1 - $a)));
    }

    /**
     * En yakın lokasyondan başlayarak rota oluşturur.
     *
     * @param float $startLat Başlangıç noktası enlemi
     * @param float $startLon Başlangıç noktası boylamı
     * @param array $locations Lokasyonlar
     * @return array
     */
    public function generateRouteFromNearest(float $startLat, float $startLon, array $locations): array
    {
        if (empty($locations)) return [];

        $route = [];
        $remainingLocations = collect($locations)->keyBy('id');
        $currentLat = $startLat;
        $currentLon = $startLon;

        while ($remainingLocations->isNotEmpty()) {
            $nearestLocation = $this->findNearestLocation($currentLat, $currentLon, $remainingLocations->values()->toArray());

            if (is_null($nearestLocation)) break;

            $route[] = $nearestLocation;

            $currentLat = $nearestLocation['latitude'];
            $currentLon = $nearestLocation['longitude'];

            $remainingLocations->forget($nearestLocation['id']);
        }

        return $route;
    }

    /**
     * @param float $startLat Başlangıç noktası enlemi
     * @param float $startLon Başlangıç noktası boylamı
     * @param array $locations Lokasyonlar
     * @return array|null
     */
    public function findNearestLocation(float $startLat, float $startLon, array $locations): ?array
    {
        if (empty($locations)) return null;

        return collect($this->calculateLocationDistances($startLat, $startLon, $locations))
            ->sortBy('distance')
            ->first();
    }

    /**
     * @param float $startLat Başlangıç noktası enlemi
     * @param float $startLon Başlangıç noktası boylamı
     * @param array $locations Lokasyonlar
     * @return array
     */
    public function calculateLocationDistances(float $startLat, float $startLon, array $locations): array
    {
        return collect($locations)->map(function ($location) use ($startLat, $startLon) {
            $location['distance'] = $this->calculateDistanceWithHaversine(
                $startLat,
                $startLon,
                $location['latitude'],
                $location['longitude']
            );
            return $location;
        })->toArray();
    }
}
