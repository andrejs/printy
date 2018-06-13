<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;

/**
 * Class GeocoderService
 */
class GeocoderService
{
    const DEFAULT_COUNTRY = 'US';
    const DEFAULT_CACHE_TTL = 3600;

    /**
     * Try to resolve country code from client IP.
     *
     * Use caching with configurable ttl.
     *
     * @return string
     */
    public function resolveCountryCode()
    {
        $clientIp = config('custom.geocoder.emulate_client_ip') ?: Request::ip();
        $cacheKey = $this->buildCacheKey($clientIp);

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $countryCode = $this->getCountryCode(
            $this->geocode($clientIp),
            static::DEFAULT_COUNTRY
        );

        $ttl = config('custom.geocoder.cache_ttl', static::DEFAULT_CACHE_TTL);
        Cache::put($cacheKey, $countryCode, $ttl);

        return $countryCode;
    }

    /**
     * @param string $ip
     * @return string
     */
    protected function buildCacheKey($ip)
    {
        return 'client-country-' . $ip;
    }

    /**
     * Simple IP resolution via built-in php methods without using external libraries.
     *
     * No multiple adapter support, solely for resolving via specific service.
     *
     * @param string $ip
     * @return mixed
     */
    protected function geocode($ip)
    {
        $url = config('custom.geocoder.url') . '/' . $ip;

        return json_decode(file_get_contents($url), true);
    }

    /**
     * @param array $response
     * @param mixed|null $default
     * @return mixed|null
     */
    protected function getCountryCode($response, $default = null)
    {
        return !empty($response['countryCode']) ? $response['countryCode'] : $default;
    }
}
