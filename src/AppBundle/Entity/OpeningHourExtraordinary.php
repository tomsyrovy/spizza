<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OpeningHourExtraordinary
 *
 * @ORM\Table(name="opening_hour_extraordinary")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OpeningHourExtraordinaryRepository")
 */
class OpeningHourExtraordinary
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var LocalBusiness
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\LocalBusiness", cascade={"persist"}, inversedBy="openingHoursExtraordinary")
     */
    private $localBusiness;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="timeFrom", type="time")
     */
    private $timeFrom;

    /**
     * @var string
     *
     * @ORM\Column(name="timeTo", type="string", length=255)
     */
    private $timeTo;


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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return OpeningHourExtraordinary
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set timeFrom
     *
     * @param \DateTime $timeFrom
     *
     * @return OpeningHourExtraordinary
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
     * Set timeTo
     *
     * @param string $timeTo
     *
     * @return OpeningHourExtraordinary
     */
    public function setTimeTo($timeTo)
    {
        $this->timeTo = $timeTo;

        return $this;
    }

    /**
     * Get timeTo
     *
     * @return string
     */
    public function getTimeTo()
    {
        return $this->timeTo;
    }

    /**
     * Set localBusiness
     *
     * @param \AppBundle\Entity\LocalBusiness $localBusiness
     *
     * @return OpeningHourExtraordinary
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
}
