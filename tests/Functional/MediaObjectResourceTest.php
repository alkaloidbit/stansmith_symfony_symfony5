<?php

namespace App\Tests\Functional;

use App\Entity\MediaObject;
use Zenstruck\Foundry\Test\ResetDatabase;
use App\Test\CustomApiTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class MediaObjectResourceTest extends CustomApiTestCase
{
    use ResetDatabase;

    public function testCreateMediaObject(): void
    {

        $file = new UploadedFile('fixtures/files/boysnoize_superacid.jpg', 'boysnoize_superacid.jpg');

        $client = self::createClient();

        $client->request('POST', '/api/media_objects', [
            'headers' => ['Content-Type' => 'multipart/form-data'],
            'extra' => []
        ]);

        $this->assertResponseStatusCodeSame(401);

        $this->createUserAndLogIn($client, 'testalbum@example.com', 'foo');
        $client->request('POST', '/api/media_objects', [
            'headers' => ['Content-Type' => 'multipart/form-data'],
            'extra' => [
                'files' => [
                    'file' => $file
                ]
            ]
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertMatchesResourceItemJsonSchema(MediaObject::class); 

    }
}
