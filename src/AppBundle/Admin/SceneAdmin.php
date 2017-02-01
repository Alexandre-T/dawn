<?php
/**
 * This file is part of the Dawn project.
 *
 * PHP version 5.6
 *
 * (c) Alexandre Tranchant <alexandre.tranchant@gmail.com>
 *
 * @category AdminInterface
 *
 * @author    Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @copyright 2017 Alexandre Tranchant
 * @license   GNU General Public License, version 3
 *
 * @see http://opensource.org/licenses/GPL-3.0
 */
namespace AppBundle\Admin;

use AppBundle\Entity\Achievement;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Scene Admin Interface.
 *
 * @category AdminInterface
 *
 * @author  Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @license GNU General Public License, version 3
 *
 * @link http://opensource.org/licenses/GPL-3.0
 */
class SceneAdmin extends AbstractAdmin
{
    /**
     * Setup Form Fields.
     *
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('dialogue', 'textarea',[
                'label' => 'txt.dialogue'
            ])
            ->add('achievement', 'sonata_type_model', [
                'class' => Achievement::class,
                'property' => 'title',
                'required' => false,
                'label' => 'txt.achievement'
            ])
            ->add('media', 'sonata_media_type', [
                'provider' => 'sonata.media.provider.image',
                'context'  => 'default',
                'label'    => 'txt.image'
            ])
            //Translation
            ->setHelps([
                'achievement' => 'help.scene.achievement'
            ]);
    }

    /**
     * Setup Datagrid Filters.
     *
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id', null, ['label' => 'txt.id'])
            ->add('achievement', null, ['label' => 'txt.achievement'], 'entity', array(
                    'class'         => Achievement::class,
                    'choice_label'  => 'title',
            ));
    }

    /**
     * Setup show fields.
     *
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('dialogue', null, ['label' => 'txt.dialogue'])
            ->add('initial', null, ['label' => 'txt.scene.initial'])
            ->add('media', null, [
                'template' => 'AppBundle:CRUD:image_small.html.twig',
                'label' => 'txt.image'
            ])
            ->add('answers', null, [
                'label' => 'txt.answers'
            ])
        ;
    }

    /**
     * Setup list mapper.
     *
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id', null, ['label' => 'txt.id'])
            ->addIdentifier('dialogue',null, ['label' => 'txt.dialogue'])
            ->add('media.id', null, ['label' => 'txt.media.id'])
            ->add('media', 'sonata_media_type', [
                'provider' => 'sonata.media.provider.image',
                'context'  => 'default',
                'label'  => 'txt.image',
            ])
            ->add('achievement.title',null,[
                'label' => 'txt.achievements'
            ])
            ->add('_action', null, [
                'label' => 'txt.action',
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                    'initial' => [
                        'template' => 'AppBundle:CRUD:list__action_initial.html.twig',
                        'route' => 'initial'
                    ]
                ]
            ]);
        ;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        parent::configureRoutes($collection);
        $collection->add('initial', $this->getRouterIdParameter().'/initial');
    }
}