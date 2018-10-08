<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OpeningHour
 *
 * @ORM\Table(name="opening_hour")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OpeningHourRepository")
 */
class OpeningHour
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
     * @var Day
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Day", cascade={"persist"})
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $day;

    /**
     * @var LocalBusiness
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\LocalBusiness", cascade={"persist"}, inversedBy="openingHours")
     */
    private $localBusiness;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="timeFrom", type="time")
     */
    private $timeFrom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="timeTo", type="time")
     */
    private $timeTo;

	/**
	 * @var \AppBundle\Entity\ProductTakeoverType
	 *
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ProductTakeoverType", cascade={"persist"})
	 * @ORM\JoinColumn(referencedColumnName="id")
	 */
    private $productTakeOverType;

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
     * Set timeFrom
     *
     * @param \DateTime $timeFrom
     *
     * @return OpeningHour
     */
    public function setTimeFrom($timeFrom)
    {
        $this->timeFrom = $timeFrom;

        return $this;
    }

    /**
     * Get timeFrom
     *
     * @return \DateTime
     */
    public function getTimeFrom()
    {
        return $this->timeFrom;
    }

    /**
     * Set day
     *
     * @param \AppBundle\Entity\Day $day
     *
     * @return OpeningHour
     */
    public function setDay(\AppBundle\Entity\Day $day = null)
    {
        $this->day = $day;

        return $this;
    }

    /**
     * Get day
     *
     * @return \AppBundle\Entity\Day
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * Set localBusiness
     *
     * @param \AppBundle\Entity\LocalBusiness $localBusiness
     *
     * @return OpeningHour
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

    /**
     * Set timeTo
     *
     * @param \DateTime $timeTo
     *
     * @return OpeningHour
     */
    public function setTimeTo($timeTo)
    {
        $this->timeTo = $timeTo;

        return $this;
    }

    /**
     * Get timeTo
     *
     * @return \DateTime
     */
    public function getTimeTo()
    {
        return $this->timeTo;
    }


    /**
     * Set productTakeOverType
     *
     * @param \AppBundle\Entity\ProductTakeoverType $productTakeOverType
     *
     * @return OpeningHour
     */
    public function setProductTakeOverType(\AppBundle\Entity\ProductTakeoverType $productTakeOverType = null)
    {
        $this->productTakeOverType = $productTakeOverType;

        return $this;
    }

    /**
     * Get productTakeOverType
     *
     * @return \AppBundle\Entity\ProductTakeoverType
     */
    public function getProductTakeOverType()
    {
        return $this->productTakeOverType;
    }
}
