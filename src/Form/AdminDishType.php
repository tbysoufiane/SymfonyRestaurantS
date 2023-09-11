<?php

namespace App\Form;

use App\Entity\Dish;
use App\Entity\Restaurant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AdminDishType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du plat',
                'attr' => [
                    'class' => 'w3-input w3-border w3-round w3-light-grey',
                ],
            ])
            ->add('restaurant', EntityType::class, [
                'label' => 'Restaurant',
                'class' => Restaurant::class,
                'choice_label' => 'name',
                'expanded' => false,
                'multiple' => false,
                'attr' => [
                    'class' => 'w3-input w3-border w3-round w3-light-grey',
                ],
            ])
            ->add('price', NumberType::class, [
                'label' => 'Prix du plat',
                'attr' => [
                    'class' => 'w3-input w3-border w3-round w3-light-grey',
                    'min' => 1,
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description du plat',
                'attr' => [
                    'class' => 'w3-input w3-border w3-round w3-light-grey',
                ],
            ])
            ->add('valider', SubmitType::class, [
                'label' => 'Créer le plat',
                'attr' => [
                    'class' => 'w3-button w3-black w3-margin-bottom',
                    'style' => 'margin-top:5px;'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Dish::class,
        ]);
    }
}
