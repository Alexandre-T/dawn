<?php
/**
 * This file is part of the Simdate Application.
 *
 * PHP version 5.6
 *
 * (c) Alexandre Tranchant <alexandre.tranchant@gmail.com>
 *
 * @category Controller
 *
 * @author    Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @copyright 2016 Alexandre Tranchant
 * @license   GNU General Public License, version 3
 *
 * @see http://opensource.org/licenses/GPL-3.0
 */

namespace AppBundle\Entity\Factory;

use AppBundle\Entity\Characteristic;
use AppBundle\Entity\Game;
use AppBundle\Entity\Score;

/**
 * Score Entity Factory.
 *
 * @category Factory
 *
 * @author  Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @license GNU General Public License, version 3
 *
 * @see http://opensource.org/licenses/GPL-3.0
 */
class ScoreFactory
{
    /**
     * Create a new Score Entity.
     *
     * @param Game           $game
     * @param Characteristic $characteristic
     *
     * @return Score
     */
    public static function create(Game $game, Characteristic $characteristic)
    {
        $score = new Score();
        $score->setGame($game);
        $score->setCharacteristic($characteristic);
        $score->setValue($characteristic->getInitial());

        return $score;
    }
}
