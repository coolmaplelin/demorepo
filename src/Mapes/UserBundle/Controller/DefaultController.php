<?php

namespace Mapes\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

use Mapes\UserBundle\Entity\Member;
use Mapes\ShopBundle\Entity\Product;
use Mapes\ShopBundle\Entity\OrderEntry;
use Mapes\ShopBundle\Entity\OrderItem;
use Mapes\CMSBundle\Entity\Page;
use Mapes\CMSBundle\Entity\PageImage;
use Mapes\UserBundle\Form\MemberRegistrationType;
use Mapes\UserBundle\Form\MemberAccountType;

class DefaultController extends Controller
{
    public function loginAction(Request $request)
    {
        //$request = $this->getRequest();
        //$session = $request->getSession();

		$authenticationUtils = $this->get('security.authentication_utils');
		
		// get the login error if there is one
		$error = $authenticationUtils->getLastAuthenticationError();
	
        /*if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }*/
		$lastUsername = $authenticationUtils->getLastUsername();
		
        return $this->render('MapesUserBundle:Default:login.html.twig', array(
            // last email entered by the user
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }
    
    public function loggedinAction(Request $request)
    {
        //$user = $this->get('security.context')->getToken()->getUser();
        $user = $this->get('security.token_storage')->getToken()->getUser();
		
        if ($user->getAccountType() == 'ROLE_SUPER_ADMIN') {
            //$this->getRequest()->getSession()->set('pdw_check', true);
			$request->getSession()->set('pdw_check', true);
			
			$sessionKey = $this->_createSessionKey();
			$request->getSession()->set('session_key', $sessionKey);
			
			$writeString = $request->getClientIp()."|".$sessionKey."\n";
			$myFile = $this->getParameter('pdw_file_browser_path')."/session_keys.txt";
			$fh = fopen($myFile, 'a') or die("can't open file ".$myFile);
			fwrite($fh, $writeString);
			fclose($fh);
		
            return $this->redirect("/admin/dashboard");
            
        }else{
            
            return $this->redirect($this->generateUrl('user_dashboard', array()));            
            
        }
    }
	
	private function _createSessionKey()
	{
		$length = 30; $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';

		$chars_length = (strlen($chars) - 1);
		$string = $chars{rand(0, $chars_length)};
		for ($i = 1; $i < $length; $i = strlen($string))
		{
				$r = $chars{rand(0, $chars_length)};
				if ($r != $string{$i - 1}) $string .=  $r;
		}

		return $string;
			
	}
	
    public function registerAction()
    {
        $entity  = new Member();
        $form = $this->createForm(new MemberRegistrationType(), $entity);

        $request = $this->get('request');
        if($request->getMethod() == 'POST') {

                $form->bind($request);

                if ($form->isValid()) {
                        $em = $this->getDoctrine()->getManager();

                        $entity->setAccountType('ROLE_USER');
                        $entity->setUserType('Gerenal User');
                        $entity->setIsActivated(1);
                        $em->persist($entity);
                        $em->flush();

                        return $this->redirect($this->generateUrl('user_register_thankyou', array()));  
                }else{
                    //var_dump($form);
                }

        }
        
        $session = $this->get('session');
        $session->set('meta_title', 'Register');

        return $this->render('MapesUserBundle:Default:register.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }
	
    public function register_thankyouAction()
    {
        $session = $this->get('session');
        $session->set('meta_title', 'Thank you');
        return $this->render('MapesUserBundle:Default:register_thankyou.html.twig', array(
            
         ));
    }    
	
    public function subscribeAction()
    {
        $entity  = new Member();

		
        $request = $this->get('request');
		$subscription = $request->request->get('subscription','');
		
		$session = $this->get('session');
		$temporary_order = $session->get('temporary_order');
		if(!empty($temporary_order)) {
			$entity->setFirstName($temporary_order['first_name']);
			$entity->setLastName($temporary_order['last_name']);
			$entity->setEmail($temporary_order['email']);
			$entity->setUsername($temporary_order['username']);
			$subscription = $temporary_order['product_id'];
			$guest_id = $temporary_order['guest_id'];
		}
		
        $form = $this->createForm(new MemberRegistrationType(), $entity);
		
        if($request->getMethod() == 'POST') {

                $form->bind($request);

                if ($form->isValid()) {
						$form_data = $form->getData();
						$guest_id = isset($guest_id) ? $guest_id : md5($form_data->getEmail().(string)time());
						
						$temporary_order = array(
							'guest_id' => $guest_id,
							'first_name' => $form_data->getFirstName(),
							'last_name' => $form_data->getLastName(),
							'email' => $form_data->getEmail(),
							'username' => $form_data->getUsername(),
							'plain_password' => $form_data->getPlainPassword(),
							'product_id' => $subscription
						);
						
						$session = $this->get('session');
						$session->set('temporary_order', $temporary_order);
						
						/*echo $subscription;
						var_dump($form_data);
						echo $guest_id;
						echo $form_data->getEmail();
						echo $form_data->getPlainPassword();
						die();*/
                        return $this->redirect($this->generateUrl('user_subscribe_confirm', array()));  
                }else{
                    //var_dump($form);
                }

        }
		
        
        $session->set('meta_title', 'Subscribe');
		$em = $this->getDoctrine()->getManager();
		$products = $em->getRepository('MapesShopBundle:Product')->findBy(array('is_live' => 1, 'type' => 'MEMBERSHIP'));
        return $this->render('MapesUserBundle:Default:subscribe.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
			'products' => $products,
			'subscription' => $subscription
        ));
    }
	
	public function subscribe_confirmAction()
	{
		$session = $this->get('session');
		$temporary_order = $session->get('temporary_order');
		
		$em = $this->getDoctrine()->getManager();
		$product = $em->getRepository('MapesShopBundle:Product')->find($temporary_order['product_id']);
		
		$request = $this->get('request');
		$continue = $request->query->get('continue',false);
		
		if ((boolean)$continue) {
			
			$order_id = isset($temporary_order['order_id']) ? $temporary_order['order_id'] : NULL;
			if($order_id){
				$OrderEntry = $em->getRepository('MapesShopBundle:OrderEntry')->find($order_id);
				$OrderItems = $OrderEntry->getOrderitems();
                                $OrderItem = $OrderItems[0];
				
				$OrderEntry->setSubtotal($product->getPrice());
				$em->persist($OrderEntry);
				$em->flush();
				
				$OrderItem->setPrice($product->getPrice());
				$em->persist($OrderItem);
				$em->flush();
			}else{
				//Create order entry and order item entity
				$OrderEntry = new OrderEntry();
				$OrderEntry->setStatus('Pending');
				$OrderEntry->setItems(1);
				$OrderEntry->setSubtotal($product->getPrice());
				$em->persist($OrderEntry);
				$em->flush();
				
				$OrderItem = new OrderItem();
				$OrderItem->setOrder($OrderEntry);
				$OrderItem->setProduct($product);
				$OrderItem->setPrice($product->getPrice());
				$OrderItem->setQuantity(1);
				$em->persist($OrderItem);
				$em->flush();
			}
				
			
			$temporary_order['order_id'] = $OrderEntry->getId();
			$session->set('temporary_order', $temporary_order);
			
			return $this->redirect($this->generateUrl('shop_payment_option', array()));  
		}
                
                $session->set('meta_title', 'Subscribe Confirm');
		
		return $this->render('MapesUserBundle:Default:subscribe_confirm.html.twig', array(
            'temporary_order' => $temporary_order,
			'product' => $product
        ));
	}
	
    public function dashboardAction()
    {
        $session = $this->get('session');
        $session->set('meta_title', 'Dashboard');
        return $this->render('MapesUserBundle:Default:dashboard.html.twig', array(
            
         ));
    }    
    
    public function accountAction()
    {
        $entity  = $this->get('security.context')->getToken()->getUser();
        $form = $this->createForm(new MemberAccountType(), $entity);

        $request = $this->get('request');
        if($request->getMethod() == 'POST') {

                $form->bind($request);

                if ($form->isValid()) {
                        $em = $this->getDoctrine()->getManager();

                        $em->persist($entity);
                        $em->flush();
						
						$this->get('session')->getFlashBag()->add('notice', 'Your changes were saved!');
                        return $this->redirect($this->generateUrl('user_account', array()));  
                }else{
                    //var_dump($form);
                }

        }
        
        $session = $this->get('session');
        $session->set('meta_title', 'Account');
        
        return $this->render('MapesUserBundle:Default:account.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
         ));
    }    
	
	public function forgotAction()
	{
		$found = false;
		$email = "";
		
		$request = $this->get('request');
        if($request->getMethod() == 'POST') {
			$email = $request->request->get('email');
			$em = $this->getDoctrine()->getManager();
			$repository = $em->getRepository('MapesUserBundle:Member');
			$entity = $repository->findOneBy(array('email'=> $email));
			if($entity){
				$found = true;
				
				$length = 8; $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';

				$chars_length = (strlen($chars) - 1);
				$string = $chars{rand(0, $chars_length)};
				for ($i = 1; $i < $length; $i = strlen($string))
				{
					$r = $chars{rand(0, $chars_length)};
					if ($r != $string{$i - 1}) $string .=  $r;
				}
				$newPassword = $string;

				$entity->setPlainPassword($newPassword);
				$em->persist($entity);
                $em->flush();
				$this->get('mail_helper')->retrievePassword($entity, $newPassword);
			}
		}
		
                $session = $this->get('session');
                $session->set('meta_title', 'Password Retrieve');
        
		return $this->render('MapesUserBundle:Default:forgot.html.twig', array(
            'email' => $email,
            'found'   => $found,
         ));
	}
    
}
