<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CartItem;
use AppBundle\Entity\Product;
use AppBundle\Entity\ProductAddition;
use AppBundle\Entity\ProductAdditionItem;
use AppBundle\Generator\CartItemGenerator;
use AppBundle\Manager\CartManager;
use Doctrine\ORM\EntityNotFoundException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CartItemController extends Controller
{
    /**
     * @Route("/cart-item/configure", name="app.cartItem.configure")
     * @Template()
     */
    public function configureAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $product_id = $request->query->get('product_id');

        $product = $em->getRepository(Product::class)->find($product_id);

        if(!$product){

            throw new EntityNotFoundException('Product entity of id '.$product_id.' not found.');

        }

        $form = $this->getConfigurationForm($product);

        $productAdditionItems = [];
        /** @var ProductAddition $productAddition */
        foreach($product->getProductAdditions() as $productAddition){
            /** @var ProductAdditionItem $item */
            foreach($productAddition->getItems() as $item){
                $productAdditionItems[$item->getId()] = $item->getSurcharge();
            }
        }

        $productDataset = [
            'product_price' => $product->getPrice(),
            'product_addition_items' => $productAdditionItems,
        ];

        $data = [
            'product' => $product,
            'form' => $form->createView(),
            'productDataSet' => json_encode($productDataset)
        ];

        return $data;

    }

    /**
     * @Route("/cart-item/add-to-cart", name="app.cartItem.addToCart")
     */
    public function addToCartAction(Request $request){

        $em = $this->getDoctrine()->getManager();

        $data = $request->request->get('form');

        $cartItemGenerator = new CartItemGenerator($em);

        $cartItem = $cartItemGenerator->getCartItemFromFormData($data);

        $cartManager = new CartManager($em, $request);
        $cart = $cartManager->getCart();

        $canAdd = $cartItem->getProduct()->getProductTakeoverType() === $cart->getTakeOverType();

        if($canAdd){
            $cartItem->setCart($cart);
            $em->persist($cartItem);

            $em->flush();

            $data = [
                'code' => 200,
                'text' => 'added'
            ];

        }else{

            $data = [
                'code' => 200,
                'text' => 'notadded'
            ];

        }

        $response = new JsonResponse($data);

        return $response;

    }

    /**
     * @Route("/cart-item/remove-from-cart", name="app.cartItem.removeFromCart")
     */
    public function removeFromCartAction(Request $request){

        $em = $this->getDoctrine()->getManager();

        $cartItemId = $request->request->get('cartItemId');


        $cartItem = $em->getRepository(CartItem::class)->find($cartItemId);

        if($cartItem){

            $em->remove($cartItem);

        }

        $em->flush();

        $response = new JsonResponse();

        return $response;

    }

    /**
     * @param \AppBundle\Entity\Product $product
     *
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    private function getConfigurationForm(Product $product){

        $options = [
            'method' => 'post',
            'action' => $this->generateUrl('app.cartItem.addToCart')
        ];
        $formBuilder = $this->createFormBuilder(null, $options);

        $formBuilder->add('product_id', HiddenType::class, [
            'data' => $product->getId()
        ]);

        /** @var ProductAddition $productAddition */
        foreach($product->getProductAdditions() as $productAddition){

            $expanded = true;
            $multiple = $productAddition->getMultiple();

            $options = [
	            'label' => $productAddition->getName(),
	            'class' => 'AppBundle:ProductAdditionItem',
	            'choice_label' => 'fullHtmlName',
	            'choices' => $productAddition->getItems(),
	            'expanded' => $expanded,
	            'multiple' => $multiple,
            ];
            if(!$multiple){
	            $options['data'] = $productAddition->getItems()->first();
            	$options['required'] = true;
            }else{
	            $options['required'] = false;
            }

            $formBuilder->add($productAddition->getSlug(), EntityType::class, $options);

        }

        return $formBuilder->getForm();

    }
}
