<?php

namespace App\Service;

use Intervention\Image\Constraint;
use Intervention\Image\ImageManager;

/**
 *
 * Class ImageManagerService
 * @author yourname
 */
class ImageManagerService
{
    private const DEFAULT_QUALITY = 80;
    private $imageManager;


    public function __construct(ImageManager $imageManager)
    {
        $this->imageManager = $imageManager;
    }

    public function writeFromBinaryData($data, $destination)
    {
        $img = $this->imageManager
                    ->make($data);

        $img->save($destination, $config['quality'] ?? self::DEFAULT_QUALITY);
    }
}
