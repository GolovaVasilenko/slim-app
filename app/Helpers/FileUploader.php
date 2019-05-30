<?php

namespace app\Helpers;

use Intervention\Image\ImageManager;
use Slim\Http\UploadedFile;

class FileUploader extends ImageManager
{

    private $uploadDir = '/uploads/';

    /**
     * FileUploader constructor.
     * @param array $config
     */
    public function __construct(array $config = ['driver' => 'gd'])
    {
        parent::__construct($config);
    }

    /**
     * @return string
     */
    public function getUploadDir()
    {
        return $this->uploadDir;
    }

    /**
     * @param UploadedFile $file
     * @param $dir
     * @return string
     * @throws \Exception
     */
    public function saveImage(UploadedFile $file, $dir)
    {
        $image = $this->make($file->file);

        $extension = pathinfo($file->getClientFilename(), PATHINFO_EXTENSION);
        $basename = bin2hex(random_bytes(8)); // see http://php.net/manual/en/function.random-bytes.php
        $fileName = sprintf('%s.%0.8s', $basename, $extension);

        $image->save($dir . '/' . $fileName);
        return $fileName;
    }

    /**
     * @param UploadedFile $file
     * @param $dir
     * @return string
     * @throws \Exception
     */
    public function saveAvatar(UploadedFile $file, $dir)
    {
        $image = $this->make($file->file);

        $extension = pathinfo($file->getClientFilename(), PATHINFO_EXTENSION);
        $basename = bin2hex(random_bytes(8)); // see http://php.net/manual/en/function.random-bytes.php
        $fileName = sprintf('%s.%0.8s', $basename, $extension);

        $image = $this->cropImage($image, 200, 200);
        $image->save($dir . '/' . $fileName);
        return $fileName;
    }

    /**
     * @param $image
     * @param $width
     * @param $height
     * @return mixed
     */
    protected function cropImage($image, $width, $height)
    {
        $image->widen($width * 2);
        $cx = round($image->width() / 2);
        $cy = round($image->height() / 2);
        $x = round($cx - $width / 2);
        $y = round($cy - $height / 2);

        if ($x < 0) $x = 0;
        if ($y < 0) $y = 0;
        return $image->crop($width, $height, $x, $y);
    }
}