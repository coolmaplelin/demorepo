<?php

namespace Mapes\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Redirect
 */
class Redirect
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $original_url;

    /**
     * @var string
     */
    private $destination_url;


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
     * Set original_url
     *
     * @param string $originalUrl
     * @return Redirect
     */
    public function setOriginalUrl($originalUrl)
    {
        $this->original_url = $originalUrl;
    
        return $this;
    }

    /**
     * Get original_url
     *
     * @return string 
     */
    public function getOriginalUrl()
    {
        return $this->original_url;
    }

    /**
     * Set destination_url
     *
     * @param string $destinationUrl
     * @return Redirect
     */
    public function setDestinationUrl($destinationUrl)
    {
        $this->destination_url = $destinationUrl;
    
        return $this;
    }

    /**
     * Get destination_url
     *
     * @return string 
     */
    public function getDestinationUrl()
    {
        return $this->destination_url;
    }
	
	public $regen_cache = true;
}
