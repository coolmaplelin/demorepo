<?php

namespace Mapes\ShopBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Mapes\ShopBundle\Entity\Product as Product;

class ProductAdmin extends Admin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            //->add('id')
            ->add('name')
            ->add('type')
            //->add('price')
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
            //->add('id')
            ->add('name')
            ->add('type')
            ->add('price', 'currency', array('currency' => '$'))
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
			->with('Product Details', array('class' => 'col-md-8'))
				->add('name')
				->add('type', 'choice', array('choices' => Product::getProductTypeList(), 'required' => false))
				->add('price', 'number')
				->add('is_live', null, array(
					'label' => 'Live',
					'attr' => array('class' => 'iphonecheck')
					))
			->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('name')
            ->add('type')
            ->add('price')
            ->add('is_live')
        ;
    }
	
	protected function configureRoutes(RouteCollection $collection) {
		$collection->remove('show');
	}

}
