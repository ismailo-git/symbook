<?php

namespace App\Controller;

use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    #[Route('/livres', name: 'app_book')]
    public function index(BookRepository $bookRepository): Response
    {   
        $books = $bookRepository->findAll();
        return $this->render('book/index.html.twig', [

            "books" => $books
        ]);
    }
}