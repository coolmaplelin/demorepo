<?php
namespace Mapes\CMSBundle\Admin;
 
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Mapes\CMSBundle\Utils\pageCache as pageCache;
 
class PageAdmin extends Admin
{
    // setup the defaut sort column and order
    protected $datagridValues = array(
        '_sort_order' => 'ASC',
        '_sort_by' => 'id'
    );
    
    protected function configureFormFields(FormMapper $formMapper)
    {
		//var_dump($this->getRequest()->getSession()->get('session_key'));
		$session = $this->getRequest()->getSession();
		
        $currentPage = $this->getSubject();
        /*
         * $em = $this->modelManager->getEntityManager('MapesCMSBundle:Page');
        $rootPages = $em->getRepository('MapesCMSBundle:Page')->getRootPages();
        $pageTreeArray = pageCache::generatePageTreeArray($rootPages, $currentPage->getId());
         */
        
        
        
        $formMapper
        ->with('Page Settings', array( 'tab' => true))
			->with('General', array('class' => 'col-md-8'))
				->add('page_heading' )
				->add('page_content', null, array(
					'attr' => array("class" => "wysiwygme", 'session_key' => $session->get('session_key'))
					))
				->add('promo_image' ,null, array(
					'attr' => array('class' => 'imageme', 'session_key' => $session->get('session_key'))
					))
				->add('promo_heading') 
				->add('promo_description') 
			->end()
			->with('Options', array('class' => 'col-md-4'))         
				->add('is_live', null, array(
					'label' => 'Live',
					'attr' => array('class' => 'iphonecheck')
					))
				/*->add('parent', 'sonata_type_model', array(
					'required' => false,
					'query'=> $em->createQueryBuilder('c')
							->select('c')
							->from('MapesCMSBundle:Page', 'c')
							->where('c.id <> :id')
							->setParameter('id', $currentPage->getId())
				 ))  */              
					
				->add('published_date', 'sonata_type_datetime_picker', array('required' => false, 'format' => 'dd/MM/yyyy HH:mm'))
				->add('category')
				->add('parent_id', null, array(
						'attr' => array('class' => 'parentme', 'parentmenuID' => 'parentMenus', 'dontAllow' => $this->id($currentPage), 'label' => 'Parent'),
						'required' => false,
					))     
				->add('allow_comments', null, array(
					'label' => 'Comments enabled',
					'attr' => array('class' => 'iphonecheck')
					))
			->end()			
			->with('SEO Essentials', array('class' => 'col-md-4'))        
				->add('meta_title')
				->add('meta_description') 
			->end()
		->end()

		->with('Page Images', array('tab' => true))      
			->with('Images', array('class' => 'col-md-12'))
				->add('page_images' ,'text', array(
					'attr' => array('class' => 'fileuploadme'),
					'required' => false,
					'mapped'=>false,
					'label' => false
					))
			->end()
		->end();

        
        if($this->id($currentPage)) {
            //Edit
        }else{
            //New
            
            
        }
        
    }
    
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('page_heading')
            ->add('slug')
            ->add('is_live', null, array(
                'label' => 'Live'
                ))
        ;
    }
    
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('page_heading')
            ->add('slug')
            ->add('is_live', 'boolean', array(
                'label' => 'Live', "editable" => true
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
    
    protected function configureShowField(ShowMapper $showMapper)
    {
        $showMapper
            ->add('meta_title')
            ->add('meta_description') 
            ->add('page_heading')  
            ->add('page_content') 
            ->add('is_live')
            ->add('parent_id')
            ->add('allow_comments')
            ->add('published_date')
        ;
    }
    
    public function getTemplate($name)
    {
        switch ($name) {
            case 'edit':
                return 'MapesCMSBundle:PageAdmin:edit.html.twig';
                break;
            default:
                return parent::getTemplate($name);
                break;
        }
    }
}

?>
