<?php

namespace YAFF\Database\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;
use Doctrine\Common\Collections\Criteria;

/**
 * WidgetRepository
 *
 */
class WidgetRepository extends EntityRepository
{
    /**
     * Overwrites the findAll method and returns all widgets sorted by the idx (ascending)
     * @return Array
     */
    public function findAll()
    {
        return $this->findBy(array(), array('idx' => 'ASC'));
    }
    
    /**
     * Returns the widget which is on the left side of the widget with the given id
     * @param type $id
     * @return type
     */
    public function findLeftWidget($idx) {
        $criteria = new Criteria();
        $criteria->where($criteria->expr()->lt('idx', $idx));
        $criteria->orderBy(array('idx' => 'DESC'));
        $criteria->setMaxResults(1);
        return $this->matching($criteria);
    }
    
    /**
     * Returns the widget which is on the right side of the widget with the given id
     * @param type $id
     * @return type
     */
    public function findRightWidget($idx) {
        $criteria = new Criteria();
        $criteria->where($criteria->expr()->gt('idx', $idx));
        $criteria->orderBy(array('idx' => 'ASC'));
        $criteria->setMaxResults(1);
        return $this->matching($criteria);
    }
}
