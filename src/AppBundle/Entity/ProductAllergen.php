<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\EnumerationTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * ProductAllergen
 *
 * @ORM\Table(name="product_allergen")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductAllergenRepository")
 */
class ProductAllergen
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
     * @ORM\ManyToMany(targetEntity="ProductBase", mappedBy="productAllergens", cascade={"persist"})
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
     * Constructor
     */
    public function __construct()
    {
        $this->productBases = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add productBase
     *
     * @param \AppBundle\Entity\ProductBase $productBase
     *
     * @return ProductAllergen
     */
    public function addProductBase(\AppBundle\Entity\ProductBase $productBase)
    {
        $this->productBases[] = $productBase;

        return $this;
    }

    /**
     * Remove productBase
     *
     * @param \AppBundle\Entity\ProductBase $productBase
     */
    public function removeProductBase(\AppBundle\Entity\ProductBase $productBase)
    {
        $this->productBases->removeElement($productBase);
    }

    /**
     * Get productBases
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
     * @return ProductAllergen
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }
}
