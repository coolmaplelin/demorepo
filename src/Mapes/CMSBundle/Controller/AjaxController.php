<?php

namespace Mapes\CMSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Mapes\CMSBundle\Extension\MyTwigExtension;
use Mapes\CMSBundle\Entity\Page;
use Mapes\CMSBundle\Entity\PageImage;
use Mapes\CMSBundle\Entity\Navigation;
use Mapes\CMSBundle\Utils\navigationUtils as myNavigationUtils;
use Mapes\CMSBundle\Utils\galleryUtils as myGalleryUtils;
use Mapes\CMSBundle\Utils\fileUtils as myFileUtils;
use Mapes\CMSBundle\Utils\mailUtlis as myMailUtils;
use Mapes\CMSBundle\Utils\pageCache as myPageCacheUtils;
use Mapes\CustomFormBundle\Entity\CustomFormEntry as CustomFormEntry;

class AjaxController extends Controller
{
    /*
     * Get uploaded file list for Oneupuploaded bundle
     */
    public function get_uploadedfile_listAction(Request $request)
    {
        //$request = $this->get('request');
        $sf_web_dir = $this->container->getParameter('sf_web_dir');
        $fileEntity = $request->get('fileEntity');
        $refid = $request->get('refid');
        
        
        $em = $this->getDoctrine()->getManager();
        switch($fileEntity) {
            case 'PageImage' :
                $refobj = $em->getRepository('MapesCMSBundle:Page')->find($refid);
                $PageImages = $refobj->getImages();
                break;
        };
        
        $files = array();
        $gallery_utils = new myGalleryUtils($sf_web_dir);
        foreach($PageImages as $PageImage){
            $file_path = $PageImage->getFilePath();
            $file_name = basename($sf_web_dir.$file_path);
            
            $files[] = array(
                'fileEntity' => $fileEntity,
                'refid' => $refid,
                'fileid' => $PageImage->getId(),
                'name' => $file_name,
                'original_name' => $file_name,
                'url' => $file_path,
                'thumbnailUrl' => $gallery_utils->getThumbnail($file_path, 80, 60),
//                'detailUrl' => $this->generateUrl('ajax_get_uploadedfile', array('fileEntity' => $fileEntity, 'fileid' => $PageImage->getId())),
                'size' => myFileUtils::formatSizeUnits(filesize($sf_web_dir.$file_path)),
                'deleteUrl' => "/ajax/delete_uploadedfile?fileEntity=".$fileEntity."&file=".$file_path,
                'deleteType' => 'DELETE'
            );
        }
        
        return new JsonResponse(array(
            'files' => $files
        ));
    }
    
    /*
     * Delete uploaded file via Oneupuploaded bundle
     */
    public function delete_uploadedfileAction(Request $request)
    {
        //$request = $this->get('request');
        
        $sf_web_dir = $this->container->getParameter('sf_web_dir');
        $fileEntity = $request->get('fileEntity');
        $file_path = $request->get('file');
        $file_name = basename($sf_web_dir.$file_path);
        $file_folder = dirname($sf_web_dir.$file_path);
        
        if($fileEntity != "" && $file_path != ""){
            
            $em = $this->getDoctrine()->getManager();
            $PageImage = $em->getRepository('MapesCMSBundle:PageImage')->getPageImageByFilePath($file_path);
            
            if(is_file($sf_web_dir.$file_path)) {
                //Delete thumbnail
                foreach(glob($file_folder.'/*', GLOB_ONLYDIR) as $subDir) {
                    $subDir = str_replace($file_folder, '', $subDir);

                    $thumbnail_file = $file_folder.$subDir."/".$file_name;
                    if(is_file($thumbnail_file)){
                        unlink($thumbnail_file);
                    }
                }

                //Delete original file
                unlink($this->container->getParameter('sf_web_dir').$file_path);
            }
            //Delete file entity
            if($PageImage){
                $em->remove($PageImage);
                $em->flush();
            }
            
            
        }
        
        return new JsonResponse(array(
            $file_path => true
        ));
    }
    
    public function get_uploadedfileAction(Request $request)
    {
        //$request = $this->get('request');
        
        $sf_web_dir = $this->container->getParameter('sf_web_dir');
        $gallery_utils = new myGalleryUtils($sf_web_dir);
        $fileEntity = $request->get('fileEntity');
        $fileid = $request->get('fileid');
        $em = $this->getDoctrine()->getManager();
        $uploadedFileObj = $em->getRepository('MapesCMSBundle:'.$fileEntity)->find($fileid);
        
        if($fileEntity != "" && $uploadedFileObj){

            $file_path = $uploadedFileObj->getFilePath();
            
            $uploadedFile = array(
                'fileEntity' => $fileEntity,
                'refid' => '',
                'fileid' => $fileid,
                'file_path' => $file_path,
                'thumbnailUrl' => $gallery_utils->getThumbnail($file_path, 80, 60),
                'heading' => $uploadedFileObj->getHeading(),
                'desc' => $uploadedFileObj->getDescription(),
                'link' => $uploadedFileObj->getLink(),
                'islive' => $uploadedFileObj->getIsLive(),
            );
        }
        
        return new JsonResponse($uploadedFile);
    }    
    
