<?php

namespace Mapes\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
/**
 * Member
 */
class Member implements UserInterface, \Serializable
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $first_name;

    /**
     * @var string
     */
    private $last_name;

    /**
     * @var string
     */
    private $username;

    
    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $password;

    /**
     * @var boolean
     */
    private $is_activated;

    /**
     * @var \DateTime
     */
    private $created_at;

    /**
     * @var string
     */
    private $account_type;


    /**
     * @var string
     */
    private $phone;

    /**
     * @var string
     */
    private $photo;

    /**
     * @var string
     */
    private $email_hash;

    public function __toString()
    {
        return $this->first_name." ".$this->last_name;
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
     * Set first_name
     *
     * @param string $firstName
     * @return Member
     */
    public function setFirstName($firstName)
    {
        $this->first_name = $firstName;
    
        return $this;
    }

    /**
     * Get first_name
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * Set last_name
     *
     * @param string $lastName
     * @return Member
     */
    public function setLastName($lastName)
    {
        $this->last_name = $lastName;
    
        return $this;
    }

    /**
     * Get last_name
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Member
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Member
     */
    public function setPassword($password)
    {
        $this->password = $password;
    
        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set is_activated
     *
     * @param boolean $isActivated
     * @return Member
     */
    public function setIsActivated($isActivated)
    {
        $this->is_activated = $isActivated;
    
        return $this;
    }

    /**
     * Get is_activated
     *
     * @return boolean 
     */
    public function getIsActivated()
    {
        return $this->is_activated;
    }

    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return Member
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
     * Set account_type
     *
     * @param string $accountType
     * @return Member
     */
    public function setAccountType($accountType)
    {
        $this->account_type = $accountType;
    
        return $this;
    }

    /**
     * Get account_type
     *
     * @return string 
     */
    public function getAccountType()
    {
        return $this->account_type;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return Member
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    
        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set photo
     *
     * @param string $photo
     * @return Member
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    
        return $this;
    }
    
    /**
     * Set username
     *
     * @param string $username
     * @return Member
     */
    public function setUsername($username)
    {
        $this->username = $username;
    
        return $this;
    }    

    /**
     * Get photo
     *
     * @return string 
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Set email_hash
     *
     * @param string $emailHash
     * @return Member
     */
    public function setEmailHash($emailHash)
    {
        $this->email_hash = $emailHash;
    
        return $this;
    }

    /**
     * Get email_hash
     *
     * @return string 
     */
    public function getEmailHash()
    {
        return $this->email_hash;
    }
	
    public $photo_file;

    protected function getUploadDir()
    {
        return 'uploads/members';
    }

    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    public function getAbsolutePhotoPath()
    {
        return null === $this->photo ? null : __DIR__.'/../../../../web'.$this->photo;
    }    
	
    /**
     * @ORM\PrePersist
     */
    public function preUploadPhoto()
    {
        // Add your code here
        if (null !== $this->photo_file) {
            // do whatever you want to generate a unique name
            $this->photo = '/'.$this->getUploadDir(). '/'. uniqid().'.'.$this->photo_file->guessExtension();
        }        
		
    }

    /**
     * @ORM\PostPersist
     */
    public function uploadPhoto()
    {
        // Add your code here
          if (null === $this->photo_file) {
            return;
          }

          // if there is an error when moving the file, an exception will
          // be automatically thrown by move(). This will properly prevent
          // the entity from being persisted to the database on error
          $this->photo_file->move($this->getUploadRootDir(), $this->photo);

          unset($this->photo_file);        
    }

    /**
     * @ORM\PostRemove
     */
    public function removeUploadPhoto()
    {
        // Add your code here
        if (is_file($this->getAbsolutePhotoPath()) && strpos($this->photo, $this->getUploadDir()) !== false) {
            unlink($this->getAbsolutePhotoPath());
        }
		
    }
    
    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        // Add your code here
        $this->created_at = new \DateTime;
    }

    public function getRoles() {
        $role_array = array();
        $role_array[] = $this->account_type;
        return $role_array;
    }
    
    public function getSalt() {
        
        return "";
        
    }
    
    public function eraseCredentials() {
        
    }
    
    
    public function getUsername() {
        return $this->username;
    }
    
    /**
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
        ));
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
        ) = unserialize($serialized);
    }    


    /**
     * @var string
     */
    private $user_type;


    /**
     * Set user_type
     *
     * @param string $userType
     * @return Member
     */
    public function setUserType($userType)
    {
        $this->user_type = $userType;
    
        return $this;
    }

    /**
     * Get user_type
     *
     * @return string 
     */
    public function getUserType()
    {
        return $this->user_type;
    }
    /**
     * @var string
     */
    private $plain_password;


    /**
     * Set plain_password
     *
     * @param string $plainPassword
     * @return Member
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plain_password = $plainPassword;
    
        return $this;
    }

    /**
     * Get plain_password
     *
     * @return string 
     */
    public function getPlainPassword()
    {
        return $this->plain_password;
    }

    /**
     * @ORM\PrePersist
     */
    public function setPasswordValue()
    {
        // Add your code here
        if($this->plain_password != "") {
            $this->password = md5($this->plain_password);
            $this->plain_password = "";
        }
    }

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $newsletters;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->newsletters = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Add newsletters
     *
     * @param \Mapes\UserBundle\Entity\Newsletter $newsletters
     * @return Member
     */
    public function addNewsletter(\Mapes\UserBundle\Entity\Newsletter $newsletters)
    {
        $this->newsletters[] = $newsletters;
    
        return $this;
    }

    /**
     * Remove newsletters
     *
     * @param \Mapes\UserBundle\Entity\Newsletter $newsletters
     */
    public function removeNewsletter(\Mapes\UserBundle\Entity\Newsletter $newsletters)
    {
        $this->newsletters->removeElement($newsletters);
    }

    /**
     * Get newsletters
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getNewsletters()
    {
        return $this->newsletters;
    }
    
    public static function getAccountTypeList()
    {
        return array(
            'ROLE_USER' => 'ROLE_USER',
            'ROLE_SUPER_ADMIN' => 'ROLE_SUPER_ADMIN',
        );
    }
    
     /*public static function findDuplicatedEmail($object, ExecutionContextInterface $context)
    {
        
       if (in_array($object->getFirstName(), $fakeNames)) {
            // If you're using the new 2.5 validation API (you probably are!)
            $context->buildViolation('This name sounds totally fake!')
                ->atPath('firstName')
                ->addViolation()
            ;

            // If you're using the old 2.4 validation API
            $context->addViolationAt(
                'firstName',
                'This name sounds totally fake!'
            );
        }
    }*/
}