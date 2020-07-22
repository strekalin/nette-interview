<?php
namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Feed
 *
 * @ORM\Table(name="location", uniqueConstraints={@ORM\UniqueConstraint(name="address_UNIQUE", columns={"address"})})
 * @ORM\Entity
 */
class Location
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=false)
     */
    private $address;
    
    /**
     * @var Job[]|mixed
     *
     * @ORM\OneToMany(targetEntity="Job", mappedBy="location", fetch="LAZY")
     */
    private $jobs;
    
    /**
     * Default constructor
     * @param string $address
     */
    public function __construct($address)
    {
        $this->jobs = new ArrayCollection();
        $this->address = $address;
    }
    
    /**
     * @return Job[]
     */
    public function getJobs()
    {
        return $this->jobs;
    }

    /**
     * @return number
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }
}