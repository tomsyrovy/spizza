<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * CartItem
 *
 * @ORM\Table(name="cart_item")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CartItemRepository")
 */
class CartItem
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Product
     *
     * @ORM\ManyToOne(targetEntity="Product")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $product;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\CartItemProductAdditionItem", mappedBy="cartItem",
     *                                                                             cascade={"persist", "remove"})
     */
    private $cartItemProductAdditionItems;

    /**
     * @var float
     *
     * @ORM\Column(name="price_per_unit", type="decimal", scale=2, precision=6)
     */
    private $pricePerUnit;

    /**
     * @var int
     *
     * @ORM\Column(name="amount", type="integer")
     */
    private $amount;

    /**
     * @var string
     *
     * @ORM\Column(name="fullName", type="string", length=255)
     */
    private $fullName;

    /**
     * @var Cart
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Cart", inversedBy="cartItems", cascade={"persist"})
     */
    private $cart;

    /**
     * @return float
     */
    public function calculatePricePerUnit(){

        $price = $this->getProduct()->getPrice();
        /** @var \AppBundle\Entity\CartItemProductAdditionItem $cartItemProductAdditionItem */
	    foreach($this->getCartItemProductAdditionItems() as $cartItemProductAdditionItem){
            $price = $price + $cartItemProductAdditionItem->getPrice();
        }

        return $price;

    }

    public function getProductAdditions(){

    	$pas = [];

    	/** @var \AppBundle\Entity\CartItemProductAdditionItem $cartItemProductAdditionItem */
	    foreach($this->getCartItemProductAdditionItems() as $cartItemProductAdditionItem){

    		$productAddition = $cartItemProductAdditionItem->getProductAddition();
    		$productAdditionItem = $cartItemProductAdditionItem->getProductAdditionItem();

    		if(!array_key_exists($productAddition->getId(), $pas)){
    			$pas[$productAddition->getId()] = [];
    			$pas[$productAddition->getId()]['productAddition'] = $productAddition;
    			$pas[$productAddition->getId()]['productAdditionItems'] = [];
		    }

		    $pas[$productAddition->getId()]['productAdditionItems'][] = $productAdditionItem;

	    }

	    return $pas;

    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->cartItemProductAdditionItems = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set pricePerUnit
     *
     * @param string $pricePerUnit
     *
     * @return CartItem
     */
    public function setPricePerUnit($pricePerUnit)
    {
        $this->pricePerUnit = $pricePerUnit;

        return $this;
    }

    /**
     * Get pricePerUnit
     *
     * @return string
     */
    public function getPricePerUnit()
    {
        return $this->pricePerUnit;
    }

    /**
     * Set amount
     *
     * @param integer $amount
     *
     * @return CartItem
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return integer
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set fullName
     *
     * @param string $fullName
     *
     * @return CartItem
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;

        return $this;
    }

    /**
     * Get fullName
     *
     * @return string
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * Set product
     *
     * @param \AppBundle\Entity\Product $product
     *
     * @return CartItem
     */
    public function setProduct(\AppBundle\Entity\Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \AppBundle\Entity\Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Add cartItemProductAdditionItem
     *
     * @param \AppBundle\Entity\CartItemProductAdditionItem $cartItemProductAdditionItem
     *
     * @return CartItem
     */
    public function addCartItemProductAdditionItem(\AppBundle\Entity\CartItemProductAdditionItem $cartItemProductAdditionItem)
    {
        $this->cartItemProductAdditionItems[] = $cartItemProductAdditionItem;

        return $this;
    }

    /**
     * Remove cartItemProductAdditionItem
     *
     * @param \AppBundle\Entity\CartItemProductAdditionItem $cartItemProductAdditionItem
     */
    public function removeCartItemProductAdditionItem(\AppBundle\Entity\CartItemProductAdditionItem $cartItemProductAdditionItem)
    {
        $this->cartItemProductAdditionItems->removeElement($cartItemProductAdditionItem);
    }

    /**
     * Get cartItemProductAdditionItems
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCartItemProductAdditionItems()
    {
        return $this->cartItemProductAdditionItems;
    }

    /**
     * Set cart
     *
     * @param \AppBundle\Entity\Cart $cart
     *
     * @return CartItem
     */
    public function setCart(\AppBundle\Entity\Cart $cart = null)
    {
        $this->cart = $cart;

        return $this;
    }

    /**
     * Get cart
     *
     * @return \AppBundle\Entity\Cart
     */
    public function getCart()
    {
        return $this->cart;
    }
}
