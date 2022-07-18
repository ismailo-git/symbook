<?php

namespace App\Controller;

use App\Repository\BookRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookController extends AbstractController
{   
    //Cette fonction nous permet d'afficher la liste des livres disponible
    #[Route('/books', name: 'app_book')]
    public function index(BookRepository $bookRepository): Response
    {   
        $books = $bookRepository->findAll();
        return $this->render('book/index.html.twig', [

            "books" => $books
        ]);
    }
    // Cette fonction nous permet d'afficher les livres en fonction de leurs catégories
    #[Route('/c/{slug}', name: 'book_category')]
    public function category($slug, CategoryRepository $categoryRepository): Response
    {   
        $category =  $categoryRepository->findOneBy([
            
            'slug' => $slug
        ]);

        if (!$category) {
            
            throw $this->createNotFoundException("La catégorie recherchée n'existe pas");
        }
        return $this->render('book/category.html.twig', [

            "slug" => $slug,
            "category" => $category
        ]);
    }

    #[Route('/c/{category_slug}/{slug}', name:"show_book", priority:-1)]
    public function show($slug, BookRepository $bookRepository) {

        $book = $bookRepository->findOneBy([
            "slug" => $slug
        ]);

        if (!$book) {
            
            throw $this->createNotFoundException("Le produit demandé n'existe pas");
        }

        return $this->render('book/show.html.twig', [

            'book' => $book
        ]);

    }
}
