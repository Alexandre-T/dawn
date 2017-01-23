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
 * @link      http://opensource.org/licenses/GPL-3.0
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Characteristic;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Abstract Class LoadFixture.
 *
 * @category LoadDataFixture
 *
 * @author  Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @license GNU General Public License, version 3
 *
 * @link http://opensource.org/licenses/GPL-3.0
 *
 * @codeCoverageIgnore
 */
abstract class AbstractLoadFixture extends AbstractFixture implements ContainerAwareInterface
{
    /**
     * CSV DIRECTORY.
     */
    const CSV_DIRECTORY = 'CSV';

    /**
     * DEV DATA DIRECTORY.
     */
    const TEST_REPOSITORY = 'test';

    /**
     * DEV DATA DIRECTORY.
     */
    const DEV_REPOSITORY = 'dev';

    /**
     * PRODUCTION DATA DIRECTORY.
     */
    const PROD_REPOSITORY = 'prod';

    /**
     * The Container.
     *
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected $container;

    /**
     * Set Container to retrieve Environment data.
     *
     * @param ContainerInterface $container Container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Are we in some environment ?
     *
     * @param array|string $environments Array, string or coma separated string
     *
     * @return bool
     */
    protected function isEnvironment($environments)
    {
        if (!is_array($environments)) {
            $environments = explode(',', $environments);
        }

        return in_array($this->container->get('kernel')->getEnvironment(), $environments);
    }

    /**
     * Return Data directories.
     *
     * @return string
     */
    protected function getCsvRepository()
    {
        if ($this->isEnvironment('dev')) {
            return self::getRepository().self::DEV_REPOSITORY.DIRECTORY_SEPARATOR;
        } elseif ($this->isEnvironment('test')) {
            return self::getRepository().self::TEST_REPOSITORY.DIRECTORY_SEPARATOR;
        }

        return self::getRepository().self::PROD_REPOSITORY.DIRECTORY_SEPARATOR;
    }

    /**
     * Return parent data directory.
     *
     * @return string
     */
    private static function getRepository()
    {
        return
            dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR
            .self::CSV_DIRECTORY.DIRECTORY_SEPARATOR;
    }

    /**
     * Get referenced characteristic.
     *
     * @param $code
     *
     * @return Characteristic
     */
    protected function getReferencedCharacteristic($code)
    {
        /** @var Characteristic $characteristic */
        $characteristic = $this->getMyReference($code, Characteristic::class, 'characteristic');

        return $characteristic;
    }

    /**
     * @param $code
     * @param $class
     * @param $singular
     * @param string $plural
     *
     * @throws \OutOfBoundsException
     *
     * @return object
     */
    private function getMyReference($code, $class, $singular, $plural = '')
    {
        if (empty($plural)) {
            $plural = $singular.'s';
        }
        try {
            $entity = $this->getReference("$singular-$code");
            if (!$entity instanceof $class) {
                throw new \OutOfBoundsException("$singular $code is not an entity of $class. Import stopped, please take a look on $plural.csv file");
            }
        } catch (\OutOfBoundsException $exception) {
            throw new \OutOfBoundsException("$singular $code is not an entity of $class. Import stopped, please take a look on $plural.csv file.\n".$exception->getMessage());
        }

        return $entity;
    }

    /**
     * Is this line Empty ?
     *
     * @param $line
     *
     * @return bool
     */
    protected static function isEmptyLine($line)
    {
        if (is_null($line)) {
            return true;
        }
        if (false === $line) {
            return true;
        }
        if (!is_array($line)) {
            return true;
        }

        return 0 === count($line) || '#' === ltrim(substr($line[0], 0, 1));
    }

    /**
     * Is there thee good number of columns ?
     *
     * @param array $lines      (content of line)
     * @param int   $columns    number of columns intended
     * @param int   $lineNumber current line
     *
     * @return bool
     */
    protected static function areThereColumns(array $lines, $columns, $lineNumber)
    {
        if (count($lines) != $columns) {
            if (1 !== count($lines)) {
                //Message for not empty line
                echo 'Only '.count($lines)." columns line $lineNumber, ".$columns." needed.\n";

                return false;
            }
            //No message for empty lines
            return false;
        }

        return true;
    }
}
