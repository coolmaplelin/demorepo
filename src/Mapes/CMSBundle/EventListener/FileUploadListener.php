<?PHP

namespace Mapes\CMSBundle\EventListener;

use Oneup\UploaderBundle\Event\PostPersistEvent;
use Mapes\CMSBundle\Utils\galleryUtils as myGalleryUtils;
use Mapes\CMSBundle\Entity\PageImage as PageImage;

class FileUploadListener
{
    public function __construct($sf_web_dir, $upload_path, $em)
    {
        $this->sf_web_dir = $sf_web_dir;
        $this->oneup_uploader_galleries_path = $upload_path;
        $this->em = $em;
        //$this->oneup_uploader_endpoint = 'http://symoobox/_uploader/galleries/upload';
    }
    
    public function onUpload(PostPersistEvent $event)
    {
        $file = $event->getFile();
        $response = $event->getResponse();

        $request = $event->getRequest();
        $fileEntity = $request->get('fileEntity');
        $refid = $request->get('refid');
        $filename = $file->getFilename();
        
        //Create object folder
        $moved_folder = $this->oneup_uploader_galleries_path.'/'.$fileEntity;
        if(!is_dir($moved_folder)){
                mkdir($moved_folder);
        }          
        $moved_folder = $moved_folder.'/'.$refid;
        if(!is_dir($moved_folder)){
                mkdir($moved_folder);
        }          
        
        //Move file
        $file->move($moved_folder, $filename);
        
        //Create thumbnail
        $url = str_replace($this->sf_web_dir, "", $moved_folder)."/".$filename;
        $gallery_utils = new myGalleryUtils($this->sf_web_dir);
        $thumbnail_url = $gallery_utils->getThumbnail($url, 80, 60); 
        $deleteUrl = "";
        
        if($fileEntity == 'PageImage'){
            
            $PageEntity = $this->em->getRepository('MapesCMSBundle:Page')->find($refid);
            
            $PageImageEntity = new PageImage();
            $PageImageEntity->setPage($PageEntity);
            $PageImageEntity->setFilePath($url);
            $PageImageEntity->setIsLive(1);
            
            $this->em->persist($PageImageEntity);
            $this->em->flush();

            $deleteUrl = "/ajax/delete_uploadedfile?fileEntity=".$fileEntity."&file=".$url;
            //$detailUrl = "/ajax/get_uploadedfile?fileEntity=".$fileEntity."&fileid=".$PageImageEntity->getId();
        }
        
        $response['files'] = array(
            array(
                'fileEntity' => $fileEntity,
                'refid' => $refid,
                'fileid' => $PageImageEntity->getId(),
                'name' => $filename,
                'original_name' => $request->get('uploaded_file_original_name'),
                'url' => $url,
                'thumbnailUrl' => $thumbnail_url,
                //'detailUrl' => $detailUrl,
                'size' => $request->get('uploaded_file_size'),
                'deleteUrl' => $deleteUrl,
                'deleteType' => 'DELETE'
            )
        );
        
        
    }
}