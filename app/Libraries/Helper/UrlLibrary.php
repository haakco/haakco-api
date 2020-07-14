<?php

namespace App\Libraries\Helper;

use App\Models\AgentString;
use App\Models\ShortUrl;
use App\Models\ShortUrlTracking;
use App\Models\ShortUrlTrackingExtra;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Irazasyed\LaravelGAMP\Facades\GAMP;

class UrlLibrary
{
    private $minNumberCharacters = 5;

    /**
     * @param string $fullUrl
     *
     * @return ShortUrl
     */
    public function shortenUrl(string $fullUrl): ShortUrl
    {
        /** @var ShortUrl $shortUrl */
        $shortUrl = ShortUrl::create(
            [
                'full_url' => $fullUrl,
            ]
        );

        return $this->findShortestCodeFromUUid($shortUrl);
    }

    // Doing quick and dirty unoptimised. Can be made faster in the future
    public function findShortestCodeFromUUid(ShortUrl $shortUrl): ?ShortUrl
    {
        $uuidLen = ($shortUrl->uuid);
        for ($i = $this->minNumberCharacters; $i <= $uuidLen; $i++) {
            $codeToTest = substr($shortUrl->uuid, 0, $i);
            if (
                ShortUrl::query()
                ->where('code', $codeToTest)
                ->exists()
            ) {
                $shortUrl->code = $codeToTest;
                $shortUrl->short_url = config('haakco.short_url') . '/' . $codeToTest;
                $shortUrl->save();
                break;
            }
        }
        return $shortUrl;
    }

    /**
     * @param $uuid
     *
     * @return string
     */
    public function fullUrl($uuid): string
    {
        $forwardedFor = request()->server('HTTP_X_FORWARDED_FOR') ?? '';

        $ipLibrary = new IpLibrary();
        $mainIp = $ipLibrary->getMyIp();

        $originalIp = request()->ip();

        $allIpArray = request()->ips();
        $userAgent = request()->userAgent();

        $shortUrl = ShortUrl::where('uuid', $uuid)
            ->first();

        if ($shortUrl) {
            $newSessionHeader = new SessionHeaderLibrary();

            if ($mainIp !== $originalIp) {
                $allIpArray[] = $originalIp;
            }

            $agentString = AgentString::query()
                ->where('name', $userAgent)
                ->first();

            if (!($agentString instanceof AgentString)) {
                $agentString = new AgentString();
                $agentString->name = $userAgent;
                $agentString->save();
            }

            $shortUrlTracking = ShortUrlTracking::create(
                [
                    'short_url_id' => $shortUrl->id,
                    'agent_string_id' => $agentString->id,
                    'ip' => $mainIp,
                    'corrected' => 1,
                    'proxy_ip' => $originalIp,
                ]
            );

            $shortUrlTrackingExtra = new ShortUrlTrackingExtra();
            $shortUrlTrackingExtra->short_url_tracking_id = $shortUrlTracking->id;
            $shortUrlTrackingExtra->data_json = [
                'forwarded_for' => $forwardedFor,
                'ip' => $mainIp,
                'ips' => implode(',', $allIpArray),
                'user_agent' => $userAgent,
                'server' => $newSessionHeader->getSafeSessionHeaders(),
            ];
            $shortUrlTrackingExtra->save();

            $user = Auth::user();

            $clientId = $user ? $user->getId() : Session::getId();

            $gamp = GAMP::setClientId($clientId);

            $gamp
                ->setIpOverride($forwardedFor)
                ->setUserAgentOverride($userAgent)
                ->setDocumentPath('/' . $uuid)
                ->setDocumentLocationUrl($shortUrl->short_url)
                ->setLinkId($shortUrlTracking->id)
                ->setCustomDimension('redirect', 1)
                ->setCustomDimension($shortUrl->full_url, 2)
                ->setCustomDimension($shortUrl->short_url, 3)
                ->sendPageview();


            if ($user instanceof User) {
                $gamp->setUserId($user->id);
            }

            Log::info(
                'Track short URL redirect',
                [
                    'short_url_id' => $shortUrl->id,
                    'ip' => $mainIp,
                ]
            );

            return $shortUrl->full_url;
        }
        return '/';
    }
}
