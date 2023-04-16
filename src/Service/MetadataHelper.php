<?php

namespace App\Service;

use JamesHeinrich\GetID3\GetID3;

/**
 * Class MetadataHelper.
 *
 * @author yourname
 */
class MetadataHelper
{
    /**
     * @var GetId3
     */
    private $getID3;

    public function __construct()
    {
        $this->getID3 = new \getID3();
    }

    public function analyze($filePath)
    {
        $info = $this->getID3->analyze($filePath);

        $this->getID3->CopyTagsToComments($info);

        return $info;
    }
}
