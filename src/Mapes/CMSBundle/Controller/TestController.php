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
use Mapes\UserBundle\Entity\Member as Member;

class TestController extends Controller
{
    /*
     * Get uploaded file list for Oneupuploaded bundle
     */
    public function emailAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();
        $member = $em->getRepository('MapesUserBundle:Member')->find(13);
        
        
		$this->get('mail_helper')->retrievePassword($member, 'kd3dfdfdd');
		
		exit;
	}
}
