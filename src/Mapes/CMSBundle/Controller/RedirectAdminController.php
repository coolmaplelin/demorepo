<?php

namespace Mapes\CMSBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Mapes\CMSBundle\Entity\Redirect as Redirect;
use Mapes\CMSBundle\Utils\pageCache as pageCache;


class RedirectAdminController extends CRUDController
{
    public function uploadAction(Request $request)
    {
        //$admin_pool = $this->get('sonata.admin.pool');
        $request = $this->get('request');

        
		$isValidated = false;
		$errors = array();
		$msgs = array();
        if($request->getMethod() == 'POST') {
			
			
			
			if($request->request->get('validate') == '1') {
				
				$this->get('session')->set('redirect_csv_data', array());
				$redirect_csv = $request->files->get('redirect_csv');
				//$path = $redirect_csv->getPathname();
				//var_dump($redirect_csv);die();
				$mimeType = $redirect_csv ? $redirect_csv->getMimeType() : '';
				//var_dump($mimeType);die();
				if($redirect_csv === null || $redirect_csv->getClientOriginalName() == '') {
					$errors['summary'] = 'File must be specified ';
					
				}elseif($mimeType != 'text/plain' && $mimeType != 'text/csv' && $mimeType != 'application/vnd.ms-excel' && $mimeType !='application/octet-stream') {
					$errors['summary'] = 'File must be in CSV format. ';
				}else{
				
					$myFile = $redirect_csv->getPathname();
					$dataArray = array();
					
					if (($handle = fopen($myFile, "r")) !== FALSE) {

						$counter = 0;
						while (($data = fgetcsv($handle, 5000, ",")) !== FALSE ) {

							$dataArray[$counter] = $data;
							$counter++;

						}

						fclose($handle);

						foreach($dataArray as $counter => $data) {
							$lineError = array();

							if(count($data) != 2) {
								$lineError[] = 'The number of columns must be 2. ';
							}else{
								$lineError = $this->_validateRedirectUploadData($data);
							}

							if(!empty($lineError))
								$errors[$counter] = $lineError;
						   else {
								$msgs[$counter][] = 'Validated';
							}
						}

						if(empty($errors)){
							$isValidated = true;
						}else
							$this->get('session')->getFlashBag()->add('sonata_flash_error', 'Error found in the file.');
						

						$this->get('session')->set('redirect_csv_data', $dataArray);
					}        
				}
				
				if(isset($errors['summary']))
					$this->get('session')->getFlashBag()->add('sonata_flash_error', $errors['summary']);
			}
			
			if($request->request->get('submitted') == '1') {

				$isValidated = true;
				$dataArray = $this->get('session')->get('redirect_csv_data');
				$em = $this->getDoctrine()->getManager();
				$repository = $em->getRepository('MapesCMSBundle:Redirect');
				
				foreach($dataArray as $counter => $data) {
					
					 $original_url = $data[0];
					 $destination_url = $data[1];
					 
					 $Redirect = new Redirect();
					 $Redirect->setOriginalUrl($original_url);
					 $Redirect->setDestinationUrl($destination_url);
					 $Redirect->regen_cache = false;
					
					 $em->persist($Redirect);
					 $msgs[$counter][] = 'Success';
				}
				
				$em->flush();  
				
				$Redirects = $repository->findAll();
				pageCache::generateStaticRedirect($Redirects);
				
				$this->get('session')->set('redirect_csv_data', array());
				$this->get('session')->getFlashBag()->add('sonata_flash_success', 'File has been successfully uploaded.');
				return $this->redirect('upload');  
				
			}                    

		}
		
		/*var_dump($isValidated);
		var_dump($errors);
		var_dump($msgs);die();*/
        return $this->render('MapesCMSBundle:RedirectAdmin:upload.html.twig', array(
              'isValidated' => $isValidated,
			  'errors' => $errors,
			  'msgs' => $msgs
        ));
    }
	
	private function _validateRedirectUploadData($data) {
		
		$error = array();
		$url1 = trim($data[0]);
		$url2 = trim($data[1]);
		
		if (substr($url1, 0, 1) != '/') {
			$error[] = "Original URL must have a leading '/' ";
		}
		if (substr($url2, 0, 1) != '/') {
			$error[] = "Destination URL must have a leading '/' ";
		}
		
		return $error;
	}

}
