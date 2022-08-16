<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CloudinaryStorage extends Controller
{
    private const folder_path = 'gambars';

    public static function path($path){
        return pathinfo($path, PATHINFO_FILENAME);
    }

    public static function upload($gambar, $filename){
        $newFilename = str_replace(' ', '_', $filename);
        $public_id = date('Y-m-d_His').'_'.$newFilename;
        $result = cloudinary()->upload($gambar, [
            "public_id" => self::path($public_id),
            "folder"    => self::folder_path
        ])->getSecurePath();

        return $result;
    }

    public static function replace($path, $gambar, $public_id){
        self::delete($path);
        return self::upload($gambar, $public_id);
    }

    public static function delete($path){
        $public_id = self::folder_path.'/'.self::path($path);
        return cloudinary()->destroy($public_id);
    }
}
