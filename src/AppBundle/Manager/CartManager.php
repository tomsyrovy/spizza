<?php
	/**
	 * Project: spizza-web
	 * File: CartManager.php
	 * Author: Tomas SYROVY <tomas@syrovy.pro>
	 * Date: 24.05.17
	 * Version: 1.0
	 */

	namespace AppBundle\Manager;


	use AppBundle\Entity\Cart;
	use AppBundle\Entity\Commission;
	use AppBundle\Entity\ProductTakeoverType;
	use Doctrine\Common\Persistence\ObjectManager;
	use Symfony\Component\HttpFoundation\Cookie;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;

	class CartManager {

		/** @var  ObjectManager */
		private $em;

		/** @var  Request */
		private $request;

		/**
		 * CartManager constructor.
		 *
		 * @param \Doctrine\Common\Persistence\ObjectManager $em
		 * @param \Symfony\Component\HttpFoundation\Request  $request
		 */
		public function __construct( ObjectManager $em, Request $request ){
			$this->em      = $em;
			$this->request = $request;
		}

		/**
		 * @return \AppBundle\Entity\Cart
		 */
		public function getCart(){

			if($this->request->cookies->has('cart_id')){
				$cart_id = $this->request->cookies->get('cart_id');
				$cart = $this->getCartByUUID($cart_id);
			}else{
				$cart = $this->createCart();
			}

			//Je-li košík přiřazen k objednávce (bez ohledu na její stav), tak vytvoř nový košík
			$criteria = [
				'cart' => $cart
			];
			$commission = $this->em->getRepository(Commission::class)->findOneBy($criteria);
			if($commission){
				$cart = $this->createCart();
			}

			$response = new Response();
			$cookie = new Cookie('cart_id', $cart->getId(), time()+3600);
			$response->headers->setCookie($cookie);
			$response->sendHeaders();

			return $cart;

		}

		/**
		 * @param $uuid
		 *
		 * @return \AppBundle\Entity\Cart
		 */
		private function getCartByUUID($uuid){

			$cart = $this->em->getRepository(Cart::class)->find($uuid);

			if(!$cart){

				$cart = $this->createCart();

			}

			return $cart;

		}

		/**
		 * @return \AppBundle\Entity\Cart
		 */
		private function createCart(){

			$cart = new Cart();
			$cart->setCreatedAt(new \DateTime());

			$takeOverTypes = $this->em->getRepository(ProductTakeoverType::class)->findAll();
			$takeOverType = $takeOverTypes[0];

			$cart->setTakeOverType($takeOverType);

			$this->em->persist($cart);
			$this->em->flush();

			return $cart;

		}

	}