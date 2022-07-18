<?php

namespace App\Controller;

use App\Class\Cart;
use App\Repository\BookRepository;
use Flasher\Prime\FlasherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{   
    //Cette route nous permet d'afficher le recapitulatif de notre achat
    #[Route('/cart', name: 'app_cart')]
    public function index(SessionInterface $session, BookRepository $bookRepository): Response
    {   
        $dataCart = [];
        $total = 0;
        

        foreach ($session->get('cart', []) as $id => $quantity){
            
            $book = $bookRepository->find($id);

            $dataCart[] = [

                "book" => $book,
                "quantity" => $quantity
            ];

            //  $totalArticle = $dataCart(count($quantity));
            $total += $book->getPrice() * $quantity;
        }

        return $this->render('cart/index.html.twig', compact("dataCart", "total"));
    }

    //Cette route nous permet d'ajouter un livre dans le panier
    #[Route('/cart/add/{id}', name: 'add_cart')]
    public function add(Cart $cart, $id): Response
    {   
        $cart->add($id);

        return $this->redirectToRoute('app_cart');
    }

    //Cette route nous permet supprimer un livre du le panier
    #[Route('/cart/remove/{id}', name: 'remove_cart')]
    public function remove($id, SessionInterface $session, BookRepository $bookRepository, FlasherInterface $flasher): Response
    {   
         
      $book = $bookRepository->find($id);

        $cart = $session->get('cart', []);
        $id = $book->getId();

        if (!empty($cart[$id])) {
            
            if ($cart[$id] > 1) {
                
                $cart[$id]--;
            }
            else {

                unset($cart[$id]);
            }
        }

        $session->set("cart", $cart);
        
        $flasher->addSuccess('Le produit a bien été supprimé du panier');
        return $this->redirectToRoute("app_cart");
    }

     #[Route('/cart/remove/', name: 'delete_cart')]
    public function delete(SessionInterface $session, FlasherInterface $flasher): Response
    {   
         

        $session->set("cart", []);
        
        $flasher->addSuccess('Votre panier à été vidé avec succés');
        return $this->redirectToRoute("app_cart");
    }


}
