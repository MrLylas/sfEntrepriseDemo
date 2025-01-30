<?php

namespace App\Controller;

use App\Entity\Entreprise;
use App\Form\EntrepriseType;
use App\Repository\EntrepriseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class EntrepriseController extends AbstractController
{
    #[Route('/entreprise', name: 'app_entreprise')]
    public function index(EntrepriseRepository $entrepriseRepository): Response
    {
        // $entreprises = $entrepriseRepository->findAll();
        // SELECT * FROM entreprise WHERE ville = "Strasbourg" ORDER BY raisonSociale ASC
        $entreprises = $entrepriseRepository->findAll();
        return $this->render('entreprise/index.html.twig', [
            'entreprises' => $entreprises
        ]);
    }

    #[Route('/entreprise/new', name: 'new_entreprise')]
    #[Route('/entreprise/{id}/edit', name: 'edit_entreprise')]
    public function new_edit(Entreprise $entreprise = null,Request $request,EntityManagerInterface $entityManager): Response
    {
        //Si l'entreprise n'existe pas
        if (!$entreprise) {
            $entreprise = new Entreprise();
        }
        // Si l'entreprise existe
        
        $form = $this->createForm(EntrepriseType::class, $entreprise);

        $form->handleRequest($request);//On prend en charge la requête demandée 

        if ($form->isSubmitted() && $form->isValid()) {//Si le formulaire est envoyé et valide

            $entreprise = $form->getData();//Recuperation des données du formulaire

            $entityManager->persist($entreprise);//Similaire à pdo->prepare

            $entityManager->flush();//Similaire à pdo->execute

            return $this->redirectToRoute('app_entreprise');//Redirection vers la liste des entreprises
        }
        return $this->render('entreprise/new.html.twig', [
            'formAddEntreprise' => $form,
            'edit'=>$entreprise->getId()
        ]);
    }

    #[Route('/entreprise/{id}/delete', name: 'delete_entreprise')]
    public function delete(Entreprise $entreprise,EntityManagerInterface $entityManager): Response
    {
        //Suppression de l'entreprise
        $entityManager->remove($entreprise);
        $entityManager->flush();
        return $this->redirectToRoute('app_entreprise');
    }

    #[Route('/entreprise/{id}', name: 'show_entreprise')]
    public function show(Entreprise $entreprise) : Response
    {
        return $this->render('entreprise/show.html.twig',[
            'entreprise' => $entreprise
        ]);
    }
}
