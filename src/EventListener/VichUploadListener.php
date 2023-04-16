<?php

namespace App\EventListener;

use Vich\UploaderBundle\Event\Event;

/**
 * Class VichUploadListener.
 *
 * @author yourname
 */
class VichUploadListener
{
    public function onVichUploaderPostUpload(Event $event)
    {
        dump($event->getObject());
        dd($event->getMapping());
    }

    public function onVichUploaderPreUpload(Event $event)
    {
        dump($event->getObject());
        dd($event->getMapping());
    }
}
