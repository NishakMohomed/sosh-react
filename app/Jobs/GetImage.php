<?php

namespace App\Jobs;

use App\Models\PostData;
use App\Models\ProductUrl;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class GetImage implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public string $product_url_id)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //  Step 1 : Get the post data from the post data table
        $dbPostData = ProductUrl::find($this->product_url_id)->postData;

        //  Step 2 : Loop through all the post data and get the original product images
        foreach($dbPostData as $data){
            $this->getOriginalProductImage($data);
        }
    }

    /**
     * Get the original product image content from the url and store it in the default storage
     * @param PostData $postData
     * @return void
     */
    protected function getOriginalProductImage(PostData $postData): void
    {
        try{
            $response = Http::get($postData->product_image_url);

            if(!$response->successful()){
                throw new Exception('Failed to fetch image. HTTP status: ' . $response->status());
            }

            $imageContent = $response->body();

            $extension = pathinfo($postData->product_image_url, PATHINFO_EXTENSION) ?:  'png';
            $uuid = (string) Str::uuid();
            $filename = $postData->id . $uuid . '.' . $extension;

            $storagePath = 'products/original-photos/' . $filename;
            
            Storage::put($storagePath, $imageContent);

            $url = Storage::url($storagePath);

            $postData->productImage()->create([
                'image_path' => $url
            ]);

        } catch(Exception $exception){
            Log::error('Failed to get original product image'. $exception->getMessage());
        }
    }
}
