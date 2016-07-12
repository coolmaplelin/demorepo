<?php
namespace Mapes\UserBundle\Block;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

use Sonata\CoreBundle\Model\ManagerInterface;
use Sonata\CoreBundle\Validator\ErrorElement;
use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\BlockBundle\Block\BlockContextInterface;

use Sonata\AdminBundle\Form\FormMapper;
#use Sonata\AdminBundle\Validator\ErrorElement;
use Doctrine\ORM\EntityManager;

class RecentMembersBlockService extends BaseBlockService
{
    private $em;
    /**
    * @param string $name
    * @param EngineInterface $templating
    * @param ManagerInterface $manager
    */
    //public function __construct($name, EngineInterface $templating, ManagerInterface $manager)
    public function __construct($name, EngineInterface $templating, EntityManager $entityManager)
    {
        parent::__construct($name, $templating);
        $this->em = $entityManager;
    }
	
    /**
    * {@inheritdoc}
    */
    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'title' => 'Recent Created Members',
            'template' => 'MapesUserBundle:Block:recent_members_block.html.twig'
        ));
    }    
    
    /**
    * {@inheritdoc}
    */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $parameters = array(
            'context' => $blockContext,
            'settings' => $blockContext->getSettings(),
            'block' => $blockContext->getBlock(),
            //'pager' => $this->manager->getPager($criteria, 1, $blockContext->getSetting('number'))
            'members' => $this->em->getRepository('MapesUserBundle:Member')->getRecentCreatedMembers(5)
        );
        
        /*if ($blockContext->getSetting('mode') === 'admin') {
            return $this->renderPrivateResponse($blockContext->getTemplate(), $parameters, $response);
        }*/
		
        #var_dump($parameters['settings']['template']);die();
        #return $this->renderResponse($blockContext->getTemplate(), $parameters, $response);
		
		return $this->renderResponse('MapesUserBundle:Block:recent_members_block.html.twig', $parameters, $response);
    }
    
    /**
    * {@inheritdoc}
    */
    public function validateBlock(ErrorElement $errorElement, BlockInterface $block)
    {
    // TODO: Implement validateBlock() method.
    }
    
    /**
    * {@inheritdoc}
    */
    public function buildEditForm(FormMapper $formMapper, BlockInterface $block)
    {
        $formMapper
			->add('settings', 'sonata_type_immutable_array', array(
            'keys' => array(
                array('url', 'url', array('required' => false)),
                array('title', 'text', array('required' => false)),
            )
        ));
    }
    /**
    * {@inheritdoc}
    */
    public function getName()
    {
        return 'Recent Created Members';
    }
}

?>
