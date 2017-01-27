<?php
/**
 * This file is part of the Dawn project.
 *
 * PHP version 5.6
 *
 * (c) Alexandre Tranchant <alexandre.tranchant@gmail.com>
 *
 * @category  LoadDataFixture
 *
 * @author    Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @copyright 2016 Alexandre Tranchant
 * @license   GNU General Public License, version 3
 *
 * @see      http://opensource.org/licenses/GPL-3.0
 */

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Action;

/**
 * Load Actions test data in the database.
 *
 * @category LoadDataFixture
 *
 * @author  Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @license GNU General Public License, version 3
 *
 * @see http://opensource.org/licenses/GPL-3.0
 *
 * @codeCoverageIgnore
 */
class LoadActionData extends AbstractLoadFixture implements FixtureInterface, OrderedFixtureInterface
{
    const ID = 0;
    const SCENE = 1;
    const DESTINATION = 2;
    const SHAPE = 3;
    const COORDS = 4;
    const TOOLTIP = 5;
    const COLUMNS = 6;

    /**
     * Load Actions.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $csvFile = fopen($this->getCsvRepository().'actions.csv', 'r');
        $index = 0;

        while (!feof($csvFile)) {
            ++$index;
            $line = fgetcsv($csvFile, null, ';');
            //Skip empty lines
            if (parent::isEmptyLine($line)) {
                continue;
            }
            //Skip commentary lines
            if (!parent::areThereColumns($line, self::COLUMNS, $index)) {
                continue;
            }

            $action = new Action();
            $scene = $this->getReferencedScene($line[self::SCENE]);
            $action->addScene($scene);
            $scene->addAction($action);

            if (!empty($line[self::DESTINATION])) {
                $action->setDestination($this->getReferencedScene($line[self::DESTINATION]));
            }
            $action->setShape($line[self::SHAPE]);
            $action->setCoords($line[self::COORDS]);
            $action->setTooltip($line[self::TOOLTIP]);
            $this->addReference("answer-{$line[self::ID]}", $action);

            $manager->persist($action);
            $manager->persist($scene);
        }
        $manager->flush();
    }

    /**
     * Order of these data to be load.
     *
     * @return int
     */
    public function getOrder()
    {
        return 50; // the order in which fixtures will be loaded
    }
}
