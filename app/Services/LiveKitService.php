<?php

namespace App\Services;

use Agence104\LiveKit\AccessToken;
use Agence104\LiveKit\AccessTokenOptions;
use Agence104\LiveKit\VideoGrant;

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
    }

    public function generateToken($user, string $room, bool $isHost = false): array
    {
        $identity = $user
            ? (string) $user->id
            : 'guest_' . uniqid();

        $name = $user->name ?? 'Guest';

        $options = (new AccessTokenOptions())
            ->setIdentity($identity)
            ->setName($name)
            ->setTtl(3600);

        $grant = (new VideoGrant())
            ->setRoomJoin(true)
            ->setRoomName($room)
            ->setCanSubscribe(true);

        if ($isHost) {
            $grant->setCanPublish(true);
            $grant->setCanPublishData(true);
        } else {
            $grant->setCanPublish(false);
            $grant->setCanPublishData(false);
        }

        $token = new AccessToken(
            $this->apiKey,
            $this->apiSecret
        );

        $jwt = $token
            ->init($options)
            ->setGrant($grant)
            ->toJwt();

        return [
            'token' => $jwt,
            'url' => $this->url,
        ];
    }
}