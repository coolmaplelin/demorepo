<?php

namespace Mapes\CustomFormBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Mapes\CMSBundle\Utils\pageCache as pageCache;

/**
 * CustomForm
 */
class CustomForm
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $slug;

    /**
     * @var string
     */
    private $emails;

    /**
     * @var string
     */
    private $form_fields;

    /**
     * @var string
     */
    private $instructions;

    /**
     * @var string
     */
    private $thankyou_title;

    /**
     * @var string
     */
    private $thankyou_content;

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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return CustomForm
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
     * Set slug
     *
     * @param string $slug
     * @return CustomForm
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
     * Get full url
     *
     * @return string 
     */
    public function getFullUrl()
    {
        return "/form/".$this->slug;
    }
    
    /**
     * Set emails
     *
     * @param string $emails
     * @return CustomForm
     */
    public function setEmails($emails)
    {
        $this->emails = $emails;
    
        return $this;
    }

    /**
     * Get emails
     *
     * @return string 
     */
    public function getEmails()
    {
        return $this->emails;
    }

    /**
     * Set form_fields
     *
     * @param string $formFields
     * @return CustomForm
     */
    public function setFormFields($formFields)
    {
        $this->form_fields = $formFields;
    
        return $this;
    }

    /**
     * Get form_fields
     *
     * @return string 
     */
    public function getFormFields()
    {
        return $this->form_fields;
    }

    /**
     * Set instructions
     *
     * @param string $instructions
     * @return CustomForm
     */
    public function setInstructions($instructions)
    {
        $this->instructions = $instructions;
    
        return $this;
    }

    /**
     * Get instructions
     *
     * @return string 
     */
    public function getInstructions()
    {
        return $this->instructions;
    }

    /**
     * Set thankyou_title
     *
     * @param string $thankyouTitle
     * @return CustomForm
     */
    public function setThankyouTitle($thankyouTitle)
    {
        $this->thankyou_title = $thankyouTitle;
    
        return $this;
    }

    /**
     * Get thankyou_title
     *
     * @return string 
     */
    public function getThankyouTitle()
    {
        return $this->thankyou_title;
    }

    /**
     * Set thankyou_content
     *
     * @param string $thankyouContent
     * @return CustomForm
     */
    public function setThankyouContent($thankyouContent)
    {
        $this->thankyou_content = $thankyouContent;
    
        return $this;
    }

    /**
     * Get thankyou_content
     *
     * @return string 
     */
    public function getThankyouContent()
    {
        return $this->thankyou_content;
    }

    /**
     * Set meta_title
     *
     * @param string $metaTitle
     * @return CustomForm
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
     * @return CustomForm
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
     * @return CustomForm
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
     * @ORM\PrePersist
     */
    public function setSlugValue()
    {
        // Add your code here
        
        $oldSlug = $this->slug;
        $newSlug = "";
        
		$newSlug .= pageCache::makeSlug("", $this->getTitle());
        
        if($oldSlug != $newSlug)
        {
                $this->url = $newSlug;
                if($oldSlug != "" && $oldSlug != $newSlug)
                {
                        //This baby has changed its name. Create a redirect for it
                        pageCache::makeRedirect("form/".$oldSlug, "form/".$newSlug);

                }
        }         
    }
	
    public function __toString()
    {
      return (string)$this->getTitle();
    }    
	
 
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $entries;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->entries = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add entries
     *
     * @param \Mapes\CustomFormBundle\Entity\CustomFormEntry $entries
     * @return CustomForm
     */
    public function addEntrie(\Mapes\CustomFormBundle\Entity\CustomFormEntry $entries)
    {
        $this->entries[] = $entries;
    
        return $this;
    }

    /**
     * Remove entries
     *
     * @param \Mapes\CustomFormBundle\Entity\CustomFormEntry $entries
     */
    public function removeEntrie(\Mapes\CustomFormBundle\Entity\CustomFormEntry $entries)
    {
        $this->entries->removeElement($entries);
    }

    /**
     * Get entries
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEntries()
    {
        return $this->entries;
    }
}