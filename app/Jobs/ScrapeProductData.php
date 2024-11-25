<?php

namespace App\Jobs;

use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
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
        public string $product_url_id
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

            //  Step 4 : Store product data in the post data table

        } catch(Exception $exception){
            Log::error('Failed to scrape data: '. $exception->getMessage());
        }
    }
}
