<?php

namespace App\Form;

use App\Entity\Tier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class TierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('generation', ChoiceType::class, [
                'choices' => [
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5,
                    '6' => 6,
                    '7' => 7,
                    '8' => 8,
                ]
            ])
            ->add('name', TextType::class, [
                'constraints' => [
                    new NotBlank([
                       'message' => 'Veuillez remplir ce champs'
                    ]),
                    new Length([
                        'min' => 2,
                        'max' => 30,
                        'minMessage' => 'Le nom doit faire au moins 2 caractères',
                        'maxMessage' => 'Le nom doit faire au maximum 30 caractères'
                    ])
                ]
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Tier::class,
        ]);
    }

}
