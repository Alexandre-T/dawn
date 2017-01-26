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

use AppBundle\Entity\Game;
use AppBundle\Manager\LaunchManager;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Session\Session;

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
class GameControllerTest extends AbstractControllerTest
{
    /**
     * GUID REGEXP.
     */
    const REGEXP = '/[0-9A-F]{8}-[0-9A-F]{4}-[1-5][0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}/i';

    /**
     * Test Game action.
     */
    public function testGame()
    {
        //Initialization
        $index = 0;
        $client = static::createClient();
        $client->request('GET', '/newGame');
        $crawler = $client->request('GET', '/game');

        //Score Tests
        ++$index;
        $tests[$index]['id'] = '#money';
        $tests[$index]['attr'] = 'html';
        $tests[$index]['value'] = '1000 $';

        ++$index;
        $tests[$index]['id'] = '#moral.score';
        $tests[$index]['attr'] = 'html';
        $tests[$index]['value'] = '10';

        ++$index;
        $tests[$index]['id'] = '#day.score';
        $tests[$index]['attr'] = 'html';
        $tests[$index]['value'] = '1';

        ++$index;
        $tests[$index]['id'] = '#time.score';
        $tests[$index]['attr'] = 'html';
        $tests[$index]['value'] = '6:00';

        $this->executeNodeTests($crawler, $tests);
    }

    /**
     * Test New Game Action.
     */
    public function testNewGame()
    {
        $mockUid = 'fc97679f-b223-11e6-bfbf-3860771c5160';

        //We mock Game
        $game = $this
            ->getMockBuilder(Game::class)
            ->getMock();
        $game->expects(self::any())
            ->method('getId')
            ->willReturn($mockUid);

        //We mock the Game
        $launchManager = $this
            ->getMockBuilder(LaunchManager::class)
            ->disableOriginalConstructor()
            ->getMock();
        $launchManager->expects(self::once())
            ->method('start')
            ->willReturn($game);

        //We mock Session to be sure that it's cleaned
        $session = $this
            ->getMockBuilder(Session::class)
            ->getMock();
        $session->expects(self::once())
            ->method('invalidate');
        $session->expects(self::once())
            ->method('set')
            ->with('game', $mockUid)
            ->willReturn(true);

        //Creation de la requête
        $client = static::createClient();
        $container = $client->getContainer();

        //On appelle les Mock
        $container->set('session', $session);
        $container->set('app.launch-manager', $launchManager);

        //On lance la requête
        $client->request('GET', '/newGame');
        $response = $client->getResponse();

        //On vérifie le cookie
        $seen = false;
        foreach ($response->headers->getCookies() as $cookie) {
            if ($cookie instanceof Cookie) {
                if ('uuid' == $cookie->getName()) {
                    self::assertEquals($mockUid, $cookie->getValue(), 'Cookie uuid is equals to mockUuid');
                }
                $seen = true;
            }
        }
        self::assertTrue($seen, 'Cookie "uuid" was not seen in Response');

        //Is redirection OK ?
        self::assertTrue($response->isRedirect('/game'),
            'response is a redirect to /game'
        );
        self::assertEquals(302, $response->getStatusCode());
    }

    /**
     * This test verify there is no game creation during JSON CALL.
     */
    public function testNoCreation()
    {
        //Creation de la requête
        $client = static::createClient();

        $client->request('GET', '/newGame');
        $client->request('GET', '/game');
        $content = $client->getResponse()->getContent();
        self::assertEquals(1, self::findUuid($content, $uuid1));

        $client->request('GET', '/game');
        $content = $client->getResponse()->getContent();
        self::assertEquals(1, self::findUuid($content, $uuid2));

        self::assertEquals($uuid1, $uuid2);

        $client->request('GET', '/answer/1');

        $client->request('GET', '/game');
        $content = $client->getResponse()->getContent();
        self::assertEquals(1, self::findUuid($content, $uuid3));

        self::assertEquals($uuid3, $uuid2);
    }

