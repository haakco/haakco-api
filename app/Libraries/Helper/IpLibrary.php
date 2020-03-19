<?php

namespace App\Libraries\Helper;

class IpLibrary
{
    /**
     * @return string
     */
    public function getMyIp(): string
    {
        if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {
            $forwardedIpArray = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        } else {
            $forwardedIpArray = request()->ips();
        }

        $mainIp = request()->ip();

        if (array_key_exists(0, $forwardedIpArray) && !empty($forwardedIpArray[0])) {
            $mainIp = trim($forwardedIpArray[0]);
        }
//        Log::info(print_r($_SERVER, true));
//        Log::info(print_r(request()->server('HTTP_X_FORWARDED_FOR'), true));
//        Log::info(print_r(request()->server('HTTP_X_FORWARDED_FOR'), true));
//        Log::info(print_r($mainIp, true));
//        Log::info(print_r($_SERVER['HTTP_X_FORWARDED_FOR'], true));
//        Log::info(print_r(request()->ips(), true));
//        Log::info(print_r($forwardedIpArray, true));
//        Log::info(print_r($mainIp, true));
        return trim($mainIp);
    }

    /**
     * @param string $ipAddress
     *
     * @return bool
     */
    public function isIp(string $ipAddress): bool
    {
        return filter_var(
            $ipAddress,
            FILTER_VALIDATE_IP
        );
    }

    /**
     * @param $ipAddress
     *
     * @return bool
     */
    public function isIpV4(string $ipAddress): bool
    {
        return filter_var(
            $ipAddress,
            FILTER_VALIDATE_IP,
            FILTER_FLAG_IPV4
        );
    }

    /**
     * @param $ipAddress
     *
     * @return bool
     */
    public function isPublicIpV4(string $ipAddress): bool
    {
        return filter_var(
            $ipAddress,
            FILTER_VALIDATE_IP,
            FILTER_FLAG_IPV4 |
            FILTER_FLAG_NO_PRIV_RANGE |
            FILTER_FLAG_NO_RES_RANGE
        );
    }

    /**
     * @param string $ipAddress
     *
     * @return bool
     */
    public function isIpV6(string $ipAddress): bool
    {
        return filter_var(
            $ipAddress,
            FILTER_VALIDATE_IP,
            FILTER_FLAG_IPV6
        );
    }

    /**
     * @param string $ipAddress
     *
     * @return bool
     */
    public function isIpPublic(string $ipAddress): bool
    {
        return filter_var(
            $ipAddress,
            FILTER_VALIDATE_IP,
            FILTER_FLAG_NO_PRIV_RANGE |
            FILTER_FLAG_NO_RES_RANGE
        );
    }

    /**
     * @param null $ipAddress
     *
     * @return \Torann\GeoIP\GeoIP|\Torann\GeoIP\Location
     */
    public function getGeoIp($ipAddress = null)
    {
        if ($ipAddress === null) {
            $ipAddress = $this->getMyIp();
        }
        return geoip($ipAddress);
    }

    /**
     * @param null $ipAddress
     *
     * @return array|null
     */
    public function getGeoIpArray($ipAddress = null): ?array
    {
        return $this->getGeoIp($ipAddress)
            ->toArray();
    }
}
