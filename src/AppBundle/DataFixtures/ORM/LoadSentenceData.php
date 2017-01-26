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
use AppBundle\Entity\Sentence;

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
class LoadSentenceData extends AbstractLoadFixture implements FixtureInterface, OrderedFixtureInterface
{
    const SCENE = 0;
    const DESTINATION = 1;
    const SENTENCE = 2;
    const COLUMNS = 3;

    /**
     * Load Sentences.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $csvFile = fopen($this->getCsvRepository().'sentences.csv', 'r');
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

            $sentence = new Sentence();
            $scene = $this->getReferencedScene($line[self::SCENE]);
            $sentence->addScene($scene);
            $scene->addSentence($sentence);

            if (!empty($line[self::DESTINATION])) {
                $sentence->setDestination($this->getReferencedScene($line[self::DESTINATION]));
            }
            $sentence->setSentence($line[self::SENTENCE]);
            $this->addReference("answer-{$line[self::SENTENCE]}", $sentence);

            $manager->persist($sentence);
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
