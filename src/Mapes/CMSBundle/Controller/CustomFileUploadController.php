<?php
namespace Mapes\CMSBundle\Controller;

use Symfony\Component\HttpFoundation\File\Exception\UploadException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Oneup\UploaderBundle\Controller\BlueimpController;
use Oneup\UploaderBundle\Uploader\Response\EmptyResponse;

class CustomFileUploadController extends BlueimpController
{
    public function upload()
    {
        $request = $this->getRequest();
        $response = new EmptyResponse();
        $files = $this->getFiles($request->files);

        $chunked = !is_null($request->headers->get('content-range'));

        foreach ((array) $files as $file) {
            try {
                $chunked ?
                    $this->handleChunkedUpload($file, $response, $request) :
                    $this->handleUpload($file, $response, $request)
                ;
            } catch (UploadException $e) {
                $this->errorHandler->setOriginalFilename($file->getClientOriginalName());
                $this->errorHandler->addException($response, $e);
            }
        }

        return $this->createSupportedJsonResponse($response->assemble());
    }
    
}


?>
