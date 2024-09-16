<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\SubmissionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(SubmissionRepository $submissionRepository): Response
    {
        $user = $this->getUser();
        $submissions = $submissionRepository->findBy([
            'submitter' => $user
        ], [
        	'date' => 'ASC', 'id' => 'ASC'
        ]);

        return $this->render('main/index.html.twig', [
            'submissions' => $submissions
        ]);
    }

    #[Route('/about', name: 'about')]
    public function about(): Response
    {
        return $this->render('main/about.html.twig');
    }
}
