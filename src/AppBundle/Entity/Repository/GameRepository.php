<?php
/**
 * This file is part of the Dawn Project.
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

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class GameRepository.
 *
 * @category Repository
 *
 * @author   Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @license  GNU General Public License, version 3
 *
 * @see     http://opensource.org/licenses/GPL-3.0
 */
class GameRepository extends EntityRepository
{
    /**
     * Find a game from Uuid.
     *
     * @param string $uuid
     *
     * @return null|object
     */
    public function findOneByUuid($uuid)
    {
        return $this->findOneBy(['id' => $uuid]);
    }
}
