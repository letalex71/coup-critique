<?php


namespace App\Form;


use App\Data\searchTeam;
use App\Entity\Pokemon;
use App\Entity\Tier;
use App\Form\Type\DatalistType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class SearchTeamType extends AbstractType
{

   public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('q', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Rechercher'
                ]
                ])
            ->add('tiers',EntityType::class, [
                'label' => false,
                'required' => false,
                'class' => Tier::class
            ])
            ->add('pokemon', DatalistType::class, [
                'label' => false,
                'required' => false,
                'class' => Pokemon::class
            ])
        ;
    }

   public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
           'data_class' => searchTeam::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
