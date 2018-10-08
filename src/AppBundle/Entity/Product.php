<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductRepository")
 */
class Product
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
     * @var ProductBase
     *
     * @ORM\ManyToOne(targetEntity="ProductBase", inversedBy="products", cascade={"persist"})
     */
    private $productBase;

    /**
     * @var ProductVariant
     *
     * @ORM\ManyToOne(targetEntity="ProductVariant", inversedBy="products", cascade={"persist"})
     */
    private $productVariant;

    /**
     * @var ProductTakeoverType
     *
     * @ORM\ManyToOne(targetEntity="ProductTakeoverType", inversedBy="products", cascade={"persist"})
     */
    private $productTakeoverType;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="ProductAddition", inversedBy="products", cascade={"persist"})
     * @ORM\OrderBy({"position" = "ASC"})
     */
    private $productAdditions;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="decimal", scale=2, precision=6)
     */
    private $price;

    /**
     * @return string
     */
    public function getName(){

        return $this->getProductBase()->getName(). ($this->getProductVariant() ? ' / '.$this->getProductVariant()->getName() : '');

    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set productBase
     *
     * @param \AppBundle\Entity\ProductBase $productBase
     *
     * @return Product
     */
    public function setProductBase(ProductBase $productBase = null)
    {
        $productBase->addProduct($this);
        $this->productBase = $productBase;

        return $this;
    }

    /**
     * Get productBase
     *
     * @return \AppBundle\Entity\ProductBase
     */
    public function getProductBase()
    {
        return $this->productBase;
    }

    /**
     * Set productVariant
     *
     * @param \AppBundle\Entity\ProductVariant $productVariant
     *
     * @return Product
     */
    public function setProductVariant(ProductVariant $productVariant = null)
    {
        $productVariant->addProduct($this);
        $this->productVariant = $productVariant;

        return $this;
    }

    /**
     * Get productVariant
     *
     * @return \AppBundle\Entity\ProductVariant
     */
    public function getProductVariant()
    {
        return $this->productVariant;
    }

    /**
     * Set productTakeoverType
     *
     * @param \AppBundle\Entity\ProductTakeoverType $productTakeoverType
     *
     * @return Product
     */
    public function setProductTakeoverType(ProductTakeoverType $productTakeoverType = null)
    {
        $productTakeoverType->addProduct($this);
        $this->productTakeoverType = $productTakeoverType;

        return $this;
    }

    /**
     * Get productTakeoverType
     *
     * @return \AppBundle\Entity\ProductTakeoverType
     */
    public function getProductTakeoverType()
    {
        return $this->productTakeoverType;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->productAdditions = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add productAddition
     *
     * @param \AppBundle\Entity\ProductAddition $productAddition
     *
     * @return Product
     */
    public function addProductAddition(\AppBundle\Entity\ProductAddition $productAddition)
    {
        $this->productAdditions[] = $productAddition;

        return $this;
    }

    /**
     * Remove productAddition
     *
     * @param \AppBundle\Entity\ProductAddition $productAddition
     */
    public function removeProductAddition(\AppBundle\Entity\ProductAddition $productAddition)
    {
        $this->productAdditions->removeElement($productAddition);
    }

    /**
     * Get productAdditions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProductAdditions()
    {
        return $this->productAdditions;
    }
}
