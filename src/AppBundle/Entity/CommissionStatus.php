<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\EnumerationTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * CommissionStatus
 *
 * @ORM\Table(name="commission_status")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CommissionStatusRepository")
 */
class CommissionStatus
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
     * @return CommissionStatus
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }
}
