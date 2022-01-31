<?php

namespace App\Controller;

use App\Entity\ThumbnailObject;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class CreateThumbnailObjectAction
 * @author yourname
 */
final class CreateThumbnailObjectAction
{
    public function __invoke(Request $request): ThumbnailObject
    {
        $uploadedFile = $request->files->get('file');
        if (! $uploadedFile) {
            throw new BadRequestHttpException('"file" is required');
        }

        $thumbnailObject = new ThumbnailObject();
        $thumbnailObject->file = $uploadedFile;

        return $thumbnailObject;
    }
}
