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

namespace AppBundle\Controller;

use AppBundle\Controller\Exception\GameException;
use AppBundle\Form\Type\LoadType;
use AppBundle\Form\Type\NewType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Game Controller Class.
 *
 * @category Bundle
 *
 * @author  Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @license GNU General Public License, version 3
 *
 * @see http://opensource.org/licenses/GPL-3.0
 */
class GameController extends Controller
{
    /**
     * @Route("/game", name="game", methods="get")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function gameAction(Request $request)
    {
        //Call game service
        $launchManager = $this->get('app.launch-manager');

        //Game regeneration
        try {
            $game = $launchManager->load($this->getUuid($request));
        } catch (GameException $gameException) {
            $session = $this->get('session');
            $session->getFlashBag()->add('error', $gameException->getMessage());

            return $this->redirectToRoute('confirm-new-game');
        }
        //We have a game !
        //Return a template
        $response = $this->render('AppBundle:game:index.html.twig', [
            'game' => $game,
        ]);

        $response->headers->setCookie(new Cookie('uuid', $game->getId()));

        return $response;
    }

    /**
     * @Route("/newGame", name="new-game", methods="get")
     *
     * @return RedirectResponse
     */
    public function newGameAction()
    {
        //On récupère la session pour la détruire
        $session = $this->get('session');
        $session->invalidate();

        return $this->createAGame();
    }

    /**
     * @Route("/loadGame", name="load-game")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function loadGameAction(Request $request)
    {
        //Form creation
        $form = $this->createForm(LoadType::class);
        $form->handleRequest($request);

        //Is their a post form ?
        if ($form->isSubmitted() && $form->isValid()) {
            //Try to load game
            $data = $form->getData();
            $launchManager = $this->get('app.launch-manager');
            try {
                $game = $launchManager->load($data['uuid']);
                $session = $this->get('session');
                $session->set('game', $game->getId());
                $response = $this->redirectToRoute('game');
                $response->headers->setCookie(new Cookie('uuid', $game->getId()));

                return $response;
            } catch (GameException $gameException) {
                $form->addError(new FormError($gameException->getMessage()));
            }
        }

        return $this->render('AppBundle:default:load.html.twig', [
            'existingGame' => $this->isExistingGame($request),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/confirmNewGame", name="confirm-new-game")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function confirmNewGameAction(Request $request)
    {
        //Form creation
        $form = $this->createForm(NewType::class);
        $form->handleRequest($request);

        //Is their a post form ?
        if ($form->isSubmitted()) {
            if ($form->get('yes')->isClicked()) {
                return $this->createAGame();
            } else {
                return $this->redirectToRoute('homepage');
            }
        }

        return $this->render('AppBundle:default:confirm-new-game.html.twig', [
            'existingGame' => $this->isExistingGame($request),
            'form' => $form->createView(),
        ]);
    }

    /**
     * Create a game.
     *
     * @return RedirectResponse
     */
    private function createAGame()
    {
        //Game Service
        $launchManager = $this->get('app.launch-manager');
        $session = $this->get('session');
        //Start a new game
        $game = $launchManager->start();
        //Save Game Id in session
        $session->set('game', $game->getId());
        //We prepare the redirection
        $response = $this->redirectToRoute('game');
        //We store gameId in cookie, because Session can die
        $response->headers->setCookie(new Cookie('uuid', $game->getId()));
        //We return response
        return $response;
    }

    /**
     * Retourne l'uuid de la game s'il est contenu en session ou en cookie.
     *
     * @param Request $request
     *
     * @return null|string
     */
    private function getUuid(Request $request)
    {
        $session = $this->get('session');
        $uuid = $session->get('uuid');
        if (empty($uuid)) {
            return $request->cookies->get('uuid');
        } else {
            return $uuid;
        }
    }

    /**
     * Is Uuid game existing ?
     *
     * @param Request $request
     *
     * @return bool
     */
    private function isExistingGame(Request $request)
    {
        $session = $this->get('session');

        return $session->has('uuid') || $request->cookies->has('uuid');
    }
}
