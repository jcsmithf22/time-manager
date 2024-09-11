<?php

namespace App\Controller;

use App\Entity\Entry;
use App\Entity\Submission;
use App\Form\SubmissionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SubmissionController extends AbstractController
{
    #[Route('/submission/new', name: 'app_submission_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $submission = new Submission();
        $submission->setSubmitter($this->getUser());
        $entry = new Entry();
        $submission->addEntry($entry);

        $form = $this->createForm(SubmissionType::class, $submission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // ... do your form processing, like saving the Task and Tag entities
//            dd($submission);
            $entityManager->persist($submission);
            $entityManager->flush();

            return $this->redirectToRoute('app_submission_new', [], Response::HTTP_SEE_OTHER);
        }



        return $this->render('submission/new.html.twig', [
            'controller_name' => 'SubmissionController',
            'form' => $form,
        ]);
    }

    #[Route('/submission/{id}/edit', name: 'app_submission_edit')]
    public function edit(Request $request, Submission $submission, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SubmissionType::class, $submission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Your changes have been saved.');
            return $this->redirectToRoute('app_submission_new', [], Response::HTTP_SEE_OTHER);
        }



        return $this->render('submission/edit.html.twig', [
            'controller_name' => 'SubmissionController',
            'form' => $form,
        ]);
    }
}
