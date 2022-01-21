<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProgramRepository;

class ProgramController extends AbstractController
{
    /**
     * @Route("/program/", name="program_index")
     * @return Response A response instance
     */
    public function index(ProgramRepository $programRepository): Response
    {
        return $this->render(
             'program/index.html.twig',
             ['programs' => $programRepository->findAll()]
         );    
    }

    /**
     * @Route("/program/{id}",requirements={"id"="\d+"},methods={"GET"}, name="program_show")
     */
    public function show(int $id, ProgramRepository $programRepository): Response
    {
        $program = $programRepository->findOneBy(['id'=>$id]);
        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : ' . $id . ' found in program\'s table.'
            );
        }

        return $this->render('program/show.html.twig', ['program' => $program]);
    }
}