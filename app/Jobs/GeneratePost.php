<?php

namespace App\Jobs;

use Exception;
use Illuminate\Support\Str;
use App\Models\PostData;
use App\Models\PostTemplate;
use App\Models\ProductUrl;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Spatie\Browsershot\Browsershot;

class GeneratePost implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public string $product_url_id, public string $post_template_id)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        
        try{
            //  Step 1 : Get all the post data associated with the post url id
            $dbPostData = ProductUrl::with('postData.bgRemovedProductImage')->find($this->product_url_id)->postData;
            
            //  Step 2 : Get the user selected post template
            $postTemplate = PostTemplate::find($this->post_template_id);

            //  Step 3 : Generate post data for each post data
            foreach($dbPostData as $data){
                $this->generatePost($data, $postTemplate);
            }

        } catch(Exception $exception){
            Log::error('Failed to generate post: ' . $exception->getMessage());
        }
    }

    /**
     * Generate post image using the post data
     * @param PostData $postData
     * @param PostTemplate $postTemplate
     * @return void
     */
    protected function generatePost(PostData $postData, PostTemplate $postTemplate): void
    {
        $data = [
            'heading' => $postData->heading,
            'subtitle' => $postData->subtitle,
            'content' => $postData->content,
            //hashtags
            'product_image_path' => $postData->bgRemovedProductImage->image_path,
            'background_image_description' => $postData->background_image_description,
            'heading_position' => $postData->heading_position,
            'subtitle_position' => $postData->subtitle_position,
            //theme
            'content_position' => $postData->content_position,
        ];

        //  Replace the actual data with the template placeholders
        $htmlTemplate = $this->replacePlaceholders($postTemplate->html, $data);

        //  Load the html into the puppeteer using Browsershot and take a full page screenshot
        $postImage = Browsershot::html($htmlTemplate)->fullPage()->screenshot();

        //  Save the image into default storage
        $extension = 'png';
        $uuid = (string) Str::uuid();
        $filename = $postData->id . $uuid . '.' . $extension;

        $storagePath = 'products/post-images/' . $filename;
            
        Storage::put($storagePath, $postImage);

        $url = Storage::url($storagePath);

        $postData->postImage()->create([
            'image_path' => $url
        ]);
        
    }

    /**
     * Replace placeholders in the template
     * @param string $template
     * @param array $postData
     * @return string
     */
    protected function replacePlaceholders(string $template, array $postData): string
    {
        foreach($postData as $key => $value ){
            $template = str_replace('{{'.$key.'}}', $value, $template);
        }

        return $template;
    }
}
