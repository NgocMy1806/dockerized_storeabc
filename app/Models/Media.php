<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    use HasFactory;
    protected $fillable = [
        'mediable_id',
        'mediable_type',
        'name',
        'type',
        'url',
    ];

    public function mediable()
    {
        return $this->morphTo();
    }

    // public function getUrlAttribute()
    // {
    //     if (env('APP_ENV') !== 'local') {
    //         if ($this->type == "product_image") {
    //             return Storage::temporaryUrl("images" . "/" . $this->attributes['name'], '+6000 minutes');
    //         } else {
    //             return Storage::temporaryUrl("thumbs" . "/" . $this->attributes['name'], '+6000 minutes');
    //         }
    //     } else {
    //         if ($this->type == "product_image") {
    //             return asset('storage/images/' . $this->attributes['name']);
    //         } else {
    //             return asset('storage/thumbs/' . $this->attributes['name']);
    //         }
    //     }
    // }
    
    public function getUrlAttribute()
{
    if (env('APP_ENV') !== 'local') {
        $cloudFrontDomain = env('CLOUDFRONT_DOMAIN');
        if ($this->type == "product_image") {
            return $cloudFrontDomain . "/images/" . $this->attributes['name'];
        } else {
            return $cloudFrontDomain . "/thumbs/" . $this->attributes['name'];
        }
    } else {
        if ($this->type == "product_image") {
            // return asset('storage/images/' . $this->attributes['name']);
            return asset('storage/images/' . $this->attributes['name']);
        } else {
            // return asset('storage/thumbs/' . $this->attributes['name']);
            return asset('storage/thumbs/' . $this->attributes['name']);
        }
    }
}

}
