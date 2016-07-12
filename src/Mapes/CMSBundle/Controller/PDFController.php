<?php

namespace Mapes\CMSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Mapes\CMSBundle\Extension\MyTwigExtension;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


class PDFController extends Controller
{
    public function indexAction(Request $request)
    {
        
        return $this->render('MapesCMSBundle:PDF:index.html.twig', array(
            
         ));
    }
	
	public function printAction(Request $request)
	{
		//$this->get('knp_snappy.pdf')->generate($this->generateUrl('user_account', array(), true), __DIR__.'/path/to/the/file.pdf');
		
		$html = $this->renderView('MapesCMSBundle:PDF:index.html.twig', array(
			
		));
		$output = $this->get('knp_snappy.pdf')->getOutputFromHtml($html, array(
			//'orientation'=>'Landscape', 
			//'default-footer'=>true
			//'footer-html' => 'http://www.google.com'
		));
		return new Response($output,
			200,
			array(
				'Content-Type'          => 'application/pdf',
				'Content-Disposition'   => 'attachment; filename="my_pdf_file.pdf"'
			)
		);
	}
}
