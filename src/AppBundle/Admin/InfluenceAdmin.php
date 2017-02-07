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

use AppBundle\Entity\Influence;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Influence Admin Interface.
 *
 * @category AdminInterface
 *
 * @author  Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @license GNU General Public License, version 3
 *
 * @link http://opensource.org/licenses/GPL-3.0
 */
class InfluenceAdmin extends AbstractAdmin
{
    /**
     * Setup Form Fields.
     *
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('answer', null, [
                'label' => 'txt.answer'
            ])
            ->add('characteristic', null, [
                'label' => 'txt.characteristic',
            ])
            ->add('bonus', null, ['label' => 'txt.bonus'])
        ;
    }

    /**
     * Setup Datagrid Filters.
     *
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('answer', null, ['label' => 'txt.answer'])
            ->add('characteristic', null, [
                'label' => 'txt.characteristic',
                'property' => 'code'
            ])
            ->add('bonus', null, ['label' => 'txt.bonus']);
    }

    /**
     * Setup list mapper.
     *
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id', null, [
                'label' => 'txt.id'
            ])
            ->add('answer', null, [
                'label' => 'txt.answer',
                'associated_property' => 'code',
            ])
            ->add('characteristic', null, [
                'label' => 'txt.characteristic',
                'associated_property' => 'name',
            ])
            ->add('bonus', null, [
                'label' => 'txt.bonus',
            ])
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
        return $object instanceof Influence
            ? "Influence {$object->getId()}"
            : 'txt.influence'; // shown in the breadcrumb on the create view
    }
}
