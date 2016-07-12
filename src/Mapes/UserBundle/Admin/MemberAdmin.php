<?php
namespace Mapes\UserBundle\Admin;
 
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Mapes\UserBundle\Entity\Member as Member;
 
class MemberAdmin extends Admin
{
    // setup the defaut sort column and order
    protected $datagridValues = array(
        '_sort_order' => 'ASC',
        '_sort_by' => 'id'
    );
    
    /*public function validate(ErrorElement $errorElement, $object)
    {
        $errorElement
            ->with('first_name')
                ->assertNotNull(array())
                ->assertNotBlank()
            ->end()
        ;
    }*/
    
    protected function configureFormFields(FormMapper $formMapper)
    {
        /*$formMapper
        ->with('Name & Email')
            ->add('first_name')
            ->add('last_name')
            ->add('username')
            ->add('email')
        ->with('Access')
            ->add('account_type', 'choice', array('choices' => array('ROLE_USER' => 'ROLE_USER', 'ROLE_SUPER_ADMIN' => 'ROLE_SUPER_ADMIN')))
            //->add('user_type')
            ->add('is_activated', null, array('label' => 'Activated'))                
            ->add('password')
        ->with('Other')
            ->add('phone')
            ->add('photo' ,null, array(
                'attr' => array('class' => 'imageme')
                ))
        ;        */
        
        $formMapper
            ->with('Profile', array('class' => 'col-md-6'))
                ->add('first_name', null, array('required' => true))
                ->add('last_name', null, array('required' => true))
                ->add('username')
                ->add('email', null, array('required' => true))
                ->add('phone')
                ->add('photo' ,null, array(
                    'attr' => array('class' => 'imageme')
                    ))
            ->end()
            ->with('Access', array('class' => 'col-md-6'))
                ->add('account_type', 'choice', array('choices' => Member::getAccountTypeList()))
                ->add('user_type', 'choice', array(
                    'choices' => array('' => '', 'Gerenal User' => 'Gerenal User'),
                    'attr' => array(
                        'hideUnlessDropdownSelected' => 'account_type',
                        'hideUnlessDropdownSelectedValue' => 'ROLE_USER',
                        ),
                    'required' => false
                    ))
                ->add('is_activated', null, array(
					'label' => 'Activated',
					'attr' => array('class' => 'iphonecheck')
					))                
                ->add('plain_password', 'text', array(
                    'required' => (!$this->getSubject() || is_null($this->getSubject()->getId()))
                ))
            ->end()
            ->with('Newsletter', array('class' => 'col-md-6'))
                ->add('newsletters', 'sonata_type_model', array(
                    'required' => false,
                    'by_reference' => false,
                    'expanded' => true,
                    'multiple' => true
                ))
                
            ->end()
        ;
        
    }
    
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('first_name')
            ->add('last_name')
            ->add('username')
            ->add('account_type', 'doctrine_orm_string', array(), 'choice', array('choices' => Member::getAccountTypeList()))
            ->add('user_type')
            ->add('is_activated', null, array('label' => 'Activated'))
            ->add('newsletters')
        ;
    }
    
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('first_name')
            ->add('last_name')
            ->add('username')
            ->add('account_type')
            ->add('user_type')
            ->add('is_activated', 'boolean', array('label' => 'Activated', "editable" => true))
            ->add('newsletters')
            ->add('_action', 'actions', array(
                'actions' => array(
                    //'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }
    
    protected function configureShowField(ShowMapper $showMapper)
    {
        $showMapper
            ->add('first_name')
            ->add('last_name')
            ->add('username')
        ;
    }
    
    public function getTemplate($name)
    {
        switch ($name) {
            default:
                return parent::getTemplate($name);
                break;
        }
    }
}

?>
