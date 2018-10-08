<?php
	/**
	 * Project: spizza-web
	 * File: ProductBaseAdminController.php
	 * Author: Tomas SYROVY <tomas@syrovy.pro>
	 * Date: 24.03.17
	 * Version: 1.0
	 */

	namespace AppBundle\Controller;


	use AppBundle\Entity\ProductBase;
	use AppBundle\Generator\ProductGenerator;
	use Pix\SortableBehaviorBundle\Controller\SortableAdminController;
	use Symfony\Component\HttpFoundation\RedirectResponse;
	use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

	class ProductBaseAdminController extends SortableAdminController {

		public function generateProductsAction(){

			/** @var ProductBase $object */
			$object = $this->admin->getSubject();

			if (!$object) {
				throw new NotFoundHttpException('Unable to find the object.');
			}

			$em = $this->getDoctrine()->getEntityManager();
			$productGenerator = new ProductGenerator($em);

			$criteria = [];
			$productVariants = $em->getRepository('AppBundle:ProductVariant')->findBy($criteria);

			$criteria = [];
			$productTakeoverTypes = $em->getRepository('AppBundle:ProductTakeoverType')->findBy($criteria);

			$productGenerator->generateProductsOf($object, $productVariants, $productTakeoverTypes);

			$this->addFlash('sonata_flash_success', 'Produkty pro Základní produkt "'.$object->getName().'" byly vytvořeny.');

			//Keep filters parameters after redirect
			return new RedirectResponse($this->admin->generateUrl('list', $this->admin->getFilterParameters()));

		}

	}