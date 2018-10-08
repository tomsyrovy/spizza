<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\EnumerationTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * LocalBusiness
 *
 * @ORM\Table(name="local_business")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LocalBusinessRepository")
 */
class LocalBusiness
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
     * @var Address
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Address", cascade={"persist"})
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $address;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\OpeningHour", mappedBy="localBusiness")
     */
    private $openingHours;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\OpeningHourExtraordinary", mappedBy="localBusiness")
     */
    private $openingHoursExtraordinary;

	/**
	 * @return string
	 */
    public function getMapyCZLink(){
    	return "https://mapy.cz/zakladni?q=".urlencode($this->getAddress()->getFullAddress());
    }

    public function getFullName(){

    	return $this->getName().' ('.$this->getAddress()->getFullAddress().')';

    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->openingHours = new \Doctrine\Common\Collections\ArrayCollection();
        $this->openingHoursExtraordinary = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set slug
     *
     * @param string $slug
     *
     * @return LocalBusiness
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Set address
     *
     * @param \AppBundle\Entity\Address $address
     *
     * @return LocalBusiness
     */
    public function setAddress(\AppBundle\Entity\Address $address = null)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return \AppBundle\Entity\Address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Add openingHour
     *
     * @param \AppBundle\Entity\OpeningHour $openingHour
     *
     * @return LocalBusiness
     */
    public function addOpeningHour(\AppBundle\Entity\OpeningHour $openingHour)
    {
        $this->openingHours[] = $openingHour;

        return $this;
    }

    /**
     * Remove openingHour
     *
     * @param \AppBundle\Entity\OpeningHour $openingHour
     */
    public function removeOpeningHour(\AppBundle\Entity\OpeningHour $openingHour)
    {
        $this->openingHours->removeElement($openingHour);
    }

    /**
     * Get openingHours
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOpeningHours()
    {
        return $this->openingHours;
    }

    /**
     * Add openingHoursExtraordinary
     *
     * @param \AppBundle\Entity\OpeningHour $openingHoursExtraordinary
     *
     * @return LocalBusiness
     */
    public function addOpeningHoursExtraordinary(\AppBundle\Entity\OpeningHour $openingHoursExtraordinary)
    {
        $this->openingHoursExtraordinary[] = $openingHoursExtraordinary;

        return $this;
    }

    /**
     * Remove openingHoursExtraordinary
     *
     * @param \AppBundle\Entity\OpeningHour $openingHoursExtraordinary
     */
    public function removeOpeningHoursExtraordinary(\AppBundle\Entity\OpeningHour $openingHoursExtraordinary)
    {
        $this->openingHoursExtraordinary->removeElement($openingHoursExtraordinary);
    }

    /**
     * Get openingHoursExtraordinary
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOpeningHoursExtraordinary()
    {
        return $this->openingHoursExtraordinary;
    }
}
