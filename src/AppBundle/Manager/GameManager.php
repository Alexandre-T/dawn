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
use AppBundle\Entity\Achievement;
use AppBundle\Entity\Answer;
use AppBundle\Entity\Game;
use AppBundle\Entity\Influence;
use AppBundle\Entity\Scene;
use AppBundle\Entity\Score;
use AppBundle\Entity\Sentence;
use AppBundle\Service\AchievementService;
use AppBundle\Service\AnswerService;
use AppBundle\Service\GameService;
use Doctrine\Common\Collections\Collection;

/**
 * Game Manager.
 *
 * Game manager provides services to alter a game.
 * First, it test if it is possible to do an action (travel, meet, date)
 * If yes, it call the game service to do it
 * If no, it throw a GameException
 *
 * @category Service
 *
 * @author   Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @license  GNU General Public License, version 3
 *
 * @see     http://opensource.org/licenses/GPL-3.0
 */
class GameManager
{
    /**
     * @var AchievementService
     */
    private $achievementService;

    /**
     * @var AnswerService
     */
    private $answerService;

    /**
     * @var GameService
     */
    private $gameService;

    /**
     * GameManager constructor.
     *
     * @param AchievementService $achievementService
     * @param AnswerService $answerService
     * @param GameService $gameService
     */
    public function __construct(AchievementService $achievementService, AnswerService $answerService, GameService $gameService)
    {
        $this->achievementService = $achievementService;
        $this->answerService = $answerService;
        $this->gameService = $gameService;
    }

    /**
     * @param  int    $id
     * @return Answer
     * @throws GameException
     */
    public function getAnswer($id)
    {
        $answer = $this->answerService->getAnswer($id);
        if (!$answer instanceof Answer){
            throw new GameException('Answer unknown', GameException::ERROR);
        }
        return $answer;
    }

    /**
     * Verify that player can do this answer in the game.
     *
     * @param Game $game
     * @param Answer $answer
     * @throws GameException
     * @return array
     */
    public function verifyAnswer(Game $game, Answer $answer)
    {

        if (! $game->getCurrentScene()->getAnswers()->contains($answer)){
            throw new GameException('Answer unavailable from this scene');
        }
        return $this->alterScore($answer->getInfluences(), $game->getScores());
    }

    /**
     * @param Game $game
     * @return array
     */
    public function getAchievements(Game $game)
    {
        $result = [];

        foreach ($this->achievementService->getAchievements() as $achievement){
            /** @var $achievement Achievement */
            $result[] = array_merge(
                ['done' => $game->getAchievements()->contains($achievement)],
                $achievement->toArray()
            );
        }

        return $result;
    }

    /**
     * Move game to Scene and return elements for JSON.
     *
     * @param Game $game
     * @param Scene $scene
     * @return array {Scene;Actions;Sentences}
     */
    public function gotoScene(Game $game, Scene $scene)
    {
        $result['scene'] = $this->serialize($scene);
        $result['actions'] = $this->serialize($scene->getActions());
        $result['sentences'] = $this->serialize($scene->getSentences());
        if ($achievement = $scene->getAchievement()){
            $game->addAchievement($achievement);
            $result['achievement'] = [$this->serialize($achievement)];
        }

        $game->setCurrentScene($scene);
        $this->gameService->save($game);

        return $result;
    }

    /**
     * @param $object
     * @return array
     */
    private function serialize($object)
    {
        if ($object instanceof Achievement || $object instanceof Answer || $object instanceof Scene || $object instanceof Sentence){
            return $object->toArray();
        }
        $result = [];
        foreach ($object as $value){
            $result[] = $this->serialize($value);
        }
        return $result;
    }

    /**
     * Actions alter scores, let's calculate the change.
     *
     * @param Collection $influences
     * @param Collection $scores
     *
     * @return array key is Stuff code, and value is new quantity in inventory
     */
    private function alterScore(Collection $influences, Collection $scores)
    {
        $result = [];
        foreach ($influences as $influence) {
            /** @var $influence Influence */
            if (0 == $influence->getBonus()) {
                continue;
            }
            foreach ($scores as $score) {
                /** @var $score Score */
                if ($score->getCharacteristic() != $influence->getCharacteristic()) {
                    continue;
                }
                $score->increase($influence->getBonus());
                $result[$score->getCharacteristic()->getCode()] = $score->getScore();
                $this->gameService->save($score);
                break;
            }
        }

        return $result;
    }
}
