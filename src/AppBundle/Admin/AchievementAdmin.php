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
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Achievement Admin Interface.
 *
 * @category AdminInterface
 *
 * @author  Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @license GNU General Public License, version 3
 *
 * @link http://opensource.org/licenses/GPL-3.0
 */
class AchievementAdmin extends AbstractAdmin
{
    /**
     * Setup Form Fields.
     *
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $link_parameters = array();
        if ($this->hasParentFieldDescription()) {
            $link_parameters = $this->getParentFieldDescription()->getOption('link_parameters', array());
        }
        if ($this->hasRequest()) {
            $context = $this->getRequest()->get('context', null);
            if (null !== $context) {
                $link_parameters['context'] = $context;
            }
        }

        $formMapper
            ->add('title', 'text', ['label' => 'txt.title'])
            ->add('alternat', 'text', ['label' => 'txt.alternate'])
            ->add('media', 'sonata_type_model_list', ['required' => true], ['link_parameters' => $link_parameters]);
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
            ->add('title', null, ['label' => 'txt.title'])
            ->add('alternat', null, ['label' => 'txt.alternate']);
    }

    /**
     * Setup show fields.
     *
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id', null, ['label' => 'txt.id'])
            ->add('title', null, ['label' => 'txt.title'])
            ->add('alternat', null, ['label' => 'txt.alternate'])
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
            ->addIdentifier('title', null, ['label' => 'txt.title'])
            ->add('alternat', null, ['label' => 'txt.alternate'])
            ->add('media', null, [
                'label'     => 'txt.image',
                'template'  => 'SonataMediaBundle:MediaAdmin:list_image.html.twig',
            ])
        ;
    }

    /**
     * ToString.
     * @param mixed $object
     * @return string
     */
    public function toString($object)
    {
        return $object instanceof Achievement
            ? $object->getTitle()
            : 'Achievement'; // shown in the breadcrumb on the create view
    }
}