<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class PostTemplate extends Model
{
    use HasUuids;

    /**
    * The attributes that aren't mass assignable.
    *
    * @var array<string>|bool
    */
    protected $guarded = [];
}
