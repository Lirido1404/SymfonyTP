<?php


// src/Form/ImageType.php

// src/Form/ImageType.php

namespace App\Form;

use App\Entity\Image;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType; // Importer FileType
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class)
            ->add('auteur', TextType::class, [
                'required' => false,
                'label' => 'Auteur (recherche)'
            ])
            ->add('date', DateType::class)
            ->add('fichier', FileType::class, [ // Ajouter le champ pour le fichier
                'label' => 'Image à uploader',
                'mapped' => false, // Indiquer que ce champ n'est pas mappé à l'entité Image
            ])
            ->add('path', TextType::class, [
                'required' => false,
                'label' => 'Chemin (recherche)'
            ])
            ->add('save', SubmitType::class, ['label' => 'Envoyer image']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Image::class,
        ]);
    }
}


?>