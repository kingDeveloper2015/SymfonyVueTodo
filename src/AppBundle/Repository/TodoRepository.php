<?php

namespace AppBundle\Repository;

/**
 * TodoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TodoRepository extends \Doctrine\ORM\EntityRepository
{
    public function getTodosNumber()
    {
        $query = $this->getEntityManager()
                ->createQuery(
                    'SELECT t FROM AppBundle:Todo t'
                )
                ->getResult();

        return count($query);
    }
}
