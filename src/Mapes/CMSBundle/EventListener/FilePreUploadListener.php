<?PHP

namespace Mapes\CMSBundle\EventListener;

use Oneup\UploaderBundle\Event\PreUploadEvent;

class FilePreUploadListener
{
    public function onPreUpload(PreUploadEvent $event)
    {
        $file = $event->getFile();
        $request = $event->getRequest();

        $uploaded_file_original_name = $file->getClientOriginalName();
        $uploaded_file_size = $file->getSize();
        $request->request->set('uploaded_file_original_name', $uploaded_file_original_name);
        $request->request->set('uploaded_file_size', $uploaded_file_size);
    }
}