<?php

namespace Mapes\CMSBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Admin\AdminInterface;
use Knp\Menu\ItemInterface as MenuItemInterface;

class RedirectAdmin extends Admin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            //->add('id')
            ->add('original_url')
            ->add('destination_url')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            //->add('id')
            ->add('original_url')
            ->add('destination_url')
            ->add('_action', 'actions', array(
                'actions' => array(
                    //'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                ),
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
            ->add('original_url', null, array(
					'required' => false,
			))
            ->add('destination_url', null, array(
					'required' => false,
			))
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            //->add('id')
            ->add('original_url')
            ->add('destination_url')
        ;
    }
	
	protected function configureRoutes(RouteCollection $collection) {
		$collection->remove('show');
		$collection->add('mapes_cms.admin.redirect.upload', 'upload'); 
		//var_dump($this->getRouterIdParameter());die();
	}
	
	public function getExportFields()
	{
		$ret = array();
		$list = $this->getList();

		$names = array();

		$excluded_columns = array("batch","_action");
		//$excluded_columns = array();

		foreach($list->getElements() as $k=>$v){

			
		if(!in_array($k,$excluded_columns)){
				$ret[] = $k;
				//$names[] = $this->trans(/** @Ignore */ $v->getOption('label'));
				$names[] = $v->getOption('label');
			}
		}
		
		//var_dump($names);die();

		return $ret;
	}
	
    public function getTemplate($name)
    {
        switch ($name) {
            case 'list':
                return 'MapesCMSBundle:RedirectAdmin:list.html.twig';
                break;
            default:
                return parent::getTemplate($name);
                break;
        }
    }
	
}
