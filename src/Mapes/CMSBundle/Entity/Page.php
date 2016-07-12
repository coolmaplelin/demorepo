<?php

namespace Mapes\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Mapes\CMSBundle\Utils\pageCache as pageCache;
use Mapes\CMSBundle\Utils\arrayUtils as arrayUtils;


/**
 * Page
 */
class Page
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $slug;

    /**
     * @var string
     */
    private $meta_title;

    /**
     * @var string
     */
    private $meta_description;

    /**
     * @var string
     */
    private $page_heading;

    /**
     * @var string
     */
    private $page_content;

    /**
     * @var boolean
     */
    private $is_live;

    /**
     * @var integer
     */
    private $parent_id;

    /**
     * @var boolean
     */
    private $allow_comments;

    /**
     * @var integer
     */
    private $category_id;

    /**
     * @var \DateTime
     */
    private $published_date;

    /**
     * @var string
     */
    private $promo_image;

    /**
     * @var string
     */
    private $promo_heading;

    /**
     * @var string
     */
    private $promo_description;

    /**
     * @var \Mapes\CMSBundle\Entity\Category
     */
    private $category;


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
     * Set slug
     *
     * @param string $slug
     * @return Page
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    
        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set meta_title
     *
     * @param string $metaTitle
     * @return Page
     */
    public function setMetaTitle($metaTitle)
    {
        $this->meta_title = $metaTitle;
    
        return $this;
    }

    /**
     * Get meta_title
     *
     * @return string 
     */
    public function getMetaTitle()
    {
        return $this->meta_title;
    }

    /**
     * Set meta_description
     *
     * @param string $metaDescription
     * @return Page
     */
    public function setMetaDescription($metaDescription)
    {
        $this->meta_description = $metaDescription;
    
        return $this;
    }

    /**
     * Get meta_description
     *
     * @return string 
     */
    public function getMetaDescription()
    {
        return $this->meta_description;
    }

    /**
     * Set page_heading
     *
     * @param string $pageHeading
     * @return Page
     */
    public function setPageHeading($pageHeading)
    {
        $this->page_heading = $pageHeading;
    
        return $this;
    }

    /**
     * Get page_heading
     *
     * @return string 
     */
    public function getPageHeading()
    {
        return $this->page_heading;
    }

    /**
     * Set page_content
     *
     * @param string $pageContent
     * @return Page
     */
    public function setPageContent($pageContent)
    {
        $this->page_content = $pageContent;
    
        return $this;
    }

    /**
     * Get page_content
     *
     * @return string 
     */
    public function getPageContent()
    {
        return $this->page_content;
    }

    /**
     * Set is_live
     *
     * @param boolean $isLive
     * @return Page
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
     * Set parent_id
     *
     * @param integer $parentId
     * @return Page
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
     * Set allow_comments
     *
     * @param boolean $allowComments
     * @return Page
     */
    public function setAllowComments($allowComments)
    {
        $this->allow_comments = $allowComments;
    
        return $this;
    }

    /**
     * Get allow_comments
     *
     * @return boolean 
     */
    public function getAllowComments()
    {
        return $this->allow_comments;
    }

    /**
     * Set category_id
     *
     * @param integer $categoryId
     * @return Page
     */
    public function setCategoryId($categoryId)
    {
        $this->category_id = $categoryId;
    
        return $this;
    }

    /**
     * Get category_id
     *
     * @return integer 
     */
    public function getCategoryId()
    {
        return $this->category_id;
    }

    /**
     * Set published_date
     *
     * @param \DateTime $publishedDate
     * @return Page
     */
    public function setPublishedDate($publishedDate)
    {
        $this->published_date = $publishedDate;
    
        return $this;
    }

    /**
     * Get published_date
     *
     * @return \DateTime 
     */
    public function getPublishedDate()
    {
        return $this->published_date;
    }

    /**
     * Set promo_image
     *
     * @param string $promoImage
     * @return Page
     */
    public function setPromoImage($promoImage)
    {
        $this->promo_image = $promoImage;
    
        return $this;
    }

    /**
     * Get promo_image
     *
     * @return string 
     */
    public function getPromoImage()
    {
        return $this->promo_image;
    }

    /**
     * Set promo_heading
     *
     * @param string $promoHeading
     * @return Page
     */
    public function setPromoHeading($promoHeading)
    {
        $this->promo_heading = $promoHeading;
    
        return $this;
    }

    /**
     * Get promo_heading
     *
     * @return string 
     */
    public function getPromoHeading()
    {
        return $this->promo_heading;
    }

    /**
     * Set promo_description
     *
     * @param string $promoDescription
     * @return Page
     */
    public function setPromoDescription($promoDescription)
    {
        $this->promo_description = $promoDescription;
    
        return $this;
    }

    /**
     * Get promo_description
     *
     * @return string 
     */
    public function getPromoDescription()
    {
        return $this->promo_description;
    }

    /**
     * Set category
     *
     * @param \Mapes\CMSBundle\Entity\Category $category
     * @return Page
     */
    public function setCategory(\Mapes\CMSBundle\Entity\Category $category = null)
    {
        $this->category = $category;
    
        return $this;
    }

    /**
     * Get category
     *
     * @return \Mapes\CMSBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }
  
    /*
     * Manually added
     * Not finished yet, could not get other entity
     */
    public function getParentArray()
    {
		$rtnArray = array();
                
                $parent = $this->parent;
                if($parent){
                        $grandParents = $parent->getParentArray();
                        if(count($grandParents) > 0)
                        {
                                $rtnArray = $grandParents;
                        }
                        $rtnArray[] = $parent;
                }
		return $rtnArray;
    }

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $children;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    public function __toString()
    {
        return $this->getPageHeading();
    }    
    
    /**
     * Add children
     *
     * @param \Mapes\CMSBundle\Entity\Page $children
     * @return Page
     */
    public function addChildren(\Mapes\CMSBundle\Entity\Page $children)
    {
        $this->children[] = $children;
    
        return $this;
    }

    /**
     * Remove children
     *
     * @param \Mapes\CMSBundle\Entity\Page $children
     */
    public function removeChildren(\Mapes\CMSBundle\Entity\Page $children)
    {
        $this->children->removeElement($children);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChildren()
    {
        return $this->children;
    }
    /**
     * @var \Mapes\CMSBundle\Entity\Page
     */
    private $parent;


    /**
     * Set parent
     *
     * @param \Mapes\CMSBundle\Entity\Page $parent
     * @return Page
     */
    public function setParent(\Mapes\CMSBundle\Entity\Page $parent = null)
    {
        $this->parent = $parent;
    
        return $this;
    }

    /**
     * Get parent
     *
     * @return \Mapes\CMSBundle\Entity\Page 
     */
    public function getParent()
    {
        return $this->parent;
    }


    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $images;


    /**
     * Add images
     *
     * @param \Mapes\CMSBundle\Entity\PageImage $images
     * @return Page
     */
    public function addImage(\Mapes\CMSBundle\Entity\PageImage $images)
    {
        $this->images[] = $images;
    
        return $this;
    }

    /**
     * Remove images
     *
     * @param \Mapes\CMSBundle\Entity\PageImage $images
     */
    public function removeImage(\Mapes\CMSBundle\Entity\PageImage $images)
    {
        $this->images->removeElement($images);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getImages()
    {
        $images = array();
        foreach($this->images as $image) {
            $images[] = array(
                'obj' => $image,
                'seq' => $image->getOrderNum()
            );
        }
        
        $images = arrayUtils::aasort($images, 'seq', true);
        
        $newImages = array();
        foreach($images as $item) {
            $newImages[] = $item['obj'];
        }
        
        $this->images = $newImages;
        
        return $this->images;
    }
    
    function getFullUrl()
    {
            if($this->getSlug() == "index")
                    return "/";
            else
                    return "/page/".$this->getSlug();
    }

    /**
     * @ORM\PrePersist
     */
    public function setSlugValue()
    {
        $oldSlug = $this->slug;
        $newSlug = "";
        
        if($this->parent_id != "") {
            // It is weird that at this point, this->parent is still the old value but this->parent_id is the new value
            // So I have to inject the EM into here to get parent obj via this->parent_id, and then work out the new slug , shame on me
            global $kernel;
            if ( 'AppCache' == get_class($kernel) )
            {
               $kernel = $kernel->getKernel();
            }
            $em = $kernel->getContainer()->get( 'doctrine.orm.entity_manager' );        
            $parent = $em->getRepository('MapesCMSBundle:Page')->find($this->parent_id);
            
            if($parent) {
                $this->parent = $parent;
                $parentSlug = $em->getRepository('MapesCMSBundle:Page')->getPageSlug($this->parent_id);
                $newSlug = $parentSlug."/";
            }
        }
        
		$newSlug .= pageCache::makeSlug("", $this->getPageHeading());
        if($this->getID() == 1)
            $newSlug = "index";
        
        if($oldSlug != $newSlug)
        {
                $this->slug = $newSlug;
                if($oldSlug != "" && $oldSlug != $newSlug)
                {
                        //This baby has changed its name. Create a redirect for it
                        pageCache::makeRedirect($oldSlug, $newSlug);

                }
        }   
    }
}