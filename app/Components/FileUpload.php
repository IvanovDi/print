<?php

namespace App\Components;

use Illuminate\Http\UploadedFile;
use League\Flysystem\Exception;

class FileUpload
{
    const CATEGORY = 1;
    const PRODUCT = 2;

    public function uploadFile($image, $type)
    {
        $config = \Config::get('uploadFile');
        switch ($type) {
            case self::CATEGORY:
                $path = $config['category']['savePath'];
                break;
            case self::PRODUCT:
                $path = $config['products']['savePath'];
                break;
            default:
                throw new Exception('Error for upload file!');
                break;
        }

        if ($image instanceof UploadedFile) {
            $imageName = str_random().$image->getClientOriginalName();
            $image->move($path, $imageName);
            return $imageName;
        }

        return false;
    }
}