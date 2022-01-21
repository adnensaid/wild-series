<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;
use App\Entity\Program;
use Gitonomy\Git\Repository;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category/", name="category_index")
     * @return Response A response instance
     */
    public function index(): Response
    {
        $categories = $this->getDoctrine()
        ->getRepository(Category::class)
        ->findAll();

        return $this->render(
             'category/index.html.twig',
             ['categories' => $categories]
         );    
    }

    /**
     * @Route("/category/{categoryName}",methods={"GET"}, name="category_show")
     */
    public function show(string $categoryName ): Response
    {
        $category = $this->getDoctrine()
        ->getRepository((Category::class))
        ->findOneBy(['name'=>$categoryName]);

        if (!$category) {
            throw $this->createNotFoundException(
                'No category w—ith name : '.$category.' found in category table.'
            );
        }
        
        $programs = $this->getDoctrine()
        ->getRepository((Program::class))
        ->findBy(['category'=> $category], ['id' => 'DESc'], 3);
        return $this->render('category/show.html.twig', ['programs' => $programs]);
    }
}