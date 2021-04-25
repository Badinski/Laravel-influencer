<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\ImageUploadRequest;
use Illuminate\Support\Str;
class ImageController
{   
    /*if a user updates a product title, we don t want to upload the same image 
    as a new image. That s why we separate it in external controller*/
    public function upload(ImageUploadRequest $request)
    {
        $file = $request->file('image');
        $name = \Str::random(10);
        $url = \Storage::putFileAs('images', $file, $name . '.' . $file->extension());

        return [
            'url' => env('APP_URL') . '/' . $url,
        ];
    }
}
