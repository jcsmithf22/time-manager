<?php

namespace App\Controller;

use App\Entity\Entry;
use App\Entity\Submission;
use App\Form\SubmissionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SubmissionController extends AbstractController
{
    #[Route('/submission', name: 'app_submission')]
    public function index(Request $request): Response
    {
        $submission = new Submission();
        $entry = new Entry();
        $submission->addEntry($entry);

        $form = $this->createForm(SubmissionType::class, $submission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // ... do your form processing, like saving the Task and Tag entities
            dd($submission);
        }



        return $this->render('submission/index.html.twig', [
            'controller_name' => 'SubmissionController',
            'form' => $form,
        ]);
    }
}
