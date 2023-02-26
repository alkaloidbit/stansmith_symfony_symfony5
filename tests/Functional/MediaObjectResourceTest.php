<?php

namespace App\Tests\Functional;

use Zenstruck\Foundry\Test\ResetDatabase;
use App\Test\CustomApiTestCase;

class MediaObjectResourceTest extends CustomApiTestCase
{
    use ResetDatabase;

    public function createMediaObject(): void
    {
        $client = self::createClient();

        $client->request('POST', '/api/media_objects', [
            'json' => [
                ''
            ]
        ]);
    }

}
