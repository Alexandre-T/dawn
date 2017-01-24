<?php
/**
 * This file is part of the JDR Application.
 *
 * PHP version 5
 *
 * (c) Alexandre Tranchant <alexandre.tranchant@gmail.com>
 *
 * @category  Testing
 *
 * @author    Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @copyright 2015 Alexandre Tranchant
 * @license   GNU General Public License, version 3
 *
 * @see      http://opensource.org/licenses/GPL-3.0
 */

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Abstract Controller Web test case.
 *
 * @category Testing
 *
 * @author   Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @license  GNU General Public License, version 3
 *
 * @see     http://opensource.org/licenses/GPL-3.0
 */
abstract class AbstractControllerTest extends WebTestCase
{
    /**
     * Teste l'existence d'un Noeud,
     * Teste l'existence d'un attribut à ce noeud
     * Teste la valeur de cet attribut.
     *
     * @param Crawler $crawler
     * @param array   $tests
     */
    protected function executeNodeTests($crawler, $tests)
    {
        //Execution des tests
        foreach ($tests as $test) {
            $node = $crawler->filter($test['id']);
            self::assertNotEmpty($node, "Node {$test['id']} does not exists");
            if ('html' == $test['attr']) {
                self::assertContains($test['value'], $node->html(), "{$test['id']}.{$test['attr']} has not a good value");
            } else {
                self::assertNotNull($node->attr($test['attr']), "Attr {$test['attr']} of node {$test['id']} does not exists");
                self::assertContains($test['value'], $node->attr($test['attr']), "{$test['id']}.{$test['attr']} has not a good value");
            }
        }
    }
}
