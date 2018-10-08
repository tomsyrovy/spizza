<?php
	/**
	 * Project: spizza-web
	 * File: CartItemGenerator.php
	 * Author: Tomas SYROVY <tomas@syrovy.pro>
	 * Date: 24.05.17
	 * Version: 1.0
	 */

	namespace AppBundle\Generator;


	use AppBundle\Entity\CartItem;
	use AppBundle\Entity\CartItemProductAdditionItem;
	use AppBundle\Entity\Product;
	use AppBundle\Entity\ProductAddition;
	use AppBundle\Entity\ProductAdditionItem;
	use Doctrine\Common\Persistence\ObjectManager;
	use Doctrine\ORM\EntityNotFoundException;

	class CartItemGenerator {

		/**
		 * @var ObjectManager
		 */
		public $em;

		/**
		 * @var \AppBundle\Repository\ProductRepository
		 */
		private $productRepository;

		/**
		 * @var \AppBundle\Repository\ProductAdditionRepository
		 */
		private $productAdditionRepository;

		/**
		 * @var \AppBundle\Repository\ProductAdditionItemRepository
		 */
		private $productAdditionItemRepository;

		/**
		 * CartItemGenerator constructor.
		 *
		 * @param \Doctrine\Common\Persistence\ObjectManager $em
		 */
		public function __construct( ObjectManager $em ){
			$this->em = $em;
			$this->productRepository = $this->em->getRepository(Product::class);
			$this->productAdditionRepository = $this->em->getRepository(ProductAddition::class);
			$this->productAdditionItemRepository = $this->em->getRepository(ProductAdditionItem::class);
		}

		/**
		 * @param $data
		 *
		 * @return \AppBundle\Entity\CartItem
		 * @throws \Doctrine\ORM\EntityNotFoundException
		 */
		public function getCartItemFromFormData($data){

			$product_id = $data['product_id'];
			/** @var Product $product */
			$product = $this->productRepository->find($product_id);

			if(!$product){
				throw new EntityNotFoundException();
			}

			$cartItem = new CartItem();
			$cartItem->setProduct($product);
			$cartItem->setAmount(1);

			foreach($data as $key => $value){
				if(in_array($key, ['product_id', '_token'], true)){
					continue;
				}
				if(is_array($value)){
					foreach($value as $v){

						$cartItemProductAdditionItem = $this->createAndGetCartItemProductAdditionItem($cartItem, $key, $v);
						if($cartItemProductAdditionItem){
							$cartItem->addCartItemProductAdditionItem($cartItemProductAdditionItem);
						}

					}
				}else{

					$cartItemProductAdditionItem = $this->createAndGetCartItemProductAdditionItem($cartItem, $key, $value);
					if($cartItemProductAdditionItem){
						$cartItem->addCartItemProductAdditionItem($cartItemProductAdditionItem);
					}
				}

			}

			$cartItem->setFullName($this->createAndGetFullName($cartItem));
			$cartItem->setPricePerUnit($cartItem->calculatePricePerUnit());

			return $cartItem;

		}

		private function createAndGetFullName(CartItem $cartItem){

			$fullNames = [];

			$product = $cartItem->getProduct();
			$fullNames[] = $product->getId().':'.$product->getName().'['.$product->getPrice().']';

			/** @var CartItemProductAdditionItem $cartItemProductAdditionItem */
			foreach($cartItem->getCartItemProductAdditionItems() as $cartItemProductAdditionItem){

				$productAddition = $cartItemProductAdditionItem->getProductAddition();
				$productAdditionItem = $cartItemProductAdditionItem->getProductAdditionItem();

				$fullNames[] = $productAddition->getId().':'.$productAddition->getName().':'.$productAdditionItem->getId().':'.$productAdditionItem->getName().'['.$cartItemProductAdditionItem->getPrice().']';

			}

			$fullName = implode('; ', $fullNames);

			return $fullName;

		}

		private function createAndGetCartItemProductAdditionItem(CartItem $cartItem, $productAdditionSlug, $productAdditionItemId){

			$criteria = [
				'slug' => $productAdditionSlug,
			];
			$productAddition = $this->productAdditionRepository->findOneBy($criteria);

			$criteria = [
				'id' => $productAdditionItemId,
			];
			$productAdditionItem = $this->productAdditionItemRepository->findOneBy($criteria);

			if($productAddition && $productAdditionItem && $productAddition->getItems()->contains($productAdditionItem)){

				$cartItemProductAdditionItem = new CartItemProductAdditionItem();
				$cartItemProductAdditionItem->setCartItem($cartItem);
				$cartItemProductAdditionItem->setProductAddition($productAddition);
				$cartItemProductAdditionItem->setProductAdditionItem($productAdditionItem);
				$cartItemProductAdditionItem->setPrice($productAdditionItem->getSurcharge());

				return $cartItemProductAdditionItem;

			}

			return null;

		}

	}