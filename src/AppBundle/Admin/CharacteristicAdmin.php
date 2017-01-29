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
            ->with('Données internes', array('class' => 'col-md-6'))
                ->add('code')
                ->add('name')
                ->add('initial')
                ->add('minimum')
                ->add('maximum')
            ->end()
            ->with('Affichage', array('class' => 'col-md-6'))
                ->add('prefix', null,[
                    'required' => false
                ])
                ->add('suffix', null,[
                    'required' => false
                ])
                ->add('multiply')
                ->add('add')
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
            ->add('id')
            ->add('code');
    }

    /**
     * Setup list mapper.
     *
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('code')
            ->add('name')
            ->add('initial')
            ->add('minimum')
            ->add('maximum')
        ;
    }
}