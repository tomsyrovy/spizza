<?php
	/**
	 * Project: spizza-web
	 * File: ProductGenerator.php
	 * Author: Tomas SYROVY <tomas@syrovy.pro>
	 * Date: 24.03.17
	 * Version: 1.0
	 */

	namespace AppBundle\Generator;


	use AppBundle\Entity\Product;
	use AppBundle\Entity\ProductBase;
	use AppBundle\Entity\ProductTakeoverType;
	use AppBundle\Entity\ProductVariant;
	use Doctrine\Common\Persistence\ObjectManager;

	class ProductGenerator {

		/** @var ObjectManager */
		private $em;

		/**
		 * ProductGenerator constructor.
		 *
		 * @param \Doctrine\Common\Persistence\ObjectManager $em
		 */
		public function __construct( ObjectManager $em ){
			$this->em = $em;
		}

		/**
		 * @param \AppBundle\Entity\ProductBase $productBase
		 * @param array                         $productVariants
		 * @param array                         $productTakeoverTypes
		 */
		public function generateProductsOf(ProductBase $productBase, array $productVariants, array $productTakeoverTypes) {

			$products = $this->createProductsOf($productBase, $productVariants, $productTakeoverTypes);

			foreach($products as $product){

				$this->em->persist($product);

			}

			$this->em->flush();

		}

		/**
		 * @param \AppBundle\Entity\ProductBase $productBase
		 * @param array                         $productVariants
		 * @param array                         $productTakeoverTypes
		 *
		 * @return array
		 */
		private function createProductsOf(ProductBase $productBase, array $productVariants, array $productTakeoverTypes) {

			$products = [];

			/** @var ProductVariant $productVariant */
			foreach($productVariants as $productVariant){

				if($productVariant instanceof ProductVariant){

					foreach($productTakeoverTypes as $productTakeoverType){

						if($productTakeoverType instanceof ProductTakeoverType){

							$product = new Product();
							$product->setProductBase($productBase);
							$product->setProductVariant($productVariant);
							$product->setProductTakeoverType($productTakeoverType);

							$products[] = $product;

						}

					}

				}

			}

			return $products;

		}


	}