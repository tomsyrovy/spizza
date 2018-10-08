<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\EnumerationTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * ProductAttribute
 *
 * @ORM\Table(name="product_attribute")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductAttributeRepository")
 */
class ProductAttribute
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
     * @ORM\ManyToMany(targetEntity="ProductBase", mappedBy="productAttributes", cascade={"persist"})
     */
    private $productBases;

	/**
	 * @var boolean
	 *
	 * @ORM\Column(name="visible_in_menu", type="boolean")
	 */
    private $visibleInMenu = true;


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
     * Add product
     *
     * @param \AppBundle\Entity\ProductBase $productBase
     *
     * @return ProductAttribute
     */
    public function addProduct(ProductBase $productBase)
    {
        $productBase->addProductAttribute($this);
        $this->productBases[] = $productBase;

        return $this;
    }

    /**
     * Remove product
     *
     * @param \AppBundle\Entity\ProductBase $productBase
     */
    public function removeProduct(ProductBase $productBase)
    {
        $this->productBases->removeElement($productBase);
    }

    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProductBases()
    {
        return $this->productBases;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->productBases = new ArrayCollection();
    }

    /**
     * Add productBase
     *
     * @param \AppBundle\Entity\ProductBase $productBase
     *
     * @return ProductAttribute
     */
    public function addProductBase(ProductBase $productBase)
    {
        $this->productBases[] = $productBase;

        return $this;
    }

    /**
     * Remove productBase
     *
     * @param \AppBundle\Entity\ProductBase $productBase
     */
    public function removeProductBase(ProductBase $productBase)
    {
        $this->productBases->removeElement($productBase);
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return ProductAttribute
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Set visibleInMenu
     *
     * @param boolean $visibleInMenu
     *
     * @return ProductAttribute
     */
    public function setVisibleInMenu($visibleInMenu)
    {
        $this->visibleInMenu = $visibleInMenu;

        return $this;
    }

    /**
     * Get visibleInMenu
     *
     * @return boolean
     */
    public function getVisibleInMenu()
    {
        return $this->visibleInMenu;
    }
}
