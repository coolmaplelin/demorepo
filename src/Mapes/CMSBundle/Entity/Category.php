<?php

namespace Mapes\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Mapes\CMSBundle\Utils\pageCache as pageCache;

/**
 * Category
 */
class Category
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
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $meta_title;

    /**
     * @var string
     */
    private $meta_description;

    /**
     * @var boolean
     */
    private $is_live;


    /**
     * @var string
     */
    private $promo_image;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $pages;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->pages = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set slug
     *
     * @param string $slug
     * @return Category
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
     * Set title
     *
     * @param string $title
     * @return Category
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Category
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
     * Set meta_title
     *
     * @param string $metaTitle
     * @return Category
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
     * @return Category
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
     * Set is_live
     *
     * @param boolean $isLive
     * @return Category
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
     * Set promo_image
     *
     * @param string $promoImage
     * @return Category
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
     * Add pages
     *
     * @param \Mapes\CMSBundle\Entity\Page $pages
     * @return Category
     */
    public function addPage(\Mapes\CMSBundle\Entity\Page $pages)
    {
        $this->pages[] = $pages;
    
        return $this;
    }

    /**
     * Remove pages
     *
     * @param \Mapes\CMSBundle\Entity\Page $pages
     */
    public function removePage(\Mapes\CMSBundle\Entity\Page $pages)
    {
        $this->pages->removeElement($pages);
    }

    /**
     * Get pages
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPages()
    {
        return $this->pages;
    }
    /**
     * @ORM\PrePersist
     */
    public function setSlugValue()
    {
        // Add your code here
        $oldSlug = $this->url;
        $newSlug = "";
        
		$newSlug .= pageCache::makeSlug("", $this->getTitle());
        
        if($oldSlug != $newSlug)
        {
                $this->url = $newSlug;
                if($oldSlug != "" && $oldSlug != $newSlug)
                {
                        //This baby has changed its name. Create a redirect for it
                        pageCache::makeRedirect("cat/".$oldSlug, "cat/".$newSlug);

                }
        }         
		
    }
	
	public function __toString()
	{
		return $this->title;
	}
}