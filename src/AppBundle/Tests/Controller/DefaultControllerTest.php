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

/**
 * Default Controller test case.
 *
 * @category Testing
 *
 * @author   Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @license  GNU General Public License, version 3
 *
 * @see     http://opensource.org/licenses/GPL-3.0
 */
class DefaultControllerTest extends AbstractControllerTest
{
    /**
     * In this test, we check the js / css resources.
     */
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        self::assertEquals(200, $client->getResponse()->getStatusCode());
        //Translation tests
        self::assertContains('Dawn', $crawler->filter('h1')->text());
        self::assertContains('Dawn', $crawler->filter('title')->text());

        //Test bootstrap implementation
        $index = 0;
        $tests[$index]['id'] = 'link#bootstrap-css';
        $tests[$index]['attr'] = 'href';
        $tests[$index]['value'] = 'bootstrap.min.css';

        ++$index;
        $tests[$index]['id'] = 'script#bootstrap-js';
        $tests[$index]['attr'] = 'src';
        $tests[$index]['value'] = 'bootstrap.min.js';

        ++$index;
        $tests[$index]['id'] = 'script#tether-js';
        $tests[$index]['attr'] = 'src';
        $tests[$index]['value'] = 'tether.min.js';

        //Test jquery
        ++$index;
        $tests[$index]['id'] = 'script#jquery-js';
        $tests[$index]['attr'] = 'src';
        $tests[$index]['value'] = 'jquery-3.1.1.min.js';

        //Test fontawesome implementation
        ++$index;
        $tests[$index]['id'] = 'link#fontawesome-css';
        $tests[$index]['attr'] = 'href';
        $tests[$index]['value'] = 'font-awesome.min.css';

        //Test Lightbox v2 initialization
        ++$index;
        $tests[$index]['id'] = 'link#lightbox-css';
        $tests[$index]['attr'] = 'href';
        $tests[$index]['value'] = 'lightbox.min.css';

        ++$index;
        $tests[$index]['id'] = 'script#lightbox-js';
        $tests[$index]['attr'] = 'src';
        $tests[$index]['value'] = 'lightbox.min.js';

        //Test Clipboard
        ++$index;
        $tests[$index]['id'] = 'script#clipboard-js';
        $tests[$index]['attr'] = 'src';
        $tests[$index]['value'] = 'clipboard.min.js';

        //Test css Simdate implementation
        ++$index;
        $tests[$index]['id'] = 'link#dawn-css';
        $tests[$index]['attr'] = 'href';
        $tests[$index]['value'] = 'dawn.css';

        //Test notification js implementation
        ++$index;
        $tests[$index]['id'] = 'script#notification-js';
        $tests[$index]['attr'] = 'src';
        $tests[$index]['value'] = 'notification.js';

        //Test Map ressponsive jquery
        ++$index;
        $tests[$index]['id'] = 'script#rwd-js';
        $tests[$index]['attr'] = 'src';
        $tests[$index]['value'] = 'jquery.rwdImageMaps.min.js';

        //Test js simdate IS NOT implemented
        self::assertEmpty($crawler->filter('script#dawn-js'));

        //Test css animate
        ++$index;
        $tests[$index]['id'] = 'link#animate-css';
        $tests[$index]['attr'] = 'href';
        $tests[$index]['value'] = 'animate.min.css';

        //Test Button Default disable
        ++$index;
        $tests[$index]['id'] = '#continue';
        $tests[$index]['attr'] = 'class';
        $tests[$index]['value'] = 'btn btn-secondary disabled';

        $this->executeNodeTests($crawler, $tests);
    }

    /**
     * Test activation of the "continue" button.
     */
    public function testButton()
    {
        $client = static::createClient();

        $client->request('GET', '/newgame');
        $crawler = $client->request('GET', '/');

        //Test Button Default disable
        $tests[0]['id'] = '#continue';
        $tests[0]['attr'] = 'class';
        $tests[0]['value'] = 'btn btn-secondary';

        $this->executeNodeTests($crawler, $tests);
    }

    /**
     * About action tested.
     */
    public function testAbout()
    {
        $client = static::createClient();

        $client->request('GET', '/about');

        self::assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * About action tested.
     */
    public function testContacts()
    {
        $client = static::createClient();

        $client->request('GET', '/contact');

        self::assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
