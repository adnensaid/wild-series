<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Program;
use Gitonomy\Git\Repository;

class ProgramController extends AbstractController
{
    /**
     * @Route("/program/", name="program_index")
     * @return Response A response instance
     */
    public function index(Repository ): Response
    {
        $programs = $this->getDoctrine()
        ->getRepository(Program::class)
        ->findAll();

        return $this->render(
             'program/index.html.twig',
             ['programs' => $programs]
         );    
    }

    /**
     * @Route("/program/{id}",requirements={"id"="\d+"},methods={"GET"}, name="program_show")
     */
    public function show(int $id): Response
    {
        $program = $this->getDoctrine()
        ->getRepository((Program::class))
        ->findOneBy(['id'=>$id]);
        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : '.$id.' found in program\'s table.'
            );
        }        
        return $this->render('program/show.html.twig', ['program' => $program]);
    }
}