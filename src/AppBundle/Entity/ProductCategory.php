<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\EnumerationTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * ProductCategory
 *
 * @ORM\Table(name="product_category")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductCategoryRepository")
 */
class ProductCategory
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
     * @ORM\ManyToMany(targetEntity="ProductBase", mappedBy="productCategories", cascade={"persist"})
     */
    private $productBases;


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
     * @return ProductCategory
     */
    public function addProduct(ProductBase $productBase)
    {
        $productBase->addProductCategory($this);
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
     * @return ProductCategory
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
     * @return ProductCategory
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }
}
