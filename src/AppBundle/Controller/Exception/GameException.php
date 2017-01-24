<?php
/**
 * This file is part of the Dawn Project.
 *
 * PHP version 7.0
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

namespace AppBundle\Controller\Exception;

/**
 * Class GameException.
 *
 * @category Service
 *
 * @author   Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @license  GNU General Public License, version 3
 *
 * @see     http://opensource.org/licenses/GPL-3.0
 */
class GameException extends \Exception
{
    /**
     * This code force to reload page and identify an error in data.
     */
    const CRITICAL = 8;
    /**
     * This code force to reload page.
     */
    const ERROR = 4;
    /**
     * This code for an information like :: You don't have enough mana to do that.
     */
    const INFO = 2;
    /**
     * This code should not be used, it is for a success message.
     */
    const SUCCESS = 1;
}
