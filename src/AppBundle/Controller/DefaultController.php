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

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Default Controller Class.
 *
 * @category Bundle
 *
 * @author  Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @license GNU General Public License, version 3
 *
 * @see http://opensource.org/licenses/GPL-3.0
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage", methods="get")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function indexAction(Request $request)
    {
        return $this->render('AppBundle:default:index.html.twig', [
            'existingGame' => $this->isExistingGame($request),
        ]);
    }

    /**
     * Display information about game.
     *
     * @param Request $request
     * @Route("/about", name="about", methods="get")
     *
     * @return Response
     */
    public function aboutAction(Request $request)
    {
        return $this->render('AppBundle:default:about.html.twig', [
            'existingGame' => $this->isExistingGame($request),
        ]);
    }

    /**
     * Display contact form.
     *
     * @param Request $request
     * @Route("/contact", name="contact", methods="get")
     *
     * @return Response
     */
    public function contactAction(Request $request)
    {
        return $this->render('AppBundle:default:contact.html.twig', [
                'existingGame' => $this->isExistingGame($request),
            ]);
    }

    /**
     * Indique s'il existe une uuid de  game .
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
