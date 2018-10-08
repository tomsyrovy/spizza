<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\EnumerationTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * ProductLabel
 *
 * @ORM\Table(name="product_label")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductLabelRepository")
 */
class ProductLabel
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
     * @ORM\ManyToMany(targetEntity="ProductBase", mappedBy="productLabels", cascade={"persist"})
     */
    private $productBases;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->productBases = new ArrayCollection();
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
     * Add product
     *
     * @param \AppBundle\Entity\ProductBase $productBase
     *
     * @return ProductCategory
     */
    public function addProductBase(ProductBase $productBase)
    {
        $productBase->addProductLabel($this);
        $this->productBases[] = $productBase;

        return $this;
    }

    /**
     * Remove product
     *
     * @param \AppBundle\Entity\ProductBase $productBase
     */
    public function removeProductBase(ProductBase $productBase)
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
     * Set slug
     *
     * @param string $slug
     *
     * @return ProductLabel
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }
}
