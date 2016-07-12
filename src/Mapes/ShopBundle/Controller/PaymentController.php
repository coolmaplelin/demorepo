<?php

namespace Mapes\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Mapes\ShopBundle\Utils\eWayUtils;
use Mapes\ShopBundle\Entity\OrderEntry;
use Mapes\ShopBundle\Entity\Product;
use Mapes\ShopBundle\Entity\Payment;

class PaymentController extends Controller
{
    public function optionAction(Request $request)
    {
        $session = $this->get('session');
        $session->set('meta_title', 'Payment Option');
        return $this->render('MapesShopBundle:Payment:option.html.twig', array());
    }
	
    public function ewayAction(Request $request)
    {
		$session = $this->get('session');
		$temporary_order = $session->get('temporary_order');
		$em = $this->getDoctrine()->getManager();
		$env = $this->get('kernel')->getEnvironment();
		
		$OrderEntry = $em->getRepository('MapesShopBundle:OrderEntry')->find($temporary_order['order_id']);
		$Product = $em->getRepository('MapesShopBundle:Product')->find($temporary_order['product_id']);
		$CustomerDetails = $temporary_order;
		$myEwayUtils = new eWayUtils($this->get('kernel'), $em);
		
		if($env != 'dev') {
			$accessCodeResponse = $myEwayUtils->getResponseForCreateAccessCode($OrderEntry, $CustomerDetails);
			$accessCode = $accessCodeResponse->AccessCode;
			$formActionUrl = $accessCodeResponse->FormActionURL;
		}else{
			$accessCode = 'dev';
			$formActionUrl = $this->generateUrl('shop_pay_eway_process', array());
		}
		
	$session->set('meta_title', 'Eway');	
        return $this->render('MapesShopBundle:Payment:eway.html.twig', array(
			'accessCode' => $accessCode,
			'formActionUrl' => $formActionUrl
		));
    }
	
	public function eway_processAction(Request $request)
	{
		$session = $this->get('session');
		$temporary_order = $session->get('temporary_order');
		$em = $this->getDoctrine()->getManager();
		$env = $this->get('kernel')->getEnvironment();
		
		$OrderEntry = $em->getRepository('MapesShopBundle:OrderEntry')->find($temporary_order['order_id']);
		$Product = $em->getRepository('MapesShopBundle:Product')->find($temporary_order['product_id']);
		$CustomerDetails = $temporary_order;
		$myEwayUtils = new eWayUtils($this->get('kernel'), $em);
		
		//$request = $this->get('request');
		$AccessCode = $request->query->get('AccessCode');
		
		if($env != 'dev' && !$AccessCode){
            
        }
		
		$eway_response = NULL;
		if($env != 'dev') {
			$eway_response = $myEwayUtils->getResponseForGetAccessCodeResult($AccessCode);
		}
		
                $myPaymentLog = $this->get('eway_helper')->processEwayResponse($eway_response, $OrderEntry, $CustomerDetails);
		if($myPaymentLog && $myPaymentLog->getIsSuccessful()) {
			
			if($Product->getType() == 'MEMBERSHIP') {
				$session->set('temporary_order', NULL);
				return $this->redirect($this->generateUrl('user_register_thankyou', array()));  
			}
		}else{
                    
                        $errors = $myPaymentLog ? $myPaymentLog->getResponseText() : array();
                        
                        if($errors) {
                            
                            $errors = explode("|", $errors);
                        }
                        
                }
		
		$session->set('meta_title', 'Payment Failed');	
		return $this->render('MapesShopBundle:Payment:eway_error.html.twig', array(
                    'retryUrl' => $this->generateUrl('shop_pay_eway', array()),
                    'errors' => isset($errors) ? $errors : array()
        ));
	}
	
}
