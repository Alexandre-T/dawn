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

use AppBundle\Entity\Scene;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Admin CRUD Controller Class.
 *
 * @category Bundle
 *
 * @author  Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @license GNU General Public License, version 3
 *
 * @see http://opensource.org/licenses/GPL-3.0
 */
class AdminController extends CRUDController
{
    /** Set a scene as the initial one.
     * There is no @ before Route.
     * Route("/admin/app/scene/{id}/initial", name="scene-initial", methods="get")
     *
     * @param string $id
     *
     * @return RedirectResponse
     */
    public function initialAction($id = null)
    {
        $scene = $this->admin->getSubject();

        if (!$scene instanceof Scene) {
            throw new NotFoundHttpException(sprintf('Unable to find the scene with id : %s', $id));
        }

        $sceneService = $this->get('app.scene-service');
        $sceneService->setInitial($scene);

        $this->addFlash('sonata_flash_success', sprintf('Scene %s is now the initial scene', $scene->getId()));

        // if you have a filtered list and want to keep your filters after the redirect
        return new RedirectResponse($this->admin->generateUrl('list', $this->admin->getFilterParameters()));
    }
}
