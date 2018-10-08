<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Traits\EnumerationTrait;

/**
 * ProductAdditionItem
 *
 * @ORM\Table(name="product_addition_item")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductAdditionItemRepository")
 */
class ProductAdditionItem
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
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\ProductAddition", inversedBy="items", cascade={"persist"})
     */
    private $productAdditions;

    /**
     * @var float
     *
     * @ORM\Column(name="surcharge", type="decimal", scale=2, precision=6)
     */
    private $surcharge;

    /**
     * @return string
     */
    public function getFullName(){

        if($this->getSurcharge() == 0){
            return $this->getName();
        }

        if($this->getSurcharge() == round($this->getSurcharge())){

            return $this->getName().' (+'.round($this->getSurcharge()).' Kč)';

        }

        return $this->getName().' (+'.$this->getSurcharge().' Kč)';

    }

	/**
	 * @return string
	 */
	public function getFullHtmlName(){

		if($this->getSurcharge() == 0){
			return $this->getName();
		}

		if($this->getSurcharge() == round($this->getSurcharge())){

			return $this->getName().' <span>+'.round($this->getSurcharge()).' Kč</span>';

		}

		return $this->getName().' <span>+'.$this->getSurcharge().' Kč</span>';

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
     * Set slug
     *
     * @param string $slug
     *
     * @return ProductAdditionItem
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Set surcharge
     *
     * @param float $surcharge
     *
     * @return ProductAdditionItem
     */
    public function setSurcharge($surcharge)
    {
        $this->surcharge = $surcharge;

        return $this;
    }

    /**
     * Get surcharge
     *
     * @return float
     */
    public function getSurcharge()
    {
        return $this->surcharge;
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
     * @return ProductAdditionItem
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
