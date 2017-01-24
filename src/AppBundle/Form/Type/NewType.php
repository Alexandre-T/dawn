<?php
/**
 * Created by PhpStorm.
 * User: alexandre.tranchant
 * Date: 13/12/2016
 * Time: 13:34.
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * New game confirmation Form.
 *
 * @category Form
 *
 * @author  Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @license GNU General Public License, version 3
 *
 * @see http://opensource.org/licenses/GPL-3.0
 */
class NewType extends AbstractType
{
    /**
     * Build Form.
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('yes', SubmitType::class, [
                'label' => 'btn.yes',
                'attr' => ['class' => 'btn btn-primary'],
            ])
            ->add('no', SubmitType::class, [
                'label' => 'btn.no',
                'attr' => ['class' => 'btn btn-default'],
            ])
            ->getForm();
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['method' => 'GET']);
    }
}
