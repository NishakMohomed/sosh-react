<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PostData extends Model
{
    use HasUuids;

    /**
    * The attributes that aren't mass assignable.
    *
    * @var array<string>|bool
    */
    protected $guarded = [];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'hash_tags' => 'array',
            'theme' => 'array',
        ];
    }

    /**
     * Get the product url that owns the post data.
     */
    public function productUrl(): BelongsTo
    {
        return $this->belongsTo(ProductUrl::class);
    }

    /**
     * Get the crafted post image associated with the post data.
     */
    public function postImage(): HasOne
    {
        return $this->hasOne(PostImage::class);
    }

    /**
     * Get the scraped product image associated with the post data.
     */
    public function productImage(): HasOne
    {
        return $this->hasOne(ProductImage::class);
    }

    /**
     * Get the background removed product image associated with the post data.
     */
    public function bgRemovedProductImage(): HasOne
    {
        return $this->hasOne(BgRemovedProductImage::class);
    }  
}