    public function update_uploadedfileAction(Request $request)
    {
        //$request = $this->get('request');
        
        $sf_web_dir = $this->container->getParameter('sf_web_dir');
        $gallery_utils = new myGalleryUtils($sf_web_dir);
        $fileEntity = $request->get('fileEntity');
        $fileid = $request->get('fileid');
        
        $em = $this->getDoctrine()->getManager();
        $uploadedFileObj = $em->getRepository('MapesCMSBundle:'.$fileEntity)->find($fileid);
        
        if($fileEntity != "" && $uploadedFileObj){

            $uploadedFileObj->setHeading($request->get('heading'));
            $uploadedFileObj->setDescription($request->get('desc'));
            $uploadedFileObj->setLink($request->get('link'));
            $uploadedFileObj->setIsLive($request->get('islive'));
            $em->persist($uploadedFileObj);
            $em->flush();
            
        }
        
        exit;
    }        
    
    public function reorder_pageimageAction(Request $request)
    {
        //$request = $this->get('request');
        $fileEntity = $request->get('fileEntity');
        $refid = $request->get('refid');
        $imgdata = $request->get('imgdata');
        
        $em = $this->getDoctrine()->getManager();
        foreach($imgdata as $data) {
            $image_id = $data['fid'];
            
            $ImageObject = $em->getRepository('MapesCMSBundle:'.$fileEntity)->find($image_id);
            if($ImageObject) {
                $ImageObject->setOrderNum($data['seq']);
                $em->persist($ImageObject);
                $em->flush();
            }
        }
        
        exit;
    }
    
    public function save_navigationAction(Request $request)
    {
        //$request = $this->get('request');
        
        $totalTop = $request->get('totalTop');
        $locationType = $request->get('locationType');
        
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('MapesCMSBundle:Navigation');
        $isDeleted = $repository->deleteNavElements($locationType);
        
        for($i = 0; $i < $totalTop; $i++)
	{
            $nav = new Navigation();
            $nav->setLocation($locationType);
            $nav->setElementType("PARENT");
            $nav->setAnchorText($request->get('totalTop-'.$i.'-anchor'));
            if($request->get('totalTop-'.$i.'-page-id') != ""){
                $pageObj = $em->getRepository('MapesCMSBundle:Page')->find($request->get('totalTop-'.$i.'-page-id'));
                if($pageObj)
                    $nav->setPage($pageObj);
            }
            $nav->setUrl($request->get('totalTop-'.$i.'-url'));
            $nav->setIsLive($request->get('totalTop-'.$i.'-visible'));
            $nav->setOrderNum($i + 1);
            
            $em->persist($nav);
            $em->flush();        
            
            //Save child
            for($j = 0; $j < $request->get('totalTop-'.$i.'-count'); $j++)
            {	
                    $subNav = new Navigation();
                    $subNav->setLocation($locationType);
                    $subNav->setParentId($nav->getId());
                    $subNav->setElementType("CHILD");
                    $subNav->setAnchorText($request->get('totalTop-'.$i.'-'.$j.'-anchor'));
                    if($request->get('totalTop-'.$i.'-'.$j.'-page-id') != ""){
                        $pageObj = $em->getRepository('MapesCMSBundle:Page')->find($request->get('totalTop-'.$i.'-'.$j.'-page-id'));
                        if($pageObj)
                            $subNav->setPage($pageObj);
                    }
                    $subNav->setUrl($request->get('totalTop-'.$i.'-'.$j.'-url'));
                    $subNav->setIsLive($request->get('totalTop-'.$i.'-'.$j.'-visible'));
                    $subNav->setOrderNum($j + 1);
                    
                    $em->persist($subNav);
                    $em->flush();        
            }            
        }
        
        //Generate cache
        $parentNavElements = $repository->getNavElements($locationType, 'PARENT');
        $childNavElements = array();
        
        foreach($parentNavElements as $parentNavElement) {
            $childNavElements[$parentNavElement->getId()] = $repository->getNavElements($locationType, 'CHILD', $parentNavElement->getId());
        }
        
        myNavigationUtils::cacheGenerate($locationType, $parentNavElements, $childNavElements);
        
        exit;
    }
	
	public function save_contact_entryAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$custom_form = $em->getRepository('MapesCustomFormBundle:CustomForm')->findOneById(1);
		if (!$custom_form) {
            throw $this->createNotFoundException('Unable to find Custom Form entity.');
        }
		
		//$request = $this->get('request');
		$postParameters = $request->request->all();
		$name = $postParameters['name'];
		$email = $postParameters['email'];
		$phone = $postParameters['phone'];
		$message = $postParameters['message'];
		$formFields = json_decode($custom_form->getFormFields());
		foreach($formFields as $key => $field){
			
				$title = $field->title;
				$slug = myPageCacheUtils::makeSlug("", strtolower(trim($title)));
				$type = $field->type;
				if($slug == 'name') {
					$formFields[$key]->value = $name;
				}elseif($slug == 'email') {
					$formFields[$key]->value = $email;
				}elseif($slug == 'phone') {
					$formFields[$key]->value = $phone;
				}elseif($slug == 'message') {
					$formFields[$key]->value = $message;
				}
				
		}    
		$CustomFormEntry = new CustomFormEntry();
		$CustomFormEntry->setCustomForm($custom_form);
		$CustomFormEntry->setFormFields(json_encode($formFields));
		$CustomFormEntry->setIsActioned(0);
		
		$em->persist($CustomFormEntry);
		$em->flush();            
		
		$this->get('mail_helper')->notifiyAdminForFormEntry($custom_form->getTitle(), $CustomFormEntry->getFormFieldsValues());
		
		exit;
	}
}
