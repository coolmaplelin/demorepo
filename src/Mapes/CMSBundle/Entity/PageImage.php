<?php

namespace Mapes\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PageImage
 */
class PageImage
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $page_id;
    
    /**
     * @var string
     */
    private $file_path;

    /**
     * @var string
     */
    private $heading;

    /**
     * @var string
     */
    private $description;

    /**
     * @var \Mapes\CMSBundle\Entity\Page
     */
    private $page;


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
     * Set page_id
     *
     * @param integer $pageId
     * @return PageImage
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
     * Set heading
     *
     * @param string $heading
     * @return PageImage
     */
    public function setHeading($heading)
    {
        $this->heading = $heading;
    
        return $this;
    }

    /**
     * Get heading
     *
     * @return string 
     */
    public function getHeading()
    {
        return $this->heading;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return PageImage
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set page
     *
     * @param \Mapes\CMSBundle\Entity\Page $page
     * @return PageImage
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
    /**
     * @var boolean
     */
    private $is_live;


    /**
     * Set is_live
     *
     * @param boolean $isLive
     * @return PageImage
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
     * Set file_path
     *
     * @param string $filePath
     * @return PageImage
     */
    public function setFilePath($filePath)
    {
        $this->file_path = $filePath;
    
        return $this;
    }

    /**
     * Get file_path
     *
     * @return string 
     */
    public function getFilePath()
    {
        return $this->file_path;
    }
    /**
     * @var string
     */
    private $link;

    /**
     * @var string
     */
    private $resizes;

    /**
     * @var string
     */
    private $button_text;


    /**
     * Set link
     *
     * @param string $link
     * @return PageImage
     */
    public function setLink($link)
    {
        $this->link = $link;
    
        return $this;
    }

    /**
     * Get link
     *
     * @return string 
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set resizes
     *
     * @param string $resizes
     * @return PageImage
     */
    public function setResizes($resizes)
    {
        $this->resizes = $resizes;
    
        return $this;
    }

    /**
     * Get resizes
     *
     * @return string 
     */
    public function getResizes()
    {
        return $this->resizes;
    }

    /**
     * Set button_text
     *
     * @param string $buttonText
     * @return PageImage
     */
    public function setButtonText($buttonText)
    {
        $this->button_text = $buttonText;
    
        return $this;
    }

    /**
     * Get button_text
     *
     * @return string 
     */
    public function getButtonText()
    {
        return $this->button_text;
    }
    /**
     * @var integer
     */
    private $order_num;


    /**
     * Set order_num
     *
     * @param integer $orderNum
     * @return PageImage
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
}