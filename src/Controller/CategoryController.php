<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/category", name="category_")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @return Response A response instance
     */
    public function index(CategoryRepository $categoryRepository): Response
    {
        return $this->render(
             'category/index.html.twig',
             ['categories' => $categoryRepository
             ->findAll()]
         );    
    }

    /**
     * @Route("/{categoryName}",methods={"GET"}, name="show")
     */
    public function show(string $categoryName, CategoryRepository $categoryRepository, ProgramRepository $programRepository): Response
    {
        $category = $categoryRepository
        ->findOneBy(['name'=>$categoryName]);

        if (!$category) {
            throw $this->createNotFoundException(
                'No category with name : '.$category.' found in category table.'
            );
        }
        
        $programs = $programRepository
        ->findBy(['category'=> $category], ['id' => 'DESC'], 3);
        return $this->render('category/show.html.twig', ['programs' => $programs]);
    }
}