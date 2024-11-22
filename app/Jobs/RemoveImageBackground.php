<?php

namespace App\Jobs;

use App\Models\PostUrl;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class RemoveImageBackground implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public string $post_url_id)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try{
            //  Step 1 : Get all original product images associated with the post url id
            $dbPostUrl = PostUrl::find($this->post_url_id);

            //  Step 2 : Loop the original image path and remove the bg and store the bg removed image
            //           back into the storage and insert image path into the table
            foreach($dbPostUrl->productImages as $originalImage){
                $this->removeImageBackground($originalImage->image_path);
            }

        } catch(Exception $exception){
            Log::error('Failed to remove image background: ' . $exception->getMessage());
        }
    }

    /**
     * Remove image background using photoroom API
     * @param string $image_path
     * @return void
     */
    protected function removeImageBackground(string $image_path): void
    {
        try{
            $response = Http::withHeaders([
                'X-Api-Key' => env('PHOTOROOM_API_KEY')
            ])->attach('image_file', file_get_contents($image_path), basename($image_path))
            ->post('https://sdk.photoroom.com/v1/segment');

            if(!$response->successful()){
                throw new Exception('Failed to remove image background. HTTP status: ' . $response->status());
            }

            $imageContent = $response->body();

            $extension = 'png';
            $uuid = (string) Str::uuid();
            $filename = $uuid . '.' . $extension;

            $storagePath = 'products/background-removed-photos/' . $filename;
            
            Storage::put($storagePath, $imageContent);

            $url = Storage::url($storagePath);

            $dbPostUrl = PostUrl::find($this->post_url_id);

            $dbPostUrl->bgRemovedProductImages()->create([
                'image_path' => $url
            ]);

        } catch(Exception $exception){
            Log::error('Photoroom API error: ' . $exception->getMessage());
        }
    }
}
