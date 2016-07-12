<?PHP

namespace Mapes\CMSBundle\ErrorHandler;

use Exception;
use Oneup\UploaderBundle\Uploader\ErrorHandler\ErrorHandlerInterface;
use Oneup\UploaderBundle\Uploader\Response\AbstractResponse;

class FileUploadErrorHandler implements ErrorHandlerInterface
{
    private $_filename = 'maple.png';
    
    public function setOriginalFilename($vv)
    {
        $this->_filename = $vv;
    }
    
    public function addException(AbstractResponse $response, Exception $exception)
    {
        $message = $exception->getMessage();
        $response->addToOffset(array('error' => $message, 'name' => $this->_filename), array('files'));
    }
}