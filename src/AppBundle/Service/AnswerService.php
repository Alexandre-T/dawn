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
 * @see      http://opensource.org/licenses/GPL-3.0
 */

namespace AppBundle\Service;

use AppBundle\Entity\Answer;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

/**
 * Class AnswerService.
 *
 * @category Service
 *
 * @author   Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @license  GNU General Public License, version 3
 *
 * @see     http://opensource.org/licenses/GPL-3.0
 */
class AnswerService
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
     * AnswerService constructor.
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
     * Return Answer form id or null.
     *
     * @param int $id
     *
     * @return null|Answer
     */
    public function getAnswer(int $id)
    {
        /** @var Answer $answer */
        $answer = $this->repository->find($id);

        return $answer;
    }
}
