<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\EnumerationTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * PaymentMethod
 *
 * @ORM\Table(name="payment_method")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PaymentMethodRepository")
 */
class PaymentMethod
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
	 * @ORM\ManyToMany(targetEntity="AppBundle\Entity\ProductTakeoverType", mappedBy="paymentMethods", cascade={"persist"})
	 */
    private $takeOverTypes;

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
        $this->takeOverTypes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return PaymentMethod
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Add takeOverType
     *
     * @param \AppBundle\Entity\ProductTakeoverType $takeOverType
     *
     * @return PaymentMethod
     */
    public function addTakeOverType(\AppBundle\Entity\ProductTakeoverType $takeOverType)
    {
        $this->takeOverTypes[] = $takeOverType;

        return $this;
    }

    /**
     * Remove takeOverType
     *
     * @param \AppBundle\Entity\ProductTakeoverType $takeOverType
     */
    public function removeTakeOverType(\AppBundle\Entity\ProductTakeoverType $takeOverType)
    {
        $this->takeOverTypes->removeElement($takeOverType);
    }

    /**
     * Get takeOverTypes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTakeOverTypes()
    {
        return $this->takeOverTypes;
    }
}
