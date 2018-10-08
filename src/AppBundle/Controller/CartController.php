<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CartItem;
use AppBundle\Entity\LocalBusiness;
use AppBundle\Entity\ProductTakeoverType;
use AppBundle\Manager\AddressManager;
use AppBundle\Manager\CartManager;
use AppBundle\Manager\DeliveryManager;
use Doctrine\ORM\EntityNotFoundException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CartController extends Controller
{
    /**
     * @Route("/cart", name="app.cart.default")
     * @Template()
     */
    public function defaultAction(Request $request, $isCheckout = false)
    {

        $em = $this->getDoctrine()->getManager();

        $cartManager = new CartManager($em, $request);

        $data = [
            'cart' => $cartManager->getCart(),
	        'isCheckout' => $isCheckout
        ];

        return $data;

    }

    /**
     * @Route("/cart/choose-takeover", name="app.cart.choosetakeOver")
     */
    public function chooseTakeoverAction(Request $request){

        $em = $this->getDoctrine()->getManager();

        $takeoverSlug = $request->request->get('takeoverSlug');

        $criteria = [
            'slug' => $takeoverSlug,
        ];

        $takeoverType = $em->getRepository(ProductTakeoverType::class)->findOneBy($criteria);

        if(!$takeoverType){
            throw new EntityNotFoundException();
        }

        $cartManager = new CartManager($em, $request);
        $cart = $cartManager->getCart();

        $canChange = true;
        /** @var CartItem $cartItem */
        foreach($cart->getCartItems() as $cartItem){
            if($cartItem->getProduct()->getProductTakeoverType() !== $takeoverType){
                $canChange = false;
                break;
            }
        }

        if($canChange){
            $cart->setTakeOverType($takeoverType);
            $em->persist($cart);
            $em->flush();

            $data = [
                'code' => 200,
                'text' => 'changed'
            ];

        }else{

            $data = [
                'code' => 200,
                'text' => 'notchanged'
            ];

        }

        $response = new JsonResponse($data);

        return $response;

    }

	/**
	 * @Route("/cart/choose-localbusiness", name="app.cart.chooseLocalBusiness")
	 *
	 * @Template()
	 */
	public function chooseLocalBusinessAction(Request $request){

		$em = $this->getDoctrine()->getManager();

		$slug = $request->request->get('localBusinessSlug');

		$criteria = [
			'slug' => $slug,
		];

		$localBusiness = $em->getRepository(LocalBusiness::class)->findOneBy($criteria);

		if(!$localBusiness){
			throw new EntityNotFoundException();
		}

		$cartManager = new CartManager($em, $request);
		$cart = $cartManager->getCart();

		$cart->setLocalBusiness($localBusiness);

		$em->persist($cart);
		$em->flush();

		$data = [
			'localBusiness' => $localBusiness,
			'cart' => $cart
		];

		return $data;

	}

	/**
	 * @Route("/cart/send-address", name="app.cart.sendAddress")
	 *
	 * @Template()
	 */
	public function sendAddressAction(Request $request){

		$em = $this->getDoctrine()->getManager();

		$address = $request->request->get('address');

		$data = [];

		if($address and !empty($address)){

			$addressManager = new AddressManager($em, $request);
			$addressManager->saveAddress($address);

			$deliveryManager = new DeliveryManager($em, $request, $this->container);

			$bestLocalBusiness = $deliveryManager->getBestLocalBusiness();

			if(count($bestLocalBusiness) >= 1){

				$localBusiness = $bestLocalBusiness[0];

				$data['localBusiness'] = $localBusiness;

			}

		}

		return $data;

	}

}
