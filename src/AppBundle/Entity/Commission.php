<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commission
 *
 * @ORM\Table(name="commission")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CommissionRepository")
 */
class Commission
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
	 * @var int
	 *
	 * @ORM\Column(name="number", type="integer", unique=true)
	 */
    private $number;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var Cart
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Cart")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $cart;

    /**
     * @var Customer
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Customer")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $customer;

    /**
     * @var CommissionStatus
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CommissionStatus")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $commissionStatus;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="comment", type="text", nullable=true)
	 */
    private $comment;

	/**
	 * @var \AppBundle\Entity\PaymentMethod
	 *
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PaymentMethod")
	 * @ORM\JoinColumn(referencedColumnName="id")
	 */
    private $paymentMethod;


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
     * @return Commission
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
     * Set cart
     *
     * @param \AppBundle\Entity\Cart $cart
     *
     * @return Commission
     */
    public function setCart(\AppBundle\Entity\Cart $cart = null)
    {
        $this->cart = $cart;

        return $this;
    }

    /**
     * Get cart
     *
     * @return \AppBundle\Entity\Cart
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * Set customer
     *
     * @param \AppBundle\Entity\Customer $customer
     *
     * @return Commission
     */
    public function setCustomer(\AppBundle\Entity\Customer $customer = null)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return \AppBundle\Entity\Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Set commissionStatus
     *
     * @param \AppBundle\Entity\CommissionStatus $commissionStatus
     *
     * @return Commission
     */
    public function setCommissionStatus(\AppBundle\Entity\CommissionStatus $commissionStatus = null)
    {
        $this->commissionStatus = $commissionStatus;

        return $this;
    }

    /**
     * Get commissionStatus
     *
     * @return \AppBundle\Entity\CommissionStatus
     */
    public function getCommissionStatus()
    {
        return $this->commissionStatus;
    }

    /**
     * Set number
     *
     * @param integer $number
     *
     * @return Commission
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return integer
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return Commission
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set paymentMethod
     *
     * @param \AppBundle\Entity\PaymentMethod $paymentMethod
     *
     * @return Commission
     */
    public function setPaymentMethod(\AppBundle\Entity\PaymentMethod $paymentMethod = null)
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }

    /**
     * Get paymentMethod
     *
     * @return \AppBundle\Entity\PaymentMethod
     */
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }
}
