<?php
/**
 * This file is part of the Simdate Application.
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
use AppBundle\Entity\Characteristic;

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
class LoadCharacteristicData extends AbstractLoadFixture implements FixtureInterface, OrderedFixtureInterface
{
    const CODE = 0;
    const NAME = 1;
    const INITIAL = 2;
    const MINIMUM = 3;
    const MAXIMUM = 4;
    const PREFIX = 5;
    const SUFFIX = 6;
    const MULTIPLY = 7;
    const OFFSET = 8;
    const COLUMNS = 9;

    /**
     * Load Characteristics.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $csvFile = fopen($this->getCsvRepository().'characteristics.csv', 'r');
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

            $characteristic = new Characteristic();
            $characteristic->setCode($line[self::CODE]);
            $characteristic->setName($line[self::NAME]);
            $characteristic->setInitial((int) $line[self::INITIAL]);
            $characteristic->setMinimum((int) $line[self::MINIMUM]);
            $characteristic->setPrefix($line[self::PREFIX]);
            $characteristic->setSuffix($line[self::SUFFIX]);
            $characteristic->setAdd((int) $line[self::OFFSET]);
            if ($characteristic->getMinimum() < (int) ($line[self::MAXIMUM])) {
                $characteristic->setMaximum((int) $line[self::MAXIMUM]);
            }
            if (0 != (int) ($line[self::MULTIPLY])) {
                $characteristic->setMultiply((int) $line[self::MULTIPLY]);
            }
            $this->addReference("characteristic-{$line[self::CODE]}", $characteristic);
            $manager->persist($characteristic);
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
        return 10; // the order in which fixtures will be loaded
    }
}
