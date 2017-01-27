<?php
/**
 * This file is part of the Dawn project.
 *
 * PHP version 5.6
 *
 * (c) Alexandre Tranchant <alexandre.tranchant@gmail.com>
 *
 * @category  Repository
 *
 * @author    Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @copyright 2016 Alexandre Tranchant
 * @license   GNU General Public License, version 3
 *
 * @link      http://opensource.org/licenses/GPL-3.0
 */

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

/**
 * Class AchievementService.
 *
 * @category Service
 *
 * @author   Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @license  GNU General Public License, version 3
 *
 * @link     http://opensource.org/licenses/GPL-3.0
 */
class AchievementService
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var EntityRepository
     */
    public $repository;

    /**
     * AchievementService constructor.
     *
     * @param EntityManager $entityManager
     * @param string        $repositoryName
     */
    public function __construct(EntityManager $entityManager, $repositoryName)
    {
        $this->em = $entityManager;
        $this->repository = $this->em->getRepository($repositoryName);
    }

    /**
     * Return All Achievement.
     *
     * @return array of Achievement
     */
    public function getAchievements()
    {
        return $this->repository->findAll();
    }
}
