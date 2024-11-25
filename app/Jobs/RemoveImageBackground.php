<?php

namespace App\Jobs;

use App\Models\ProductImage;
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
    public function __construct(public string $product_url_id)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try{
            //  Step 1 : Get all the product images associated with the product url id
            $dbProductImage = ProductImage::whereHas('postData', function($query){
                $query->where('product_url_id', $this->product_url_id);
            })->get();

            //  Step 2 : Loop the original image path and remove the bg and store the bg removed image
            //           back into the storage and insert image path into the table
            foreach($dbProductImage as $image){
                $this->removeImageBackground($image);
            }

        } catch(Exception $exception){
            Log::error('Failed to remove image background: ' . $exception->getMessage());
        }
    }

    /**
     * Remove image background using photoroom API
     * @param ProductImage $image
     * @return void
     */
    protected function removeImageBackground(ProductImage $image): void
    {
        try{
            $response = Http::withHeaders([
                'X-Api-Key' => env('PHOTOROOM_API_KEY')
            ])->attach('image_file', file_get_contents($image->image_path), basename($image->image_path))
            ->post('https://sdk.photoroom.com/v1/segment');

            if(!$response->successful()){
                throw new Exception('Failed to remove image background. HTTP status: ' . $response->status());
            }

            $imageContent = $response->body();

            $extension = 'png';
            $uuid = (string) Str::uuid();
            $filename = $image->id . $uuid . '.' . $extension;

            $storagePath = 'products/background-removed-photos/' . $filename;
            
            Storage::put($storagePath, $imageContent);

            $url = Storage::url($storagePath);

            //  Find the inverse of ProductImage table
            $dbPostData = $image->postData;

            $dbPostData->bgRemovedProductImage()->create([
                'image_path' => $url
            ]);

        } catch(Exception $exception){
            Log::error('Photoroom API error: ' . $exception->getMessage());
        }
    }
}
