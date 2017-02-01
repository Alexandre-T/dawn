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

use AppBundle\Controller\Exception\GameException;
use AppBundle\Entity\Scene;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

/**
 * Class SceneService.
 *
 * @category Service
 *
 * @author   Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @license  GNU General Public License, version 3
 *
 * @see     http://opensource.org/licenses/GPL-3.0
 */
class SceneService
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
     * SceneService constructor.
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
     * Positionne un scene comme initial, cela s'assure qu'aucune autre scene soit la scene itinitale.
     *
     * @param Scene $scene
     */
    public function setInitial(Scene $scene)
    {
        $oldInitial = $this->repository->findOneByInitial(true);

        if ($oldInitial instanceof Scene) {
            $oldInitial->setInitial(null);
        }

        $scene->setInitial(true);
    }

    /**
     * Trouve le lieu de départ du jeu.
     *
     * @return Scene
     *
     * @throws GameException
     */
    public function findInitial()
    {
        /**
         * @var Scene
         */
        $scene = $this->repository->findOneBy(
            ['initial' => true]
        );
        if ($scene instanceof Scene) {
            return $scene;
        } else {
            throw new GameException('No initial scene. Initial scene is needed to begin any game.', GameException::ERROR);
        }
    }

    /**
     * Find destinations from a scene.
     *
     * @param Scene $scene
     *
     * @throws GameException if there is no corresponding Activity
     *
     * @return array
     */
    public function findByScene(Scene $scene)
    {
        return $this->repository->findBy(['scene' => $scene]);
    }
}
