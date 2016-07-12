<?php

namespace Mapes\CMSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Mapes\CMSBundle\Extension\MyTwigExtension;

class PageController extends Controller
{
    public function indexAction($slug, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if($slug != "index"){
            if(strpos($slug, "?") !== false)
                $slug = substr($slug, 0, strpos($slug, "?"));
            
            
            $page = $em->getRepository('MapesCMSBundle:Page')->getLivePageBySlug($slug);
        }else{
            $page = $em->getRepository('MapesCMSBundle:Page')->find(1);
        }
        
        if (!$page) {
            throw $this->createNotFoundException('Unable to find Page entity.');
        }
        
        
        //Set session varible
        $session = $this->get('session');
		
        if($page->getMetaTitle()){
            $session->set('meta_title', $page->getMetaTitle());
        }
        if($page->getMetaDescription()){
            $session->set('meta_description', $page->getMetaDescription());
        }
        
        //$pageImages = $page->getImages();
        //$session->set('mainslider_images', $pageImages);
        
		if($page->getId() == 1) {
			return $this->render('MapesCMSBundle:Page:homepage.html.twig', array(
				'page' => $page,
			 ));
			
		}else{
			return $this->render('MapesCMSBundle:Page:index.html.twig', array(
				'page' => $page,
				//'page_images' => $pageImages,
			 ));
			
		}
    }
	
	public function emailAction(Request $request)
	{
		
	}
}
