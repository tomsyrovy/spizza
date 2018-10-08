<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CartItemProductAdditionItem
 *
 * @ORM\Table(name="cart_item_product_addition_item")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CartItemProductAdditionItemRepository")
 */
class CartItemProductAdditionItem
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
     * @var \AppBundle\Entity\CartItem
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CartItem", inversedBy="cartItemProductAdditionItems", cascade={"persist", "remove"})
     */
    private $cartItem;

    /**
     * @var \AppBundle\Entity\ProductAdditionItem
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ProductAdditionItem", cascade={"persist"})
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $productAdditionItem;

    /**
     * @var \AppBundle\Entity\ProductAddition
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ProductAddition", cascade={"persist"})
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $productAddition;

	/**
	 * @var float
	 *
	 * @ORM\Column(name="price", type="decimal", scale=2, precision=6)
	 */
	private $price;

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
     * Set cartItem
     *
     * @param \AppBundle\Entity\CartItem $cartItem
     *
     * @return CartItemProductAdditionItem
     */
    public function setCartItem(\AppBundle\Entity\CartItem $cartItem = null)
    {
        $this->cartItem = $cartItem;

        return $this;
    }

    /**
     * Get cartItem
     *
     * @return \AppBundle\Entity\CartItem
     */
    public function getCartItem()
    {
        return $this->cartItem;
    }

    /**
     * Set productAdditionItem
     *
     * @param \AppBundle\Entity\ProductAdditionItem $productAdditionItem
     *
     * @return CartItemProductAdditionItem
     */
    public function setProductAdditionItem(\AppBundle\Entity\ProductAdditionItem $productAdditionItem = null)
    {
        $this->productAdditionItem = $productAdditionItem;

        return $this;
    }

    /**
     * Get productAdditionItem
     *
     * @return \AppBundle\Entity\ProductAdditionItem
     */
    public function getProductAdditionItem()
    {
        return $this->productAdditionItem;
    }

    /**
     * Set productAddition
     *
     * @param \AppBundle\Entity\ProductAddition $productAddition
     *
     * @return CartItemProductAdditionItem
     */
    public function setProductAddition(\AppBundle\Entity\ProductAddition $productAddition = null)
    {
        $this->productAddition = $productAddition;

        return $this;
    }

    /**
     * Get productAddition
     *
     * @return \AppBundle\Entity\ProductAddition
     */
    public function getProductAddition()
    {
        return $this->productAddition;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return CartItemProductAdditionItem
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }
}
