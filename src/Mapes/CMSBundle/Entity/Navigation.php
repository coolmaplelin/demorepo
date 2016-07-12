<?php

namespace Mapes\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Navigation
 */
class Navigation
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $location;

    /**
     * @var string
     */
    private $element_type;

    /**
     * @var integer
     */
    private $parent_id;

    /**
     * @var string
     */
    private $anchor_text;

    /**
     * @var string
     */
    private $url;

    /**
     * @var integer
     */
    private $page_id;

    /**
     * @var integer
     */
    private $order_num;

    /**
     * @var boolean
     */
    private $is_live;


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
     * Set location
     *
     * @param string $location
     * @return Navigation
     */
    public function setLocation($location)
    {
        $this->location = $location;
    
        return $this;
    }

    /**
     * Get location
     *
     * @return string 
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set element_type
     *
     * @param string $elementType
     * @return Navigation
     */
    public function setElementType($elementType)
    {
        $this->element_type = $elementType;
    
        return $this;
    }

    /**
     * Get element_type
     *
     * @return string 
     */
    public function getElementType()
    {
        return $this->element_type;
    }

    /**
     * Set parent_id
     *
     * @param integer $parentId
     * @return Navigation
     */
    public function setParentId($parentId)
    {
        $this->parent_id = $parentId;
    
        return $this;
    }

    /**
     * Get parent_id
     *
     * @return integer 
     */
    public function getParentId()
    {
        return $this->parent_id;
    }

    /**
     * Set anchor_text
     *
     * @param string $anchorText
     * @return Navigation
     */
    public function setAnchorText($anchorText)
    {
        $this->anchor_text = $anchorText;
    
        return $this;
    }

    /**
     * Get anchor_text
     *
     * @return string 
     */
    public function getAnchorText()
    {
        return $this->anchor_text;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return Navigation
     */
    public function setUrl($url)
    {
        $this->url = $url;
    
        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set page_id
     *
     * @param integer $pageId
     * @return Navigation
     */
    public function setPageId($pageId)
    {
        $this->page_id = $pageId;
    
        return $this;
    }

    /**
     * Get page_id
     *
     * @return integer 
     */
    public function getPageId()
    {
        return $this->page_id;
    }

    /**
     * Set order_num
     *
     * @param integer $orderNum
     * @return Navigation
     */
    public function setOrderNum($orderNum)
    {
        $this->order_num = $orderNum;
    
        return $this;
    }

    /**
     * Get order_num
     *
     * @return integer 
     */
    public function getOrderNum()
    {
        return $this->order_num;
    }

    /**
     * Set is_live
     *
     * @param boolean $isLive
     * @return Navigation
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
    
    public function getNavLink()
    {
        if($this->page){

              $link = $this->page->getFullUrl();

        }else{
              $link = str_replace("'", "", $this->getUrl());
        }

        $link = $link == '' ? "/" : $link;

        return $link;

    } 
    
    
    /**
     * @var \Mapes\CMSBundle\Entity\Page
     */
    private $page;


    /**
     * Set page
     *
     * @param \Mapes\CMSBundle\Entity\Page $page
     * @return Navigation
     */
    public function setPage(\Mapes\CMSBundle\Entity\Page $page = null)
    {
        $this->page = $page;
    
        return $this;
    }

    /**
     * Get page
     *
     * @return \Mapes\CMSBundle\Entity\Page 
     */
    public function getPage()
    {
        return $this->page;
    }
}