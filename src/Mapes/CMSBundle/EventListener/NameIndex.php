<?php

namespace Mapes\CMSBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Mapes\CMSBundle\Entity\Page;
use Mapes\CMSBundle\Entity\Redirect;
use Mapes\CMSBundle\Utils\pageCache as pageCache;

class NameIndex
{
    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        
        if ($entity instanceof Page) {
            // ... do something with the Page
            $rootPages = $entityManager->getRepository('MapesCMSBundle:Page')->getRootPages();
            pageCache::generateNameSelector($rootPages);
            
        }
		
		if ($entity instanceof Redirect && $entity->regen_cache) {
            $Redirects = $entityManager->getRepository('MapesCMSBundle:Redirect')->findAll();
            pageCache::generateStaticRedirect($Redirects);
		}
        
    }
    
    public function postUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        
        if ($entity instanceof Page) {
            // ... do something with the Page
            $rootPages = $entityManager->getRepository('MapesCMSBundle:Page')->getRootPages();
            pageCache::generateNameSelector($rootPages);
        }
		
		if ($entity instanceof Redirect && $entity->regen_cache) {
            $Redirects = $entityManager->getRepository('MapesCMSBundle:Redirect')->findAll();
            pageCache::generateStaticRedirect($Redirects);
		}
    }
    
    public function postRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        
        if ($entity instanceof Page) {
            // ... do something with the Page
            
            $rootPages = $entityManager->getRepository('MapesCMSBundle:Page')->getRootPages();
            pageCache::generateNameSelector($rootPages);
        }
		
		if ($entity instanceof Redirect && $entity->regen_cache) {
            $Redirects = $entityManager->getRepository('MapesCMSBundle:Redirect')->findAll();
            pageCache::generateStaticRedirect($Redirects);
		}
    }
    
}
