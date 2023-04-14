<?php

namespace App\Tests\Functional;

use App\Entity\MediaObject;
use Zenstruck\Foundry\Test\ResetDatabase;
use Zenstruck\Foundry\Factory;
use function Zenstruck\Foundry\faker;
use App\Test\CustomApiTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class MediaObjectResourceTest extends CustomApiTestCase
{
    use ResetDatabase;


    public function testCreateMediaObject(): void
    {
        $file = faker()->file('fixtures/files', 'fixtures/files/UploadedFiles');
        $uploaded_file = new UploadedFile($file, 'boysnoize_superacid.jpg');

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
                    'file' => $uploaded_file
                ]
            ]
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertMatchesResourceItemJsonSchema(MediaObject::class);
    }
}
