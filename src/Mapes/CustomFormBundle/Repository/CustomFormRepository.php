<?php

namespace Mapes\CustomFormBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * CustomFormRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CustomFormRepository extends EntityRepository
{
    public function getLiveFormBySlug($slug)
    {
        $query = $this->createQueryBuilder('j')
          ->where('j.slug = :slug')
          ->setParameter('slug', $slug)
          ->andWhere('j.is_live = 1')
          ->setMaxResults(1)
          ->getQuery();

        try {
          $form = $query->getSingleResult();
        } catch (\Doctrine\Orm\NoResultException $e) {
          $form = null;
        }

        return $form;
        
    }    
}
