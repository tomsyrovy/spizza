<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Cart
 *
 * @ORM\Table(name="cart")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CartRepository")
 */
class Cart
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\CartItem", mappedBy="cart", cascade={"persist"})
     */
    private $cartItems;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var ProductTakeoverType
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ProductTakeoverType")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $takeOverType;

	/**
	 * @var \AppBundle\Entity\LocalBusiness
	 *
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\LocalBusiness")
	 * @ORM\JoinColumn(referencedColumnName="id", nullable=true)
	 */
	private $localBusiness;

    public function getPrice(){

    	$price = $this->getTakeOverType()->getPrice();

    	/** @var \AppBundle\Entity\CartItem $cartItem */
	    foreach($this->getCartItems() as $cartItem){
    		$price = $price + $cartItem->getPricePerUnit()*$cartItem->getAmount();
	    }

	    return $price;

    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->cartItems = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Cart
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Add cartItem
     *
     * @param \AppBundle\Entity\CartItem $cartItem
     *
     * @return Cart
     */
    public function addCartItem(\AppBundle\Entity\CartItem $cartItem)
    {
        $this->cartItems[] = $cartItem;

        return $this;
    }

    /**
     * Remove cartItem
     *
     * @param \AppBundle\Entity\CartItem $cartItem
     */
    public function removeCartItem(\AppBundle\Entity\CartItem $cartItem)
    {
        $this->cartItems->removeElement($cartItem);
    }

    /**
     * Get cartItems
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCartItems()
    {
        return $this->cartItems;
    }

    /**
     * Set takeOverType
     *
     * @param \AppBundle\Entity\ProductTakeoverType $takeOverType
     *
     * @return Cart
     */
    public function setTakeOverType(\AppBundle\Entity\ProductTakeoverType $takeOverType = null)
    {
        $this->takeOverType = $takeOverType;

        return $this;
    }

    /**
     * Get takeOverType
     *
     * @return \AppBundle\Entity\ProductTakeoverType
     */
    public function getTakeOverType()
    {
        return $this->takeOverType;
    }

    /**
     * Set localBusiness
     *
     * @param \AppBundle\Entity\LocalBusiness $localBusiness
     *
     * @return Cart
     */
    public function setLocalBusiness(\AppBundle\Entity\LocalBusiness $localBusiness = null)
    {
        $this->localBusiness = $localBusiness;

        return $this;
    }

    /**
     * Get localBusiness
     *
     * @return \AppBundle\Entity\LocalBusiness
     */
    public function getLocalBusiness()
    {
        return $this->localBusiness;
    }
}
