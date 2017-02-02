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

use AppBundle\Entity\Characteristic;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Characteristic Admin Interface.
 *
 * @category AdminInterface
 *
 * @author  Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @license GNU General Public License, version 3
 *
 * @link http://opensource.org/licenses/GPL-3.0
 */
class CharacteristicAdmin extends AbstractAdmin
{
    /**
     * Setup Form Fields.
     *
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Internal data', array('class' => 'col-md-6'))
                ->add('code', null, ['label' => 'txt.code'])
                ->add('name', null, ['label' => 'txt.name'])
                ->add('initial', null, ['label' => 'txt.initial'])
                ->add('minimum', null, ['label' => 'txt.minimum'])
                ->add('maximum', null, ['label' => 'txt.maximum'])
            ->end()
            ->with('Display', array('class' => 'col-md-6'))
                ->add('prefix', null,[
                    'required' => false,
                    'label' => 'txt.prefix'
                ])
                ->add('suffix', null,[
                    'required' => false,
                    'label' => 'txt.suffix',
                ])
                ->add('multiply', null, ['label' => 'txt.multiply'])
                ->add('add', null, ['label' => 'txt.add'])
            ->end()
        ;
    }

    /**
     * @param mixed $alias
     */
    public function prePersist($alias)
    {
        if ($alias instanceof Characteristic)
        {
            if (null === $alias->getPrefix()){
                $alias->setPrefix('');
            }
            if (null === $alias->getSuffix()){
                $alias->setSuffix('');
            }
        }
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
            ->add('code', null, ['label' => 'txt.code']);
    }

    /**
     * Setup list mapper.
     *
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('code', null, ['label' => 'txt.code'])
            ->add('name', null, ['label' => 'txt.name'])
            ->add('initial', null, ['label' => 'txt.initial'])
            ->add('minimum', null, ['label' => 'txt.minimum'])
            ->add('maximum', null, ['label' => 'txt.maximum'])
        ;
    }

    /**
     * @param mixed $object
     * @return string
     */
    public function toString($object)
    {
        return $object instanceof Characteristic
            ? $object->getTitle()
            : 'txt.characteristic'; // shown in the breadcrumb on the create view
    }
}
