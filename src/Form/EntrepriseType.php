<?php

namespace App\Form;

use App\Entity\Entreprise;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use PHPUnit\TextUI\XmlConfiguration\CodeCoverage\Report\Text;

class EntrepriseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('raisonSociale',TextType::class,[
                'attr' => [
                    'class' => 'form-control', 'placeholder' => 'Raison sociale', 'required' => true
                ]
            ])//ATTENTION : Prendre le symfony\component\Form\Extension\Core\Type\TextType
            ->add('dateCreation', DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control', 'placeholder' => 'Date de création', 'required' => true
                ]
            ])//ATTENTION : Prendre le symfony\component\Form\Extension\Core\Type\DateType
            ->add('adresse', TextType::class,[
                'attr' => [
                    'class' => 'form-control', 'placeholder' => 'Adresse', 'required' => true
                ]
            ])
            ->add('cp', TextType::class,[
                'attr' => [
                    'class' => 'form-control', 'placeholder' => 'Code postal', 'required' => true
                ]
            ])
            ->add('ville', TextType::class,[
                'attr' => [
                    'class' => 'form-control', 'placeholder' => 'Ville', 'required' => true
                ]
            ])
            ->add('valider', SubmitType::class,[
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Entreprise::class,
        ]);
    }
}
