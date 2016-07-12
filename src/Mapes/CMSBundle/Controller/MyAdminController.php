<?php

namespace Mapes\CMSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Mapes\CMSBundle\Utils\fileUtils as fileUtils;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;

class MyAdminController extends Controller
{
    public function preferenceAction(Request $request)
    {
        $admin_pool = $this->get('sonata.admin.pool');
        //$request = $this->get('request');
        
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('MapesCMSBundle:SiteSetting');
        
        $preference_array = array(
            'ga-code-head' => '', 
            'ga-code-footer' => '',  
            'system-no-reply-email' => '',
            'admin_email' => '',
        );
        foreach($preference_array as $name => $value) {
            $obj = $repository->findOneBy(array('name'=> $name));
            if($obj)
                $preference_array[$name] = $obj->getValue();
        }
        
        if($request->getMethod() == 'POST') {
            //var_dump($request->request->all());die();
            $postParameters = $request->request->all();
            //var_dump($postParameters);die();
            foreach($preference_array as $name => $value) {
                $obj = $repository->findOneBy(array('name'=> $name));
                if($obj){
                    if(isset($postParameters[$name])){
                        $obj->setValue($postParameters[$name]);
                        $em->persist($obj);
                        $em->flush();
                        $preference_array[$name] = $postParameters[$name];
                    }
                }
            }
            
            //Set Flash Message
            $this->get('session')->getFlashBag()->add('sonata_flash_success', 'System preferences have been updated.');
            return $this->redirect($this->generateUrl('admin_system_preference'));
        }
        
        return $this->render('MapesCMSBundle:MyAdmin:preference.html.twig', array(
              'admin_pool' => $admin_pool,
              'preference_array' => $preference_array
        ));
    }
    
    public function cacheAction(Request $request)
    {
        $admin_pool = $this->get('sonata.admin.pool');
        //$request = $this->get('request');
        
        
        if($request->query->get('SymfonyCC')) {
            
                /*$cache_dir = $this->get('kernel')->getCacheDir(); 
                fileUtils::deleteDir($cache_dir);*/
                $command = $this->container->get('mapes.cache.clear');
                $input = new ArgvInput(array('--env=' . $this->container->getParameter('kernel.environment')));
				//$input = null;
                $output = new ConsoleOutput();
                $command->run($input, $output);

                $this->get('session')->getFlashBag()->add('sonata_flash_success', 'Symfony cache Cleared.');
        }        
        
        return $this->render('MapesCMSBundle:MyAdmin:cache.html.twig', array(
              'admin_pool' => $admin_pool,
        ));
    }    
    
    public function navigationAction(Request $request)
    {
		//var_dump($_SESSION);die();
		
        $admin_pool = $this->get('sonata.admin.pool');
        //$request = $this->get('request');

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('MapesCMSBundle:Navigation');
        
        $location = $request->query->get('location', 'TOP');
        $parentNavElements = $repository->getNavElements($location, 'PARENT');
        $childNavElements = array();
        
        foreach($parentNavElements as $parentNavElement) {
            $childNavElements[$parentNavElement->getId()] = $repository->getNavElements($location, 'CHILD', $parentNavElement->getId());
        }
        return $this->render('MapesCMSBundle:MyAdmin:navigation.html.twig', array(
              'admin_pool' => $admin_pool,
              'location' => $location,
              'parentNavElements' => $parentNavElements,
              'childNavElements' => $childNavElements,
        ));
    }
    
}
