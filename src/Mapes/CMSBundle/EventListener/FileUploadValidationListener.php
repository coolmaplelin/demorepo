<?php

namespace Mapes\CMSBundle\EventListener;

use Oneup\UploaderBundle\Event\ValidationEvent;
use Oneup\UploaderBundle\Uploader\Exception\ValidationException;

class FileUploadValidationListener
{
    public function onValidate(ValidationEvent $event)
    {
        $config = $event->getConfig();
        $file   = $event->getFile();

        if (count($config['allowed_mimetypes']) == 0) {
            return;
        }

        $mimetype = $file->getMimeType();

        if (!in_array($mimetype, $config['allowed_mimetypes'])) {
            throw new ValidationException($mimetype . ' is not allowed. ');
        }
    }
}