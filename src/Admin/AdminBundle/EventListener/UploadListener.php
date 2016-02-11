<?php
 namespace Admin\AdminBundle\EventListener;

use Oneup\UploaderBundle\Event\PostPersistEvent;

class UploadListener
{
    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function onUpload(PostPersistEvent $event)
{
    $request = $event->getRequest();
    $gallery = $request->get('gallery');

    // ...
}
}