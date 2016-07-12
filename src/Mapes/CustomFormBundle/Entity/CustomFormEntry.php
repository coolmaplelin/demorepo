<?php

namespace Mapes\CustomFormBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Mapes\CMSBundle\Utils\pageCache as myPageCacheUtils;

/**
 * CustomFormEntry
 */
class CustomFormEntry
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $custom_form_id;

    /**
     * @var string
     */
    private $form_fields;

    /**
     * @var boolean
     */
    private $is_actioned;

    /**
     * @var \DateTime
     */
    private $created_at;

    /**
     * @var \Mapes\CustomFormBundle\Entity\CustomForm
     */
    private $custom_form;


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
     * Set custom_form_id
     *
     * @param integer $customFormId
     * @return CustomFormEntry
     */
    public function setCustomFormId($customFormId)
    {
        $this->custom_form_id = $customFormId;
    
        return $this;
    }

    /**
     * Get custom_form_id
     *
     * @return integer 
     */
    public function getCustomFormId()
    {
        return $this->custom_form_id;
    }

    /**
     * Set form_fields
     *
     * @param string $formFields
     * @return CustomFormEntry
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

    public function getFormFieldsValues()
    {
        $formFields = json_decode($this->form_fields);
		
		$rtnArray = array();
		foreach($formFields as $key => $field){
			
				$title = $field->title;
				$slug = myPageCacheUtils::makeSlug("", strtolower(trim($title)));
				$type = $field->type;
                                $options = explode("\n", $field->options);
                                $option_values = array();
                                foreach($options as $option) {
                                    $option_values[myPageCacheUtils::makeSlug("", strtolower(trim($option)))] = $option;
                                }
				
				$value = $field->value;
				if($type == 'checkbox'){
					$rtnString = "";
					$valueArray = explode("\n", $value);
					foreach($valueArray as $valueSlug){
						if($rtnString != "")
							$rtnString .= ",";
						
						$rtnString .= isset($option_values[$valueSlug]) ? $option_values[$valueSlug] : '';
					}
					$value = $rtnString;
				}elseif($type == 'select' || $type == 'radio'){
					$value = isset($option_values[$value]) ? $option_values[$value] : '';
				}
				
				$rtnArray[$slug] = array(
					'label' => $title,
					'value' => $value
				);
				
		}  
		return $rtnArray;
    }
	
    /**
     * Set is_actioned
     *
     * @param boolean $isActioned
     * @return CustomFormEntry
     */
    public function setIsActioned($isActioned)
    {
        $this->is_actioned = $isActioned;
    
        return $this;
    }

    /**
     * Get is_actioned
     *
     * @return boolean 
     */
    public function getIsActioned()
    {
        return $this->is_actioned;
    }

    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return CustomFormEntry
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
     * Set custom_form
     *
     * @param \Mapes\CustomFormBundle\Entity\CustomForm $customForm
     * @return CustomFormEntry
     */
    public function setCustomForm(\Mapes\CustomFormBundle\Entity\CustomForm $customForm = null)
    {
        $this->custom_form = $customForm;
    
        return $this;
    }

    /**
     * Get custom_form
     *
     * @return \Mapes\CustomFormBundle\Entity\CustomForm 
     */
    public function getCustomForm()
    {
        return $this->custom_form;
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