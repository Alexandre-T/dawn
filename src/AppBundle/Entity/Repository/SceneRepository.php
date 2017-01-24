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

namespace AppBundle\Entity\Repository;

use AppBundle\Entity\Scene;
use Doctrine\ORM\EntityRepository;

/**
 * Class SceneRepository.
 *
 * @category Repository
 *
 * @author   Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @license  GNU General Public License, version 3
 *
 * @see     http://opensource.org/licenses/GPL-3.0
 */
class SceneRepository extends EntityRepository
{
    /**
     * Return Initial Scene or null.
     *
     * @return null|Scene
     */
    public function findInitial()
    {
        /** @var $scene Scene */
        $scene = $this->findOneBy(['initial' => true]);

        return $scene;
    }
}
