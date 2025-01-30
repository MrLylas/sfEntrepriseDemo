<?php

namespace App\Form;

use App\Entity\Employe;
use App\Entity\Entreprise;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use PHPUnit\TextUI\XmlConfiguration\CodeCoverage\Report\Text;

class EmployeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class,[
                'attr' => [
                    'class' => 'form-control', 'placeholder' => 'Nom', 'required' => true,
            ]])
            ->add('prenom',TextType::class,[
                'attr' => [
                    'class' => 'form-control', 'placeholder' => 'Prénom', 'required' => true
                ]
            ])
            ->add('dateNaissance', DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control', 'placeholder' => 'Date de naissance', 'required' => true
                ]
            ])
            ->add('dateEmbauche', DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control', 'placeholder' => 'Date d\'embauche', 'required' => true
                ]
            ])
            ->add('ville',TextType::class,[
                'required' => false,
                'attr' => [
                    'class' => 'form-control', 'placeholder' => 'Ville', 'required' => true
                ]
            ])
            ->add('entreprise', EntityType::class, [
                'class' => Entreprise::class,
                'choice_label' => 'raisonSociale',
                'attr' => [
                    'class' => 'form-control', 'placeholder' => 'Entreprise', 'required' => true
                ]
            ])
            ->add('valider', SubmitType::class,[
                'attr' => [
                    'class' => 'btn btn-success'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Employe::class,
        ]);
    }
}
