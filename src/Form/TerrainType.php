<?php

namespace App\Form;

use App\Entity\Terrain;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
class TerrainType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_t')
            ->add('nb_places')
            ->add('surface')
            ->add('type_r', ChoiceType::class, [
                'choices' => [
                    'Gazon Naturel' => 'Gazon Naturel',
                    'Gazon Synthetique' => 'Gazon Synthetique',
                    'resine acrylique' => 'resine acrylique',
                    
                ],
            ])  
            ->add('type_c', ChoiceType::class, [
                'choices' => [
                    'Normal' => 'Normal',
                    'Mini' => 'Mini ',
                    
                ],
            ])  
            ->add('prix')
            ->add('img',FileType::class,['mapped'=>false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Terrain::class,
        ]);
    }
}
