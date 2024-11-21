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
use Mews\Purifier\Facades\Purifier;
use Spatie\Browsershot\Browsershot;

class ScrapeProductData implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public string $url,
        public string $post_url_id
    )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try{
            //  Step 1 : Get the HTML body from the url
            $htmlBody = Browsershot::url($this->url)->waitUntilNetworkIdle()->timeout(120)->bodyHtml();

            //  Step 2 : Clean the HTML using purifier
            $cleanedHtml = Purifier::clean($htmlBody);

            //  Step 3 : Extract product data using GPT

            //  Step 4 : Store product data in the post_data table

            //  Step 5 : Get the product image and store it in the default storage
            //$this->getOriginalProductImage($productImageUrl);

        } catch(Exception $exception){
            Log::error('Failed to scrape data: '. $exception->getMessage());
        }
    }

    /**
     * Get the original product image content from the url and store it in the default storage
     * @param string $productImageUrl
     * @return void
     */
    protected function getOriginalProductImage(string $productImageUrl): void
    {
        try{
            $response = Http::get($productImageUrl);

            if(!$response->successful()){
                throw new Exception('Failed to fetch image. HTTP status: ' . $response->status());
            }

            $imageContent = $response->body();

            $extension = pathinfo($productImageUrl, PATHINFO_EXTENSION) ?:  'png';
            $uuid = (string) Str::uuid();
            $filename = $uuid . '.' . $extension;

            $storagePath = 'products/original-photos/' . $filename;
            
            Storage::put($storagePath, $imageContent);

            $url = Storage::url($storagePath);

            $dbPostUrl = PostUrl::find($this->post_url_id);
            $dbPostUrl->productImages()->create([
                'image_path' => $url
            ]);

        } catch(Exception $exception){
            Log::error('Failed to get original product image'. $exception->getMessage());
        }
    }
}
