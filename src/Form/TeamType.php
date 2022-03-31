<?php

namespace App\Form;

use App\Entity\Team;
use App\Entity\Tier;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TeamType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $tierRepository = $options['tierRepository'];

        $tiers = $tierRepository->findAll();

        $tierChoices = [];

        foreach ($tiers as $tier)
        {
            $tierChoices += [
              '[GEN ' . $tier->getGeneration() . '] ' . $tier->getName() => $tier->getId()
            ];
        }

        array_multisort($tierChoices, SORT_ASC, SORT_NUMERIC);

        $builder
            ->add('name', TextType::class)
            ->add('paste', TextareaType::class, [
                'mapped' => false
            ])
            ->add('explanations', TextareaType::class)
            ->add('tier', ChoiceType::class, [
                'mapped' => false,
                'choices' => $tierChoices
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Team::class,
        ]);

        $resolver->setRequired('tierRepository');
    }
}
