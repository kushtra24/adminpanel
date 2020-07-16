<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * update base64 photos and store them
     * @param $request
     * @param $requestedPhoto
     */
    public function updatePhoto(&$request, $requestedPhoto, $storagePath, $currentPhoto = '') {
        $image_64 = $requestedPhoto;  // your base64 encoded
        $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf
        $replace = substr($image_64, 0, strpos($image_64, ',') + 1);
        // find substring fro replace here eg: data:image/png;base64,
        $image = str_replace($replace, '', $image_64);
        $image = str_replace(' ', '+', $image);
        $imageName = Str::random(10) . '.' . $extension;
        Storage::disk($storagePath)->put($imageName, base64_decode($image));
        $request->merge(['photo' => $imageName]);
        // delete the old photo from the storage
        $currentDBPhoto = storage_path('app/public/' . $storagePath . "/").$currentPhoto;
        if (file_exists($currentDBPhoto)) {
            @unlink($currentDBPhoto);
        }
    }
}