    /**
     * This test verify that a call to newGame will create a different game.
     */
    public function testRestartGame()
    {
        //Creation de la requête
        $client = static::createClient();

        $client->request('GET', '/newGame');
        $client->request('GET', '/game');
        $content = $client->getResponse()->getContent();
        self::assertEquals(1, self::findUuid($content, $uuid1));

        $client->request('GET', '/newGame');
        $response = $client->getResponse();
        self::assertEquals(302, $response->getStatusCode());
        self::assertTrue($response->isRedirect('/game'));

        $client->request('GET', '/game');
        $content = $client->getResponse()->getContent();
        self::assertEquals(1, self::findUuid($content, $uuid2));

        self::assertNotEquals($uuid1, $uuid2);

        $client->request('GET', '/goto/casino');

        $client->request('GET', '/game');
        $content = $client->getResponse()->getContent();
        self::assertEquals(1, self::findUuid($content, $uuid3));

        self::assertEquals($uuid3, $uuid2);
    }

    /**
     * Functionnal test :
     * I create a game
     * I save its id
     * I create a new game
     * I load the initial game
     * I launch game
     * I am on the first game, not the twice.
     */
    public function testLoadGame()
    {
        $client = static::createClient();

        $client->request('GET', '/newGame');
        $client->request('GET', '/game');
        $content = $client->getResponse()->getContent();
        self::assertEquals(1, self::findUuid($content, $uuid1));

        $client->request('GET', '/newGame');
        $crawler = $client->request('GET', '/loadGame');
        $form = $crawler->selectButton('Charger')->form();
        $field = $form->get('load[uuid]');
        $field->setValue($uuid1[0]);
        $form->set($field);
        $client->submit($form);
        $response = $client->getResponse();
        self::assertTrue($response->isRedirect('/game'));

        $client->request('GET', '/game');
        $content = $client->getResponse()->getContent();
        self::assertEquals(1, self::findUuid($content, $uuid2));
        self::assertEquals($uuid1, $uuid2);
    }

    /**
     * Functionnal test :
     * I have no game Id in session nor cookie
     * I go on gameAction
     * I am redirected on new-game-confirm.
     */
    public function testNoGameId()
    {
        $client = static::createClient();

        $client->request('GET', '/game');
        $response = $client->getResponse();
        self::assertEquals(302, $response->getStatusCode());
        self::assertTrue($response->isRedirect('/confirmNewGame'));
        $crawler = $client->followRedirect();
        $form = $crawler->selectButton('Oui')->form();
        $client->submit($form);
        $response = $client->getResponse();
        self::assertEquals(302, $response->getStatusCode());
        self::assertTrue($response->isRedirect('/game'));
    }


    /**
     * Functional test : I'm trying to provide a non-existant answer.
     * Application must throw a GameException handled and returned as a json message.
     */
    public function testAnswer()
    {
        $expected = '{"scene":{"id":2,"dialogue":"DIALOGUE2","image":"image2.png"},"actions":[{"id":4,"coords":"90,58,3","shape":"circle","tooltip":"TOOLTIP4"}],"sentences":[{"id":7,"sentence":"Sentence 3 (Goto 1)"}],"base_dir":"\/images\/scenes\/"}';

        $client = static::createClient();
        $client->request('GET', '/newGame');
        $client->request('GET', '/game');
        $client->request('GET', '/answer/1');
        $response = $client->getResponse();

        self::assertIsJsonResponse($response);
        self::assertEquals($expected, $response->getContent());
    }

    /**
     * Functional test : I'm trying to provide a non-existant answer.
     * Application must throw a GameException handled and returned as a json message.
     */
    public function testAnswerNonExistantAnswer()
    {
        $expected = '{"messages":{"error":["Answer unknown"]}}';

        $client = static::createClient();
        $client->request('GET', '/newGame');
        $client->request('GET', '/game');
        $client->request('GET', '/answer/42');
        $response = $client->getResponse();

        self::assertIsJsonResponse($response);
        self::assertEquals($expected, $response->getContent());
    }


    /**
     * Functional test : I'm trying to provide an unavailable answer.
     * Application must throw a GameException handled and returned as a json message.
     */
    public function testAnswerUnavailableAnswer()
    {
        $expected = '{"messages":{"error":["Answer unavailable from this scene"]}}';

        $client = static::createClient();
        $client->request('GET', '/newGame');
        $client->request('GET', '/game');
        $client->request('GET', '/answer/4');
        $response = $client->getResponse();

        self::assertIsJsonResponse($response);
        self::assertEquals($expected, $response->getContent());
    }

    /**
     * Uuid's Game is put in HTML Source.
     *
     * This method find and return the guuid.
     *
     * @param string $content
     * @param string $uuid
     *
     * @return int
     */
    private static function findUuid($content, &$uuid)
    {
        return preg_match(self::REGEXP, $content, $uuid);
    }
}
