<?php
/**
 * This file is part of the Dawn Project.
 *
 * PHP version 5.6
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
use Symfony\Component\HttpFoundation\JsonResponse;
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
        $gameManager = $this->get('app.game-manager');

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
            'achievements' => $gameManager->getAchievements($game),
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

    /** Give an Answer.
     * @Route("/answer", name="answer_without_id", methods="get")
     * @Route("/answer/{code}", name="answer", methods="get")
     *
     * @param Request $request
     * @param string  $code
     *
     * @return JsonResponse
     */
    public function answerAction(Request $request, $code)
    {
        //Initialization
        $result = [];
        $id = (int) $code;

        //Service call
        $launchManager = $this->get('app.launch-manager');
        $gameManager = $this->get('app.game-manager');

        try {
            //Handle current game
            $game = $launchManager->load($this->getUuid($request));
            //Get Location
            $answer = $gameManager->getAnswer($id);
            $result['influences'] = $gameManager->verifyAnswer($game, $answer);
            $result = array_merge($result, $gameManager->gotoScene($game, $answer->getDestination()));
            $result['base_dir'] = $request->getBasePath().'/images/';
        } catch (GameException $exception) {
            return $this->report($exception, $result);
        }

        //Return the JSON response
        return $this->prepareResponse($result);
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

    /**
     * Prepare the JSON response to send.
     *
     * @param array $result
     *
     * @return JsonResponse
     */
    private function prepareResponse(array $result)
    {
        $response = new JsonResponse();
        //Encode result
        $response->setContent(json_encode($result));
        //Return JsonResponse
        return $response;
    }

    /**
     * Report Exception to browser with a JsonResponse.
     *
     * @param GameException $exception
     * @param array         $result
     *
     * @return JsonResponse
     */
    private function report(GameException $exception, $result = [])
    {
        switch ($exception->getCode()) {
            case GameException::SUCCESS:
                return $this->success($exception->getMessage(), $result);
            case GameException::INFO:
                return $this->info($exception->getMessage(), $result);
            default:
                return $this->error($exception->getMessage(), $result);
        }
    }

    /**
     * Return Error Json message.
     *
     * @param string $message
     * @param array  $result
     *
     * @return JsonResponse
     */
    private function error($message, $result = [])
    {
        return $this->message('error', $message, $result);
    }

    /**
     * Return Info Json message.
     *
     * @param $message
     * @param array $result
     *
     * @return JsonResponse
     */
    private function success($message, $result = [])
    {
        return $this->message('info', $message, $result);
    }

    /**
     * Return Alert Json message.
     *
     * @param $message
     * @param array $result
     *
     * @return JsonResponse
     */
    private function info($message, $result = [])
    {
        return $this->message('info', $message, $result);
    }

    /**
     * Return Json message.
     *
     * @param string $type
     * @param string $message
     * @param array  $result
     *
     * @return JsonResponse
     */
    private function message($type, $message, $result = [])
    {
        //Message de l'application
        $this->get('session')->getFlashBag()->add(
            $type,
            $message
        );

        return $this->prepareResponse($result);
    }
}
