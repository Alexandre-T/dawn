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
use AppBundle\Entity\Scene;

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
class LoadSceneData extends AbstractLoadFixture implements FixtureInterface, OrderedFixtureInterface
{
    const ACHIEVEMENT = 0;
    const DIALOGUE = 1;
    const IMAGE = 2;
    const INITIAL = 3;
    const COLUMNS = 4;

    /**
     * Load Scenes.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $csvFile = fopen($this->getCsvRepository().'Scenes.csv', 'r');
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

            $scene = new Scene();
            if (!empty($line[self::ACHIEVEMENT])) {
                $scene->setAchievement($this->getReferencedAchievement($line[self::ACHIEVEMENT]));
            }
            $scene->setDialogue($line[self::DIALOGUE]);
            $scene->setImage((int) $line[self::IMAGE]);

            if (!empty($line[self::INITIAL])) {
                $scene->setInitial(true);
            }

            $this->addReference("scene-{$line[self::IMAGE]}", $scene);
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
        return 30; // the order in which fixtures will be loaded
    }
}
