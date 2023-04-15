<?php

namespace App\Service;

/**
 * Class HelperService
 * @author yourname
 */
class HelperService
{
    /**
     * Get a unique hash from a file path.
     * Can be used as the Track record ID.
     *
     * @return string
     */
    public function getFileHash(string $path): string
    {
        return md5('%env(APP_SECRET)%'.$path);
    }
}
