<?php

namespace App\Form;

use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType ;
use Symfony\Component\Validator\Constraints\Regex;
class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Complet' => 'Complet',
                    'Par Place' => 'Par Place ',
                    
                ],
            ])  
            ->add('date_r')
            ->add('heure_r', TextType::class, [
                'constraints' => [
                    new Regex([
                        'pattern' => '/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/',
                        'message' => 'L\'heure doit être au format HH:MM (par exemple 14:30)',
                    ]),
                ],
            ])
            ->add('reserved_places')
            ->add('Renseignements')
            ->add('user_email')
            ->add('terrain')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
