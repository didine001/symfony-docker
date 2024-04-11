<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Commentaires;
use App\Form\CommentairesType;
use App\Repository\CommentairesRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class ModifyCommentsController extends AbstractController
{
    private CommentairesRepository $commentairesRepository;

    #[Route('/modify/commentaires/{id}', name: 'commentaires_modify')]
    public function modify(int $id, CommentairesRepository $commentairesRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->commentairesRepository = $commentairesRepository;
        $commentaire = $this->commentairesRepository->find($id);

        if (!$commentaire) {
            throw $this->createNotFoundException('Commentaire not found');
        }

        $form = $this->createForm(CommentairesType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_accueil');
        }

        return $this->render('commentaires/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
