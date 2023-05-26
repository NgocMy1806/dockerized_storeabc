<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Media;
use App\Models\Tag;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Throwable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class TagService
{
    public function store($name){
        $tag=Tag::create([
            'name'=>$name,
            'slug'=>Str::slug($name)
        ]);

        return $tag;
    }
}
