<?php

namespace Mapes\CustomFormBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Mapes\CMSBundle\Utils\pageCache as myPageCacheUtils;

class CustomFormEntryAdmin extends Admin
{
    protected $datagridValues = array(
        '_sort_order' => 'DESC',
        '_sort_by' => 'created_at' 
    );

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            //->add('id')
            //->add('custom_form_id')
			->add('custom_form', null, array ( 'label' => 'Form'))
            //->add('form_fields')
            ->add('is_actioned', null, array('label' => 'Actioned'))
			//->add('created_at','doctrine_orm_date_range',['field_type' => 'sonata_type_date_range' , 'field_options'=> array('widget' => 'single_text', 'required' => false, 'attr' => array('class' => 'datepicker'))])

        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            // ->add('id')
			//->add('custom_form_id')
			->add('CustomForm', 'many_to_one', array ( 'label' => 'Form'))
            //->add('form_fields')
            ->add('is_actioned', 'boolean', array('label' => 'Actioned', "editable" => true))
            ->add('created_at')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    //'edit' => array(),
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
            //->add('id')
            //->add('custom_form_id')
			->add('custom_form', null, array ( 'label' => 'Form'))
            ->add('form_fields')
            ->add('is_actioned', null, array('label' => 'Actioned'))
            ->add('created_at')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
		$currentEntry = $this->getSubject();
		
        $showMapper
            //->add('id')
			->add('CustomForm', 'url', array('route' => array(
				'name' => 'admin_mapes_customform_customform_edit',
				'absolute' => true,
				'parameters' => array('id' => $currentEntry->getCustomFormId())
				)
			))
            //->add('form_fields')
            //->add('is_actioned', 'boolean', array('label' => 'Actioned', "editable" => true))
            //->add('created_at')
        ;
		
		
		$formFields = json_decode($currentEntry->getFormFields());
		foreach($formFields as $key => $field){
			
				$title = $field->title;
				$slug = myPageCacheUtils::makeSlug("", strtolower(trim($title)));
				$showMapper->add($slug, null, array ( 'label' => $title));
					
				
		}     

		$showMapper
            ->add('is_actioned', 'boolean', array('label' => 'Actioned', "editable" => true))
            ->add('created_at')
        ;	
		
    }
	
	protected function configureRoutes(RouteCollection $collection) {
		$collection->remove('edit');
	}
	
    public function getTemplate($name)
    {
        switch ($name) {
            case 'show':
                return 'MapesCustomFormBundle:CustomFormEntryAdmin:show.html.twig';
                break;
            default:
                return parent::getTemplate($name);
                break;
        }
    }    
	
}
