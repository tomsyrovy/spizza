<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Traits\EnumerationTrait;

/**
 * ProductAddition
 *
 * @ORM\Table(name="product_addition")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductAdditionRepository")
 */
class ProductAddition
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    use EnumerationTrait;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="ProductAdditionItem", mappedBy="productAdditions", cascade={"persist"})
     * @ORM\OrderBy({"position" = "ASC"})
     */
    private $items;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Product", mappedBy="productAdditions", cascade={"persist"})
     */
    private $products;

	/**
	 * @var boolean
	 *
	 * @ORM\Column(name="multiple", type="boolean")
	 */
    private $multiple = false;

    /**
     * @return string
     */
    public function getFullName(){

        $names = [];

        $items = $this->getItems();

        /** @var ProductAdditionItem $item */
        foreach($items as $item){

            $names[] = $item->getName().' (+'.$item->getSurcharge().',-)';

        }

        return $this->getName().' ['.implode('; ', $names).']';

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
     * Constructor
     */
    public function __construct()
    {
        $this->items = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return ProductAddition
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Add item
     *
     * @param \AppBundle\Entity\ProductAdditionItem $item
     *
     * @return ProductAddition
     */
    public function addItem(\AppBundle\Entity\ProductAdditionItem $item)
    {
        $this->items[] = $item;

        return $this;
    }

    /**
     * Remove item
     *
     * @param \AppBundle\Entity\ProductAdditionItem $item
     */
    public function removeItem(\AppBundle\Entity\ProductAdditionItem $item)
    {
        $this->items->removeElement($item);
    }

    /**
     * Get items
     *
     * @return ArrayCollection
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Add product
     *
     * @param \AppBundle\Entity\Product $product
     *
     * @return ProductAddition
     */
    public function addProduct(\AppBundle\Entity\Product $product)
    {
        $this->products[] = $product;

        return $this;
    }

    /**
     * Remove product
     *
     * @param \AppBundle\Entity\Product $product
     */
    public function removeProduct(\AppBundle\Entity\Product $product)
    {
        $this->products->removeElement($product);
    }

    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * Set multiple
     *
     * @param boolean $multiple
     *
     * @return ProductAddition
     */
    public function setMultiple($multiple)
    {
        $this->multiple = $multiple;

        return $this;
    }

    /**
     * Get multiple
     *
     * @return boolean
     */
    public function getMultiple()
    {
        return $this->multiple;
    }
}
