<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Address;
use AppBundle\Entity\Commission;
use AppBundle\Entity\CommissionStatus;
use AppBundle\Entity\Customer;
use AppBundle\Form\CommissionType;
use AppBundle\Manager\AddressManager;
use AppBundle\Manager\CartManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CheckoutController extends Controller
{
    /**
     * @Route("/checkout", name="app.checkout.step1")
     * @Template()
     */
    public function step1Action(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $cartManager = new CartManager($em, $request);

        $cart = $cartManager->getCart();

        if($cart->getCartItems()->count() === 0){
            return $this->redirectToRoute('app.default.index');
        }

        $customer = new Customer();

        if($cart->getTakeOverType()->getSlug() === 'necham-si-dovezt'){
            $addressManager = new AddressManager($em, $request);
            $addressArray = $addressManager->tryParse();
            if(count($addressArray) >= 2){

                $address = new Address();
                $address->setStreet($addressArray['street']);
                $address->setCity($addressArray['city']);

                $customer->setAddress($address);

            }
        }

	    $commission = new Commission();
	    $commission->setCreatedAt(new \DateTime());
	    $commission->setCustomer($customer);
	    $commission->setCart($cart);

	    $options = [
	    	'trait_options' => [
	    		'commission' => $commission
		    ]
	    ];

        $form = $this->createForm(CommissionType::class, $commission, $options);

        $form->handleRequest($request);

        if($form->isSubmitted() and $form->isValid()){

            $criteria = [
            	'slug' => 'prijata'
            ];
            $commissionStatus = $em->getRepository(CommissionStatus::class)->findOneBy($criteria);

            $commission->setCommissionStatus($commissionStatus);

            $number = 1 + count($em->getRepository(Commission::class)->findAll());

            $commission->setNumber($number);

            $em->persist($commission);
            $em->persist($customer);
            $em->persist($cart);

            $em->flush();

	        //TODO A další následné akce - rozesílka e-mailů, apod. apod.
	        //TODO Vymazat obsah košíku

	        $params = [
	        	'commissionId' => $commission->getId()
	        ];
            return $this->redirectToRoute('app.checkout.done', $params);

        }

        $data = [
            'cart' => $cart,
            'form' => $form->createView()
        ];

        return $data;

    }

    /**
     * @Route("/checkout/done/{commissionId}", name="app.checkout.done")
     * @Template()
     */
    public function doneAction(Request $request, $commissionId)
    {

        $em = $this->getDoctrine()->getManager();

        $commission = $em->getRepository(Commission::class)->find($commissionId);

        if(!$commission){
        	return $this->redirectToRoute('app.default.index');
        }

        $data = [
        	'commission' => $commission
        ];

        return $data;

    }

}
