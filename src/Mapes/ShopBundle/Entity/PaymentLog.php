<?php

namespace Mapes\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PaymentLog
 */
class PaymentLog
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $created_at;

    /**
     * @var integer
     */
    private $order_id;

    /**
     * @var float
     */
    private $amount;

    /**
     * @var string
     */
    private $eway_auth_code;

    /**
     * @var boolean
     */
    private $is_successful;

    /**
     * @var string
     */
    private $response_text;

    /**
     * @var string
     */
    private $trxnReference;

    /**
     * @var string
     */
    private $payment_type;

    /**
     * @var string
     */
    private $gateway;

    /**
     * @var \Mapes\ShopBundle\Entity\OrderEntry
     */
    private $order;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return PaymentLog
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;
    
        return $this;
    }

    /**
     * Get created_at
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set order_id
     *
     * @param integer $orderId
     * @return PaymentLog
     */
    public function setOrderId($orderId)
    {
        $this->order_id = $orderId;
    
        return $this;
    }

    /**
     * Get order_id
     *
     * @return integer 
     */
    public function getOrderId()
    {
        return $this->order_id;
    }

    /**
     * Set amount
     *
     * @param float $amount
     * @return PaymentLog
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    
        return $this;
    }

    /**
     * Get amount
     *
     * @return float 
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set eway_auth_code
     *
     * @param string $ewayAuthCode
     * @return PaymentLog
     */
    public function setEwayAuthCode($ewayAuthCode)
    {
        $this->eway_auth_code = $ewayAuthCode;
    
        return $this;
    }

    /**
     * Get eway_auth_code
     *
     * @return string 
     */
    public function getEwayAuthCode()
    {
        return $this->eway_auth_code;
    }

    /**
     * Set is_successful
     *
     * @param boolean $isSuccessful
     * @return PaymentLog
     */
    public function setIsSuccessful($isSuccessful)
    {
        $this->is_successful = $isSuccessful;
    
        return $this;
    }

    /**
     * Get is_successful
     *
     * @return boolean 
     */
    public function getIsSuccessful()
    {
        return $this->is_successful;
    }

    /**
     * Set response_text
     *
     * @param string $responseText
     * @return PaymentLog
     */
    public function setResponseText($responseText)
    {
        $this->response_text = $responseText;
    
        return $this;
    }

    /**
     * Get response_text
     *
     * @return string 
     */
    public function getResponseText()
    {
        return $this->response_text;
    }

    /**
     * Set trxnReference
     *
     * @param string $trxnReference
     * @return PaymentLog
     */
    public function setTrxnReference($trxnReference)
    {
        $this->trxnReference = $trxnReference;
    
        return $this;
    }

    /**
     * Get trxnReference
     *
     * @return string 
     */
    public function getTrxnReference()
    {
        return $this->trxnReference;
    }

    /**
     * Set payment_type
     *
     * @param string $paymentType
     * @return PaymentLog
     */
    public function setPaymentType($paymentType)
    {
        $this->payment_type = $paymentType;
    
        return $this;
    }

    /**
     * Get payment_type
     *
     * @return string 
     */
    public function getPaymentType()
    {
        return $this->payment_type;
    }

    /**
     * Set gateway
     *
     * @param string $gateway
     * @return PaymentLog
     */
    public function setGateway($gateway)
    {
        $this->gateway = $gateway;
    
        return $this;
    }

    /**
     * Get gateway
     *
     * @return string 
     */
    public function getGateway()
    {
        return $this->gateway;
    }

    /**
     * Set order
     *
     * @param \Mapes\ShopBundle\Entity\OrderEntry $order
     * @return PaymentLog
     */
    public function setOrder(\Mapes\ShopBundle\Entity\OrderEntry $order = null)
    {
        $this->order = $order;
    
        return $this;
    }

    /**
     * Get order
     *
     * @return \Mapes\ShopBundle\Entity\OrderEntry 
     */
    public function getOrder()
    {
        return $this->order;
    }
    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        // Add your code here
		if(!$this->getCreatedAt())
        {
          $this->created_at = new \DateTime();
        } 
    }
}