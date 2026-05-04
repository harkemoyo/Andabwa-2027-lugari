<?php

namespace App\Services;

use Agence104\LiveKit\AccessToken;
use Agence104\LiveKit\AccessTokenOptions;
use Agence104\LiveKit\VideoGrant;
use Exception;

class LiveKitService
{
    public function createToken($user, string $room, bool $isHost = false): string
    {
        $apiKey = config('services.livekit.key');
        $apiSecret = config('services.livekit.secret');

        // Add this safety check!
        if (empty($apiKey) || empty($apiSecret)) {
            throw new Exception('LiveKit API Key or Secret is missing. Check your .env and config/services.php files.');
        }

        $tokenOptions = (new AccessTokenOptions())
            ->setIdentity((string) $user->id)
            ->setName((string) $user->name)
            ->setTtl(3600); 

        $grant = (new VideoGrant())
            ->setRoomJoin(true)
            ->setRoomName($room) 
            ->setCanPublish($isHost)
            ->setCanSubscribe(true);

        $token = new AccessToken($apiKey, $apiSecret);
        
        return $token
            ->init($tokenOptions) 
            ->setGrant($grant)    
            ->toJwt();            
    }
}


// namespace App\Services;

// // use Livekit\AccessToken;
// use Agence104\LiveKit\AccessToken;

// class LiveKitService
// {
//     protected string $key;
//     protected string $secret;
//     protected string $url;

//     public function __construct()
//     {
//         $this->key = config('services.livekit.key');
//         $this->secret = config('services.livekit.secret');
//         $this->url = config('services.livekit.url');

//         // 🔒 HARD FAIL (Engineer-level guard)
//         if (!$this->key || !$this->secret) {
//             throw new \Exception('LiveKit credentials missing.');
//         }

//         if (strlen($this->secret) < 32) {
//             throw new \Exception('LiveKit secret too short (min 32 chars).');
//         }
//     }

//     public function token($user, string $room, bool $isHost = false): array
//     {
//         $token = new AccessToken($this->key, $this->secret);

//         $token->setIdentity("user_{$user->id}");
//         $token->setName($user->name ?? 'Guest');

//         $token->setVideoGrant([
//             'roomJoin' => true,
//             'room' => $room,
//             'canPublish' => $isHost,
//             'canSubscribe' => true,
//         ]);

//         return [
//             'token' => $token->toJwt(),
//             'url' => $this->url,
//         ];
//     }
// }