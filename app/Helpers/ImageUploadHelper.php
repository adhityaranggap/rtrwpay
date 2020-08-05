<?php

namespace App\Helpers;

use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use File;

class ImageUploadHelper
{
    
    public static function ran()
    {
        $number = rand(100,10000);
        $t=time();
        return $number.''.$t;
    }    

    public static function pushStorage($dir, $size, $format, $image)
    {
        if (!File::isDirectory($dir)) {
            File::makeDirectory($dir, 0777, true, true);
        }
        
        $imageName    = $format.'_' . uniqid() . '.' . $image->getClientOriginalExtension();
        $image_resize = Image::make($image->getRealPath());
        $image_resize->resize($size, null, function ($constraint) {
            $constraint->aspectRatio();
        })->encode('png', 100);

        Storage::disk('public')->put($dir.$imageName, $image_resize);

        $nameFile = $dir . $imageName;   
        return $nameFile;
    }

}