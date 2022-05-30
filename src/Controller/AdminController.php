<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\AddArticleType;
use App\Services\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/')]
class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function new(Request $request,EntityManagerInterface $entityManager): Response
    {
        $articles = $entityManager
            ->getRepository(Article::class)
            ->findBy(array('deleted' => 0));


        return $this->renderForm('admin/admin.html.twig', [
            'articles' => $articles
        ]);
    }

    #[Route('/admin/add', name: 'app_addarticle')]
    public function add(Request $request,EntityManagerInterface $entityManager, FileUploader $fileUploader): Response
    {
        // On envoie le formulaire pour écrire un article
        $article = new Article();
        $form = $this->createForm(AddArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $uploadedFile */
            //on recupere le submit
            $uploadedFile = $form->get('imageFile')->getData();;

            //Ajout de son nom dans la BDD et de son path
            if ($uploadedFile) {

                $uploadedFileName = $fileUploader->upload($uploadedFile);
                $article->setImageFile('/uploads/' . $uploadedFileName);
                $article->setCreationDate(new \DateTime());
                $article->setIdUser($this->getUser());
                $entityManager->persist($article);
                $entityManager->flush();
            }
            return $this->redirectToRoute('app_admin');
        }
        return $this->renderForm('admin/add.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/delete/{id}', name: 'app_delete')]
    public function delete($id,EntityManagerInterface $entityManager): Response
    {

        $articles = $entityManager
            ->getRepository(Article::class)
            ->find($id);

        $articles->setDeleted(1);
        $entityManager->persist($articles);
        $entityManager->flush();
        return $this->redirectToRoute('app_admin');
    }

//    #[Route('/update/{id}', name: 'app_update')]
//    public function update($id,EntityManagerInterface $entityManager): Response
//    {
//
//        $articles = $entityManager
//            ->getRepository(Article::class)
//            ->find($id);
//
//        $articles->setDeleted(1);
//        $entityManager->persist($articles);
//        $entityManager->flush();
//        return $this->redirectToRoute('app_admin');
//    }

}
