<?php 

namespace App\Class;

use Symfony\Component\HttpFoundation\RequestStack;


class Cart {

	private $session;

	public function __construct(RequestStack $stack)
	{
		return $this->stack = $stack;
	}

	public function add($id)
	{	
		$session = $this->stack->getSession();

		$cart = $session->get('cart', []);

		if (!empty($cart[$id])) {
			
			$cart[$id]++;
		}
		else {

			$cart[$id] = 1;
		}
		
		$session->set('cart', $cart);
	}

	public function get()
	{
		$getmethod = $this->stack->getSession();

		return $getmethod->get('cart');
	}

	


	// public function remove($id, RequestStack $stack)
	// {
	// 	$session = $stack->getSession();
	// 	$cart = $session->get('cart', []);
	// 	if (!empty($cart[$id])) {
			
	// 		unset($cart);
	// 	}

	// 	$session->set('cart', $cart);

	// }
}