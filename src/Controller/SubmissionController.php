<?php

namespace App\Controller;

use App\Entity\Entry;
use App\Entity\Submission;
use App\Form\SubmissionType;
use App\Repository\SubmissionRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SubmissionController extends AbstractController
{
    #[Route('/submission/new', name: 'app_submission_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $submission = new Submission();
        $submission->setDate(new DateTime('now'));
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

            $this->addFlash('success', 'Submission successfully created.');
            return $this->redirectToRoute('index', [], Response::HTTP_SEE_OTHER);
        }


        return $this->render('submission/new.html.twig', [
            'controller_name' => 'SubmissionController',
            'form' => $form,
        ]);
    }

    #[Route('/submission/{id}/edit', name: 'app_submission_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        int $id,
        EntityManagerInterface $entityManager,
        SubmissionRepository $submissionRepository,
    ): Response {

        $submission = $submissionRepository->findOneBy([
            'id' => $id,
            'submitter' => $this->getUser(),
        ]);

        if (!$submission) {
            throw $this->createNotFoundException('Submission not found');
        }

        $form = $this->createForm(SubmissionType::class, $submission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Your changes have been saved.');
            return $this->redirectToRoute('index', [], Response::HTTP_SEE_OTHER);
        }


        return $this->render('submission/edit.html.twig', [
            'controller_name' => 'SubmissionController',
            'submission' => $submission,
            'form' => $form,
        ]);

    }

    #[Route('/submission/{id}/delete', name: 'app_submission_delete', methods: ['POST'])]
    public function delete(
        Request $request,
        int $id,
        EntityManagerInterface $entityManager,
        SubmissionRepository $submissionRepository,
    ): Response {
        $submission = $submissionRepository->findOneBy([
            'id' => $id,
            'submitter' => $this->getUser(),
        ]);

        if (!$submission) {
            throw $this->createNotFoundException('Submission not found');
        }

        if ($this->isCsrfTokenValid('delete'.$submission->getId(), $request->request->get('_token'))) {
            $entityManager->remove($submission);
            $entityManager->flush();

            $this->addFlash('success', 'Submission deleted');
        }

        return $this->redirectToRoute('index', [], Response::HTTP_SEE_OTHER);
    }
}
