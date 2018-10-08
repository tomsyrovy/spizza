<?php

namespace AppBundle\Controller;

use AppBundle\Entity\LocalBusiness;
use AppBundle\Entity\ProductAttribute;
use AppBundle\Entity\ProductBase;
use AppBundle\Entity\ProductCategory;
use AppBundle\Entity\ProductTakeoverType;
use AppBundle\Manager\AddressManager;
use AppBundle\Manager\CartManager;
use AppBundle\Manager\DeliveryManager;
use Ivory\GoogleMap\Place\AutocompleteComponentType;
use Ivory\GoogleMapBundle\Form\Type\PlaceAutocompleteType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="app.default.index")
     * @Template()
     */
    public function indexAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $productTakeoverTypes = $em->getRepository(ProductTakeoverType::class)->findAll();
	    $criteria = [];
	    $orderBy = [
		    'position' => 'ASC'
	    ];
        $productCategories = $em->getRepository(ProductCategory::class)->findBy($criteria, $orderBy);
        $criteria = [
        	'visibleInMenu' => true,
        ];
        $orderBy = [
        	'position' => 'ASC'
        ];
        $productAttributes = $em->getRepository(ProductAttribute::class)->findBy($criteria, $orderBy);
        $criteria = [
            'forSale' => true,
        ];
        $products = $em->getRepository(ProductBase::class)->findBy($criteria);

        $addressManager = new AddressManager($em, $request);

        $addressModel = [
            'address' => $addressManager->getAddress()
        ];
        $addressForm = $this->getAddressForm($addressModel);

        $criteria = [];
        $orderBy = [
        	'position' => 'ASC'
        ];
        $localBusinesses = $em->getRepository(LocalBusiness::class)->findBy($criteria, $orderBy);

        $cartManager = new CartManager($em, $request);
        $cart = $cartManager->getCart();
        $cartTakeoverType = $cart->getTakeOverType();
        if(!$cartTakeoverType){
            $criteria = [];
            $cartTakeoverType = $em->getRepository(ProductTakeoverType::class)->findOneBy($criteria);
        }

        $data = [
            'productTakeoverTypes' => $productTakeoverTypes,
            'productCategories' => $productCategories,
            'productAttributes' => $productAttributes,
            'products' => $products,
            'addressForm' => $addressForm->createView(),
            'localBusinesses' => $localBusinesses,
            'cartTakeoverType' => $cartTakeoverType
        ];
        return $data;
    }

    /**
     * @param null  $data
     * @param array $options
     *
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    private function getAddressForm($data = null, $options = []){

        $formBuilder = $this->createFormBuilder($data, $options);
        $formBuilder->add('address', PlaceAutocompleteType::class, [
        	'attr' => [
        		'placeholder' => 'Zadejte adresu'
	        ],
            'components' => [
                AutocompleteComponentType::COUNTRY => 'cz'
            ]
        ]);

        return $formBuilder->getForm();

    }
}
