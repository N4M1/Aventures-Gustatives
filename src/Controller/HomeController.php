<?php

namespace App\Controller;


use App\Entity\Article;
use App\Entity\Commentaires;
use App\Entity\User;
use App\Form\CommentaireType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $articles = $entityManager
            ->getRepository(Article::class)
            ->findBy(array('deleted' => 0));

        $lastarticle = $entityManager
            ->getRepository(Article::class)
            ->findBy(array('deleted' => 0), array('id' => 'desc'),1,0);

        return $this->render('home/home.html.twig', [
            'controller_name' => 'HomeController',
            'articles' => $articles,
            'lastarticle' => $lastarticle,
        ]);

    }

    #[Route('/about', name: 'app_about')]
    public function about(): Response
    {

        return $this->render('home/about.html.twig');

    }

    #[Route('/recettes', name: 'app_recettes')]
    public function recettes(EntityManagerInterface $entityManager): Response
    {

        $articles= $entityManager
            ->getRepository(Article::class)
            ->findAll();


        return $this->render('recettes/recettes.html.twig',[
            'articles' => $articles,
            ]);


    }

    #[Route('/recettes/{id}/details', name: 'app_recettes_details')]
    public function recettesDetails($id, Request $request, EntityManagerInterface $entityManager): Response
    {
        // Les trois dernieres recettes
        $threelast = $entityManager
            ->getRepository(Article::class)
            ->findBy(array('deleted' => 0), array('id' => 'desc'),3,0);

        // On recupere tous les commentaires de l'article
        $commentaire = $entityManager
            ->getRepository(Commentaires::class)
            ->findBy(array('idArticle' => $id));


        // On envoie le formulaire pour écrire un commentaire
            $commentaires = new Commentaires();
            $form = $this->createForm(CommentaireType::class, $commentaires);
            $form->handleRequest($request);

            $articles = $entityManager
                ->getRepository(Article::class)
                ->find($id);
        if ($this->getUser() != null) {

            $commentaires->setIdArticle($articles);
            $commentaires->setIdUser($this->getUser());
            $commentaires->setCreationDate(new \DateTime());

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->persist($commentaires);
                $entityManager->flush();

                return $this->redirectToRoute('app_recettes_details', array('id' => $id));
            }
        }
        return $this->renderForm('recettes/recette_details.html.twig', [
            'article' => $articles,
            'form' => $form,
            'commentaire' => $commentaire,
            'threelast' => $threelast
        ]);

    }

}
