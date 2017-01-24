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
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Regex;

/**
 * Load Game Form.
 *
 * @category Form
 *
 * @author  Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @license GNU General Public License, version 3
 *
 * @see http://opensource.org/licenses/GPL-3.0
 */
class LoadType extends AbstractType
{
    const REGEXP = '/([a-fA-F0-9]{8}-[a-fA-F0-9]{4}-[a-fA-F0-9]{4}-[a-fA-F0-9]{4}-[a-fA-F0-9]{12})/';

    /**
     * Build Form.
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('uuid', TextType::class, [
                'label' => 'loadtype.label',
                'constraints' => new Regex([
                    'pattern' => self::REGEXP,
                    'message' => 'message.key.not_valid',
                ]),
                'attr' => [
                    'placeholder' => '00000000-0000-0000-0000-000000000000',
                    'pattern' => '^[0-9A-Fa-f]{8}\-[0-9A-Fa-f]{4}\-[0-9A-Fa-f]{4}\-[0-9A-Fa-f]{4}\-[0-9A-Fa-f]{12}$',
                    'data-help' => 'message.key.help',
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'btn.load',
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
