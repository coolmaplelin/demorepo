<?php

namespace Mapes\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrderItem
 */
class OrderItem
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $order_id;

    /**
     * @var integer
     */
    private $product_id;

    /**
     * @var float
     */
    private $price;

    /**
     * @var integer
     */
    private $quantity;

    /**
     * @var \Mapes\ShopBundle\Entity\OrderEntry
     */
    private $order;

    /**
     * @var \Mapes\ShopBundle\Entity\Product
     */
    private $product;


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
     * Set order_id
     *
     * @param integer $orderId
     * @return OrderItem
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
     * Set product_id
     *
     * @param integer $productId
     * @return OrderItem
     */
    public function setProductId($productId)
    {
        $this->product_id = $productId;
    
        return $this;
    }

    /**
     * Get product_id
     *
     * @return integer 
     */
    public function getProductId()
    {
        return $this->product_id;
    }

    /**
     * Set price
     *
     * @param float $price
     * @return OrderItem
     */
    public function setPrice($price)
    {
        $this->price = $price;
    
        return $this;
    }

    /**
     * Get price
     *
     * @return float 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     * @return OrderItem
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    
        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer 
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set order
     *
     * @param \Mapes\ShopBundle\Entity\OrderEntry $order
     * @return OrderItem
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
     * Set product
     *
     * @param \Mapes\ShopBundle\Entity\Product $product
     * @return OrderItem
     */
    public function setProduct(\Mapes\ShopBundle\Entity\Product $product = null)
    {
        $this->product = $product;
    
        return $this;
    }

    /**
     * Get product
     *
     * @return \Mapes\ShopBundle\Entity\Product 
     */
    public function getProduct()
    {
        return $this->product;
    }
}