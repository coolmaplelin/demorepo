<?php

namespace Mapes\CMSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Mapes\CMSBundle\Utils\dateUtils as dateUtils;

class MyReportController extends Controller
{
    public function registrationAction(Request $request)
    {
        $admin_pool = $this->get('sonata.admin.pool');
        //$request = $this->get('request');
		//var_dump($request->request->all());die();
		$start_date = $request->query->get('start_date', date('01-m-Y')); 
		$end_date = $request->query->get('end_date', date('d-m-Y')); 
		//echo $start_date;die();
        
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('MapesUserBundle:Member');
        $registration_result = $repository->getRegistrationGroupbyMonth($start_date, $end_date);
        
        return $this->render('MapesCMSBundle:MyReport:registration.html.twig', array(
              'admin_pool' => $admin_pool,
			  'start_date' => $start_date,
			  'end_date' => $end_date,
              'registration_result' => $registration_result
        ));
		
    }
    
    
}
