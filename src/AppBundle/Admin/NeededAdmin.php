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

use AppBundle\Entity\Needed;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Validator\ErrorElement;

/**
 * Needed Admin Interface.
 *
 * @category AdminInterface
 *
 * @author  Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @license GNU General Public License, version 3
 *
 * @link http://opensource.org/licenses/GPL-3.0
 */
class NeededAdmin extends AbstractAdmin
{
    /**
     * Setup Form Fields.
     *
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('scene', null, [
                'label' => 'txt.scene'
            ])
            ->add('characteristic', null, [
                'label' => 'txt.characteristic',
            ])
            ->add('redirectScene', null, [
                'label' => 'txt.redirectScene'
            ])
            ->add('value', null, ['label' => 'txt.value'])
        ;
    }

    /**
     * Redirect must be different fron scene.
     * @param ErrorElement $errorElement
     * @param mixed $object
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $errorElement
            ->assertCallback([Needed::class, 'validateNeeded'])
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
            ->add('scene', null, ['label' => 'txt.scene'])
            ->add('characteristic', null, [
                'label' => 'txt.characteristic',
                'property' => 'code'
            ])
            ->add('redirectScene', null, ['label' => 'txt.redirectScene'])
            ->add('value', null, ['label' => 'txt.value']);
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
            ->add('characteristic', null, [
                'label' => 'txt.characteristic',
                'associated_property' => 'name',
            ])
            ->add('scene', null, [
                'label' => 'txt.scene',
            ])
            ->add('redirectScene', null, [
                'label' => 'txt.redirectScene',
            ])
            ->add('value', null, [
                'label' => 'txt.value',
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
        return $object instanceof Needed
            ? "Needed {$object->getId()}"
            : 'txt.Needed'; // shown in the breadcrumb on the create view
    }
}
