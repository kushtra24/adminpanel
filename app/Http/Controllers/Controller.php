<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;
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

    /**
     * Parse given string to array by (optional) delimiter
     *
     * @param $string
     * @param string $delimiter
     * @param bool $removeEmptyEntries
     * @param bool $trimEntries
     * @return array|null
     */
    public static function stringToArray($string, $delimiter = ',', $removeEmptyEntries = true, $trimEntries = true) {
        if(!is_null($string) && gettype($string) === 'string') {
            // get array
            $array = explode($delimiter, $string);
            // trim entries
            if($trimEntries) {
                $array = array_map('trim', $array);
            }
            // remove empty entries
            if($removeEmptyEntries) {
                $array = array_filter($array, 'strlen');
            }
            return $array;
        }
        return null;
    }

    protected function executeQuery(&$query = null, $page = null, $limit = null, $orderByArr = null, $orderType = 'asc') {
        $result = null;
        if(!isset($query)) { return $result; }

//        Log::info('HERE: ' . var_export($query, true));

        // order by array
        if(is_countable($orderByArr) && count($orderByArr) > 0) {
            // check sort ranking
            if(!isset($orderType) || $orderType !== 'desc' && $orderType !== 'asc') {
                $orderType = 'asc';
            }

            // create order by
            for($i = 0, $max = count($orderByArr); $i < $max; $i++) {
                $attr = $orderByArr[$i];
                if(!isset($attr)) { continue; }
                $query = $query->orderBy($attr, $orderType);
            }
        }

        // check for pagination
        if(isset($page) && $page > 0) {
            // check limit
            if(!isset($limit) || $limit <= 0) { $limit = 8; }
            // execute
             $result = $query->paginate($limit);
        } else {
            // check for limit
            if(isset($limit) && $limit > 0) {
                $query = $query->limit($limit);
            }
            $result = $query->get();
//            $result = $query->paginate($limit); // laravel doing pagination (slow)

        }

        return $result;
    }
}
