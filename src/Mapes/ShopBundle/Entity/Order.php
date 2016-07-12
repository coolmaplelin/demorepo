<?php

namespace Mapes\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Order
 */
class Order
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $member_id;

    /**
     * @var string
     */
    private $status;

    /**
     * @var integer
     */
    private $items;

    /**
     * @var float
     */
    private $subtotal;

    /**
     * @var \DateTime
     */
    private $created_at;

    /**
     * @var \DateTime
     */
    private $updated_at;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $orderitems;

    /**
     * @var \Mapes\UserBundle\Entity\Member
     */
    private $member;

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
     * Set member_id
     *
     * @param integer $memberId
     * @return Order
     */
    public function setMemberId($memberId)
    {
        $this->member_id = $memberId;
    
        return $this;
    }

    /**
     * Get member_id
     *
     * @return integer 
     */
    public function getMemberId()
    {
        return $this->member_id;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Order
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set items
     *
     * @param integer $items
     * @return Order
     */
    public function setItems($items)
    {
        $this->items = $items;
    
        return $this;
    }

    /**
     * Get items
     *
     * @return integer 
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Set subtotal
     *
     * @param float $subtotal
     * @return Order
     */
    public function setSubtotal($subtotal)
    {
        $this->subtotal = $subtotal;
    
        return $this;
    }

    /**
     * Get subtotal
     *
     * @return float 
     */
    public function getSubtotal()
    {
        return $this->subtotal;
    }

    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return Order
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
     * Set updated_at
     *
     * @param \DateTime $updatedAt
     * @return Order
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;
    
        return $this;
    }

    /**
     * Get updated_at
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Add orderitems
     *
     * @param \Mapes\ShopBundle\Entity\OrderItem $orderitems
     * @return Order
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

    /**
     * Set member
     *
     * @param \Mapes\UserBundle\Entity\Member $member
     * @return Order
     */
    public function setMember(\Mapes\UserBundle\Entity\Member $member = null)
    {
        $this->member = $member;
    
        return $this;
    }

    /**
     * Get member
     *
     * @return \Mapes\UserBundle\Entity\Member 
     */
    public function getMember()
    {
        return $this->member;
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

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue()
    {
        // Add your code here
		$this->updated_at = new \DateTime();
    }
}
