<?php

namespace Mapes\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 */
class Product
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $type;

    /**
     * @var float
     */
    private $price;

    /**
     * @var boolean
     */
    private $is_live;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $orderitems;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->orderitems = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
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
     * Set name
     *
     * @param string $name
     * @return Product
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Product
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set price
     *
     * @param float $price
     * @return Product
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
     * Set is_live
     *
     * @param boolean $isLive
     * @return Product
     */
    public function setIsLive($isLive)
    {
        $this->is_live = $isLive;
    
        return $this;
    }

    /**
     * Get is_live
     *
     * @return boolean 
     */
    public function getIsLive()
    {
        return $this->is_live;
    }

    /**
     * Add orderitems
     *
     * @param \Mapes\ShopBundle\Entity\OrderItem $orderitems
     * @return Product
     */
    public function addOrderitem(\Mapes\ShopBundle\Entity\OrderItem $orderitems)
    {
        $this->orderitems[] = $orderitems;
    
        return $this;
    }

    /**
     * Remove orderitems
     *
     * @param \Mapes\ShopBundle\Entity\OrderItem $orderitems
     */
    public function removeOrderitem(\Mapes\ShopBundle\Entity\OrderItem $orderitems)
    {
        $this->orderitems->removeElement($orderitems);
    }

    /**
     * Get orderitems
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOrderitems()
    {
        return $this->orderitems;
    }
	
	
	public function __toString()
    {
      return (string)$this->getName();
    }    


	public static function getProductTypeList()
	{
        return array(
            'MEMBERSHIP' => 'MEMBERSHIP',
        );
		
	}
}
