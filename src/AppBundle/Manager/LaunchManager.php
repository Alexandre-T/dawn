<?php
/**
 * This file is part of the Simdate Application.
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

namespace AppBundle\Manager;

use AppBundle\Controller\Exception\GameException;
use AppBundle\Entity\Characteristic;
use AppBundle\Entity\Factory\ScoreFactory;
use AppBundle\Entity\Game;
use AppBundle\Entity\Repository\GameRepository;
use AppBundle\Entity\Repository\SceneRepository;
use AppBundle\Entity\Scene;
use Doctrine\ORM\EntityManager;

/**
 * Launching game manager.
 *
 * @category Service
 *
 * @author   Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @license  GNU General Public License, version 3
 *
 * @see     http://opensource.org/licenses/GPL-3.0
 */
class LaunchManager
{
    /**
     * @var EntityManager
     */
    public $entityManager;

    /**
     * @var SceneRepository
     */
    private $chrRepository;

    /**
     * @var SceneRepository
     */
    private $sceneRepository;

    /**
     * @var GameRepository
     */
    private $gameRepository;

    /**
     * GameService constructor.
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->chrRepository = $this->entityManager->getRepository('AppBundle:Characteristic');
        $this->gameRepository = $this->entityManager->getRepository('AppBundle:Game');
        $this->sceneRepository = $this->entityManager->getRepository('AppBundle:Scene');
    }

    /**
     * Load a game.
     *
     * @param $uuid
     *
     * @return Game
     *
     * @throws GameException If the loaded game is not in Database
     * @throws GameException If the loaded game is not valid
     */
    public function load($uuid)
    {
        if (empty($uuid)) {
            throw new GameException(
                'Your cookie and session were expired. Please reload a game or restart a new one !',
                GameException::ERROR);
        }
        /** @var Game $game */
        $game = $this->gameRepository->findOneByUuid($uuid);
        if (empty($game)) {
            throw new GameException(
                'This game can not be loaded. Please reload a game or restart a new one !',
                GameException::ERROR
            );
        }
        if ($game instanceof Game) {
            if ($this->verify($game)) {
                return $game;
            } else {
                throw new GameException(
                    'This game is too old to be played. Please restart a new game !',
                    GameException::ERROR
                );
            }
        } else {
            throw new GameException(
                'Game was not correctly saved. Please restart a new game !',
                GameException::ERROR
            );
        }
    }

    /**
     * Crée une nouvelle partie et l'enregistre.
     *
     * @throws GameException
     *
     * @return Game
     */
    public function start()
    {
        $scene = $this->sceneRepository->findInitial();
        if (!$scene instanceof Scene) {
            throw new GameException(
                'There is no initial scene.',
                GameException::CRITICAL
            );
        }
        $newGame = new Game();
        $newGame->setCurrentScene($scene);

        $characteristics = $this->chrRepository->findAll();
        foreach ($characteristics as $characteristic) {
            /* @var $characteristic Characteristic */
            $this->entityManager->persist(ScoreFactory::create($newGame, $characteristic));
        }

        $this->entityManager->persist($newGame);
        $this->entityManager->flush();

        return $newGame;
    }

    /**
     * Vérifie qu'une partie existe belle et bien en base.
     *
     * @param Game $game
     *
     * @return bool
     */
    public function verify(Game $game)
    {
        return 0 === version_compare($game->getVersion(), Game::VERSION);
    }
}
