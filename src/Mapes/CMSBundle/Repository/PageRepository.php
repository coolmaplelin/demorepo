<?php

namespace Mapes\CMSBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Mapes\CMSBundle\Utils\pageCache as pageCache;

/**
 * PageRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PageRepository extends EntityRepository
{
    public function getLivePageBySlug($slug)
    {
        $query = $this->createQueryBuilder('j')
          ->where('j.slug = :slug')
          ->setParameter('slug', $slug)
          ->andWhere('j.is_live = 1')
          ->setMaxResults(1)
          ->getQuery();

        try {
          $page = $query->getSingleResult();
        } catch (\Doctrine\Orm\NoResultException $e) {
          $page = null;
        }

        return $page;
        
    }
    
    public function getRootPages()
    {
        $qb = $this->createQueryBuilder('j')
          ->where('j.parent_id is null');


        $query = $qb->getQuery();

        return $query->getResult();        
    }
    
    public function getChildrenPages($parent_id)
    {
        $query = $this->createQueryBuilder('j')
          ->where('j.parent_id = :parent_id')
          ->setParameter('parent_id', $parent_id)
          ->getQuery();

        return $query->getResult();  

    }
    
    public function getPageSlug($id)
    {
        $page = $this->find($id);
        $parentArray = $this->getParentArray($id);

        $pageSlug = "";
        foreach($parentArray as $pa)
        {
            if($pa->getId() == 1){
                $pageSlug = "index/";
            }else{
                $pageSlug .= pageCache::makeSlug("", $pa->getPageHeading())."/";
            }
        }
        
        $pageSlug .= pageCache::makeSlug("", $page->getPageHeading());
        
        return $pageSlug;
        
    }
    
    public function getParentArray($id)
    {
            $page = $this->find($id);
            
            $rtnArray = array();
            if($page->getParentId() && is_numeric($page->getParentId()) && $page->getParentId() > 0)
            {
                    $parentPage = $this->find($page->getParentId());
                    if($parentPage)
                    {
                            $grandParents = $this->getParentArray($parentPage);
                            if(count($grandParents) > 0)
                            {
                                    $rtnArray = $grandParents;
                            }
                            $rtnArray[] = $parentPage;
                    }
            }
            return $rtnArray;
        
    }
    
}
