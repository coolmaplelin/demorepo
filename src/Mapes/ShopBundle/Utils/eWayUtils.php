<?php
namespace Mapes\ShopBundle\Utils;

use Mapes\ShopBundle\Utils\eWay\RapidAPI;
use Mapes\ShopBundle\Utils\eWay\CreateAccessCodeRequest;
use Mapes\ShopBundle\Utils\eWay\GetAccessCodeResultRequest;

use Mapes\ShopBundle\Entity\OrderEntry;
use Mapes\ShopBundle\Entity\OrderItem;
use Mapes\ShopBundle\Entity\Product;
use Mapes\ShopBundle\Entity\PaymentLog;
use Mapes\UserBundle\Entity\Member;
use Symfony\Component\HttpKernel\Kernel;

define('EWAY_SANDBOX_API_KEY', 'F9802Cs60itwAJ/OE/xrt/vRQWqtx7xdiKLt7unW5ttczd+i2ptCyu8HuxPYJnEyff3DHa');
define('EWAY_SANDBOX_API_PASSWORD', 'sandbox4Test');
define('EWAY_SANDBOX_REDIRECT_URL', 'http://'.$_SERVER['HTTP_HOST'].'/payment/eway_process');
define('EWAY_LIVE_API_KEY', '60CF3AwyYMWdeGIisxvucB34jTNR6XHxbTmVw13hsAYnnBsHKM3n+YIwPXsfA9FP/CoLHs'); //This API Key is under user Settleto.Dev
define('EWAY_LIVE_API_PASSWORD', 'pay4Settleto');
define('EWAY_LIVE_REDIRECT_URL', 'https://'.$_SERVER['HTTP_HOST'].'/payment/eway_process');

class eWayUtils {
    private $_API_KEY;  
    private $_SANDBOX;
    private $_API_PASSWORD;
    private $_REDIRECT_URL;
	
    private $kernel;
    private $em;
	private $env;
    
    public function __construct(Kernel $kernel, $em) {
        $this->kernel = $kernel;
		$this->em = $em;
		
		$this->env = $this->kernel->getEnvironment();
		
        if($this->env == 'live'){
            $this->_SANDBOX = false;
            $this->_API_KEY = EWAY_LIVE_API_KEY;
            $this->_API_PASSWORD = EWAY_LIVE_API_PASSWORD;
            $this->_REDIRECT_URL = EWAY_LIVE_REDIRECT_URL;
        }else{
            $this->_SANDBOX = true;
            $this->_API_KEY = EWAY_SANDBOX_API_KEY;
            $this->_API_PASSWORD = EWAY_SANDBOX_API_PASSWORD;
            $this->_REDIRECT_URL = EWAY_SANDBOX_REDIRECT_URL;
        }
        
    }
    
    public function getResponseForCreateAccessCode($OrderEntry, $CustomerDetails)
    {
            $eway_params = array();
            $eway_params['sandbox'] = $this->_SANDBOX;
            
            $eway_request =  new CreateAccessCodeRequest();
            $eway_request->Customer->FirstName = $CustomerDetails['first_name'];
            $eway_request->Customer->LastName = $CustomerDetails['last_name'];
            $eway_request->Customer->Email = $CustomerDetails['email'];
            //$eway_request->Customer->Phone = $member->getPhone();
            
            $eway_request->Payment->TotalAmount = 100 * $OrderEntry->getSubtotal();
            
            $eway_request->RedirectUrl = $this->_REDIRECT_URL;
            $eway_request->CancelUrl   = $this->_REDIRECT_URL;
            $eway_request->Method   = 'ProcessPayment';
            $eway_request->TransactionType   = 'Purchase';
            
            
            $service = new RapidAPI($this->_API_KEY, $this->_API_PASSWORD, $eway_params);
            return $service->CreateAccessCode($eway_request);
        
    }
    
    public function getResponseForGetAccessCodeResult($AccessCode){
        
            $eway_params = array();
            $eway_params['sandbox'] = $this->_SANDBOX;
            
            $eway_request = new GetAccessCodeResultRequest();
            $eway_request->AccessCode = $AccessCode;
            $service = new RapidAPI($this->_API_KEY, $this->_API_PASSWORD, $eway_params);
            return $service->GetAccessCodeResult($eway_request);
        
    }
    
    public function processEwayResponse($eway_response, $OrderEntry, $CustomerDetails){
        
            $eway_params = array();
            $eway_params['sandbox'] = $this->_SANDBOX;
            
            $service = new RapidAPI($this->_API_KEY, $this->_API_PASSWORD, $eway_params);
            $ResponseText = "";
            if($eway_response && $eway_response->ResponseMessage){
                $MessageArray = explode(",", $eway_response->ResponseMessage);
                $ResponseText = "";
                foreach ( $MessageArray as $code ) {
                    $message = $service->getMessage($code);
                    $ResponseText .= $code.":".$message . "|";
                }
            }
            
            
            $isComplete = false;
            
            $myPayment = new PaymentLog();
            $myPayment->setOrder($OrderEntry);
            $myPayment->setAmount($eway_response ? $eway_response->TotalAmount : $OrderEntry->getSubtotal());
            $myPayment->setEwayAuthCode($eway_response ? $eway_response->AuthorisationCode : 'local auth');
            $myPayment->setTrxnreference($eway_response ? $eway_response->TransactionID : '');
            $myPayment->setResponseText($ResponseText);
            $myPayment->setGateway('eWay');
        
			if($this->env == 'dev') {
				$isComplete = true;
			}elseif ($eway_response && $eway_response->TransactionStatus) {
                
                $isComplete = true;
                
            }        
			
			if($isComplete) {
				
				$myPayment->setIsSuccessful(1);
				$OrderEntry->setStatus('Paid');
				
				$OrderItem = $OrderEntry->getOrderitems()[0];
				if($OrderItem->getProduct()->getType() == 'MEMBERSHIP') {
					
					$member = new Member();
					$member->setFirstName($CustomerDetails['first_name']);
					$member->setLastName($CustomerDetails['last_name']);
					$member->setUsername($CustomerDetails['username']);
					$member->setEmail($CustomerDetails['email']);
					$member->setPlainPassword($CustomerDetails['plain_password']);
					$member->setAccountType('ROLE_USER');
					$member->setUserType('Gerenal User');
					$member->setIsActivated(1);
					$this->em->persist($member);
					$this->em->flush();
					
					$OrderEntry->setMember($member);
				}

				$this->em->persist($OrderEntry);
				$this->em->flush();

			}else{
				$myPayment->setIsSuccessful(0);
			}
            
            $this->em->persist($myPayment);
            $this->em->flush();
			
            return $myPayment;
    }
}

?>
