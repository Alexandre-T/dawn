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
use AppBundle\Entity\Influence;

/**
 * Load News test data in the database.
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
class LoadInfluenceData extends AbstractLoadFixture implements FixtureInterface, OrderedFixtureInterface
{
    const CHARACTERISTIC = 0;
    const ANSWER = 1;
    const BONUS = 2;
    const COLUMNS = 3;

    /**
     * Load Influences.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $csvFile = fopen($this->getCsvRepository().'influences.csv', 'r');
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

            $influence = new Influence();
            $influence->setCharacteristic($this->getReferencedCharacteristic($line[self::CHARACTERISTIC]));
            $influence->setAnswer($this->getReferencedAnswer($line[self::ANSWER]));
            $influence->setBonus($line[self::BONUS]);
            $manager->persist($influence);
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
        return 70; // the order in which fixtures will be loaded
    }
}
