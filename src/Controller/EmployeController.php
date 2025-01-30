<?php

namespace App\Controller;

use App\Entity\Employe;
use App\Form\EmployeType;
use App\Repository\EmployeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class EmployeController extends AbstractController
{
    #[Route('/employe', name: 'app_employe')]
    public function index(EmployeRepository $employeRepository): Response
    {
        // $employes = $employeRepository->findAll();
        // SELECT * FROM employe ORDER BY nom ASC
        $employes = $employeRepository->findBy([],["nom"=>"ASC"]);
        return $this->render('employe/index.html.twig', [
            'employes' => $employes
        ]);
    }

    #[Route('/employe/new', name: 'new_employe')]
    #[Route('/employe/{id}/edit', name: 'edit_employe')]
    public function new_edit(Employe $employe = null ,Request $request,EntityManagerInterface $entityManager): Response
    {
        if (!$employe) {
            $employe = new Employe();
        }
        
        $form = $this->createForm(EmployeType::class, $employe);

        $form->handleRequest($request);//On prend en charge la requête demandée 

        if ($form->isSubmitted() && $form->isValid()) {//Si le formulaire est envoyé et valide

            $employe = $form->getData();//Recuperation des données du formulaire

            $entityManager->persist($employe);//Similaire à pdo->prepare

            $entityManager->flush();//Similaire à pdo->execute

            return $this->redirectToRoute('app_employe');//Redirection vers la liste des entreprises
        }
        
        return $this->render('employe/new.html.twig', [
            'formAddEmploye' => $form,
            'edit'=>$employe->getId()
        ]);
    }

    #[Route('/employe/{id}/delete', name: 'delete_employe')]
    public function delete(Employe $employe, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($employe);
        $entityManager->flush();
        return $this->redirectToRoute('app_employe');
    }

    #[Route('/employe/{id}', name: 'show_employe')]
    public function show(Employe $employe) : Response
    {
        return $this->render('employe/show.html.twig',[
            'employe' => $employe
        ]);
    }
}
