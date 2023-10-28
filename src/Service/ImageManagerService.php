<?php

namespace App\Service;

use Intervention\Image\Constraint;
use Intervention\Image\ImageManager;

/**
 * Class ImageManagerService.
 *
 * @author yourname
 */
class ImageManagerService
{
    private const DEFAULT_QUALITY = 80;
    private const DEFAULT_MAX_WIDTH = 600;
    private $imageManager;

    public function __construct(ImageManager $imageManager)
    {
        $this->imageManager = $imageManager;
    }

    public function writeFromBinaryData($data, $destination, $config = [])
    {
        $img = $this->imageManager
                ->make($data)
                ->resize(
                    $config['max_width'] ?? self::DEFAULT_MAX_WIDTH,
                    null,
                    static function (Constraint $constraint): void {
                        $constraint->upsize();
                        $constraint->aspectRatio();
                    }
                );

        $img->save($destination, $config['quality'] ?? self::DEFAULT_QUALITY);
    }
}
