<?php

namespace App\Controller;

use App\Entity\Image;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ImageType;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class GalerieController extends AbstractController
{
    #[Route('/Galerie/{page<\d*>}', name: 'galerie', defaults: ['page' => 1])]
    public function Galerie($page, ManagerRegistry $doctrine)
    {
        // Liste des images
        $images = [
            'rtr.jpg',
            'nissan.jpg',
            'bmwm5.jpg',
            'bmw135i.jpg',
            'bmw135i2.jpg',
            'bmw135i3.jpg',
            'bmwm2t2.jpg',
            'bmwm2t.jpg',
            'bmwe30.jpg',
            'bmwe36.jpg',
            'bmwm2.jpg',
            'bmwe30alpina.jpg'
        ];

        // Calcul de l'index de départ en fonction de la page demandée
        $startIndex = ($page - 1) * 6;
        // Extraire les 6 images correspondantes
        $pagedImages = array_slice($images, $startIndex, 6);

        return $this->render('Galerie.html.twig', [
            'images' => $pagedImages,
            'page' => $page,
        ]);
    }

    #[Route('/galerie/result', name: 'galerie_result', defaults: ['page' => 1])]
    public function galerie_result($page, ManagerRegistry $doctrine, Request $request): Response
    {
        $em = $doctrine->getManager();

        // Récupérer le paramètre 'auteur' de la requête GET pour filtrer les images par auteur
        $auteur = $request->query->get('auteur');

        // Récupérer les images correspondant au filtre d'auteur s'il est spécifié
        if ($auteur) {
            $images = $em->getRepository(Image::class)->findBy(['auteur' => $auteur]);
        } else {
            $images = $em->getRepository(Image::class)->findAll();
        }

        return $this->render('galerie/Galerie.html.twig', [
            'images' => $images,
            'auteurFilter' => $auteur, // Transmettre le filtre d'auteur à la vue
        ]);
    }

    #[Route('/Galerie/insertion', name: 'galerie_insertion')]
    public function insertion(ManagerRegistry $doctrine, Request $request): Response
    {
        // Vérifier si l'utilisateur est autorisé à accéder à cette action
       

        $image = new Image();

        // Créer le formulaire en utilisant l'entité Image
        $form = $this->createForm(ImageType::class, $image);

        // Gérer la soumission du formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Si le formulaire est soumis et valide, traiter les données
            $imageFile = $form->get('fichier')->getData(); // Récupérer le fichier uploadé

            // Si un fichier a été uploadé
            if ($imageFile) {
                // Générer un nouveau nom de fichier unique
                $newFilename = uniqid() . '.' . $imageFile->guessExtension();

                try {
                    // Déplacer le fichier vers le répertoire d'images
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Gérer les erreurs liées à l'upload
                }

                // Stocker le nom du fichier dans l'entité Image
                $image->setFichier($newFilename);
            }

            // Enregistrer l'image dans la base de données
            $entityManager = $doctrine->getManager();
            $entityManager->persist($image);
            $entityManager->flush();

            // Rediriger vers la page de résultat
            return $this->redirectToRoute('galerie_result');
        }

        // Afficher le formulaire avec les erreurs éventuelles
        return $this->render('galerie/insertion.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
