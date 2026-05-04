<?php

namespace App\Services;

use Agence104\LiveKit\AccessToken;
use Agence104\LiveKit\AccessTokenOptions;
use Agence104\LiveKit\VideoGrant;
use Exception;

class LiveKitService
{
    protected string $apiKey;
    protected string $apiSecret;
    protected string $url;

    public function __construct()
    {
        $this->apiKey = config('services.livekit.key');
        $this->apiSecret = config('services.livekit.secret');
        $this->url = config('services.livekit.url');

        // 🔒 Hard validation (production safe)
        if (empty($this->apiKey) || empty($this->apiSecret)) {
            throw new Exception('LiveKit API credentials missing. Check config/services.php and .env');
        }

        if (strlen($this->apiSecret) < 32) {
            throw new Exception('LiveKit API secret must be at least 32 characters.');
        }
    }

    /**
     * Generate a LiveKit access token
     */
    public function generateToken($user, string $room, bool $isHost = false): array
    {
        // ✅ Ensure user has identity
        $identity = (string) ($user->id ?? uniqid('guest_'));

        $name = $user->name ?? 'Guest';

        // ✅ Token options (THIS is how identity is set in your SDK)
        $options = (new AccessTokenOptions())
            ->setIdentity($identity)
            ->setName($name)
            ->setTtl(3600); // 1 hour

        // ✅ Video grant (MUST match vendor methods)
        $grant = (new VideoGrant())
            ->setRoomJoin(true)
            ->setRoomName($room) // IMPORTANT: your SDK uses setRoomName()
            ->setCanPublish($isHost)
            ->setCanSubscribe(true);

        // Optional advanced permissions
        if ($isHost) {
            $grant->setCanPublishData(true);
        }

        // ✅ Build token
        $token = new AccessToken($this->apiKey, $this->apiSecret);

        $jwt = $token
            ->init($options)   // sets identity, ttl, name
            ->setGrant($grant) // attaches permissions
            ->toJwt();

        return [
            'token' => $jwt,
            'url' => $this->url,
            'identity' => $identity,
            'name' => $name,
            'room' => $room,
            'isHost' => $isHost,
        ];
    }

    /**
     * Validate / decode token (useful for debugging)
     */
    public function decodeToken(string $jwt)
    {
        $token = new AccessToken($this->apiKey, $this->apiSecret);
        return $token->fromJwt($jwt);
    }
}