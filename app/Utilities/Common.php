<?php
namespace App\Utilities;

use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class Common 
{
   public static function uploadFile($file, $path)
    {
        $extension = $file->getClientOriginalExtension();
        $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $filename = Str::slug($name) . '_' . now()->format('ymd_His') . '.' . $extension;

        $destination = public_path($path);

        if (!is_dir($destination)) {
            mkdir($destination, 0777, true);
        }

        $file->move($destination, $filename);

        return $filename;
    }
}