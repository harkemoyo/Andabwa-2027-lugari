<?php

namespace App\Jobs;

use App\Models\GeneratedAsset;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Exception;
use GuzzleHttp\Client;

class GenerateImageEditJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public GeneratedAsset $asset;
    public string $originalPath; // storage path of uploaded image
    public array $options;

    public function __construct(GeneratedAsset $asset, string $originalPath, array $options = [])
    {
        $this->asset = $asset;
        $this->originalPath = $originalPath;
        $this->options = $options;
    }

    public function handle()
    {
        $this->asset->update(['status' => 'processing']);
        $disk = config('filesystems.default', 'public');

        try {
            // We'll call OpenAI's image edits endpoint via Guzzle multipart (safer for file uploads)
            $client = new Client([
                'base_uri' => env('OPENAI_API_BASE', 'https://api.openai.com/v1'),
                'timeout' => 120,
            ]);

            $model = $this->options['model'] ?? env('OPENAI_IMAGE_MODEL', 'gpt-image-1');
            $size = $this->options['size'] ?? env('AI_DEFAULT_SIZE', '1024x1024');
            $prompt = $this->asset->prompt;

            $localPath = Storage::disk($disk)->path($this->originalPath);
            if (! file_exists($localPath)) {
                throw new Exception('Original image not found: '.$localPath);
            }

            $multipart = [
                [
                    'name'     => 'model',
                    'contents' => $model,
                ],
                [
                    'name'     => 'prompt',
                    'contents' => $prompt,
                ],
                [
                    'name'     => 'size',
                    'contents' => $size,
                ],
                [
                    'name'     => 'image[]', // as file array
                    'contents' => fopen($localPath, 'r'),
                    'filename' => basename($localPath),
                ],
            ];

            $res = $client->request('POST', '/images/edits', [
                'headers' => [
                    'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
                ],
                'multipart' => $multipart,
            ]);

            $body = json_decode($res->getBody()->getContents(), true);

            $data = $body['data'][0] ?? null;
            if (! $data) throw new Exception('No data returned from image edits');

            // handle b64 or url
            if (isset($data['b64_json'])) {
                $binary = base64_decode($data['b64_json']);
                $ext = 'png';
                $filename = 'ai-images/'.now()->format('Y/m/d/').Str::random(16).'.'.$ext;
                Storage::disk($disk)->put($filename, $binary);
                $this->asset->update(['image_path'=>$filename,'status'=>'done','meta'=>$body]);
                return;
            }

            if (isset($data['url'])) {
                $contents = file_get_contents($data['url']);
                $ext = Str::contains($data['url'], '.png') ? 'png' : 'jpg';
                $filename = 'ai-images/'.now()->format('Y/m/d/').Str::random(16).'.'.$ext;
                Storage::disk($disk)->put($filename, $contents);
                $this->asset->update(['image_path'=>$filename,'status'=>'done','meta'=>$body]);
                return;
            }

            throw new Exception('Unexpected response from OpenAI image edits');
        } catch (Exception $e) {
            Log::error('GenerateImageEditJob error: '.$e->getMessage());
            $this->asset->update(['status'=>'failed','error'=>$e->getMessage()]);
            throw $e;
        }
    }
}
