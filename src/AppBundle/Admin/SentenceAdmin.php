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

use AppBundle\Entity\Scene;
use AppBundle\Entity\Sentence;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Sentence Admin Interface.
 *
 * @category AdminInterface
 *
 * @author  Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @license GNU General Public License, version 3
 *
 * @link http://opensource.org/licenses/GPL-3.0
 */
class SentenceAdmin extends AbstractAdmin
{
    /**
     * Setup Form Fields.
     *
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('sentence', 'textarea',[
                'label' => 'txt.answer'
            ])
            ->add('destination', 'sonata_type_model', [
                'class' => Scene::class,
                'property' => 'dialogue',
                'required' => false,
                'label' => 'txt.destination'
            ])
            ->setHelps([
                'scenes' => 'help.sentence.scene',
                'destination' => 'help.sentence.destination'
            ])
            //->with('txt.scenes', array('collapsed' => true))
                ->add('scenes', null, [
                    'label' => 'txt.scenes',
                    'expanded' => false,
                    'by_reference' => false,
                    'multiple' => true]
                );
            //->end()
            //Translation
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
//            ->add('scene', null, ['label' => 'txt.scene'], 'entity', array(
//                    'class'         => Scene::class,
//                    'choice_label'  => 'dialogue',
//            ))
            ->add('destination', null, ['label' => 'txt.destination'], 'entity', array(
                'class'         => Scene::class,
                'choice_label'  => 'dialogue',
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
            ->add('sentence', null, ['label' => 'txt.sentence'])
            ->add('scenes', null, ['label' => 'txt.scenes'])
            ->add('destination', null, ['label' => 'txt.destination'])
            //@todo add influence
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
            ->addIdentifier('sentence',null, ['label' => 'txt.sentence'])
            //->add('scene.id', null, ['label' => 'txt.scene.id'])
            //->add('scene.dialogue', null, ['label' => 'txt.dialogue'])
            ->add('destination.id', null, ['label' => 'txt.destination.id'])
            ->add('destination.dialogue', null, ['label' => 'txt.dialogue'])
            ->add('_action', null, [
                'label' => 'txt.action',
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ]
            ]);
        ;
    }

    /**
     * ToString.
     *
     * @param mixed $object
     * @return string
     */
    public function toString($object)
    {
        return $object instanceof Sentence
            ? $object->getDialogue()
            : 'txt.sentence'; // shown in the breadcrumb on the create view
    }
}