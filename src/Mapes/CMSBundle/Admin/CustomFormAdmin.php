<?php

namespace Mapes\CMSBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class CustomFormAdmin extends Admin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title')
            ->add('is_live', null, array(
                'label' => 'Live'
                ))
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('title')
            ->add('slug')
            ->add('is_live', null, array(
                'label' => 'Live'
                ))
            ->add('_action', 'actions', array(
                'actions' => array(
                    //'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Form Settings', array('tab' => true))
				->with('General', array('class' => 'col-md-8'))
					->add('title')
					->add('instructions', null, array(
						'attr' => array("class" => "wysiwygme")
						))
					->add('thankyou_title')
					->add('thankyou_content', null, array(
						'attr' => array("class" => "wysiwygme")
						))					
				->end()
				->with('Options', array('class' => 'col-md-4'))
					->add('is_live', null, array(
						'label' => 'Live',
						'attr' => array('class' => 'iphonecheck')
						))
					->add('emails', null, array(
						'label' => 'Administrator Emails'
						))
				->end()
				->with('SEO Essentials', array('class' => 'col-md-4'))        
					->add('meta_title')
					->add('meta_description')
				->end()
			->end()
            ->with('Form Elements', array('tab' => true))
				->with('Fields', array('class' => 'col-md-12'))
					->add('form_fields', null, array(
						'attr' => array("class" => "customformme")
						))    
				->end()
			->end();
            
            
        
        
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('title')
            ->add('slug')
            ->add('emails')
            ->add('form_fields')
            ->add('instructions')
            ->add('thankyou_title')
            ->add('thankyou_content')
            ->add('meta_title')
            ->add('meta_description')
            ->add('is_live')
        ;
    }
    
    public function getTemplate($name)
    {
        switch ($name) {
            case 'edit':
                return 'MapesCMSBundle:CustomFormAdmin:edit.html.twig';
                break;
            default:
                return parent::getTemplate($name);
                break;
        }
    }    
}
