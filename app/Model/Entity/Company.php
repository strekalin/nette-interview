<?php
namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Feed
 *
 * @ORM\Table(name="company", uniqueConstraints={@ORM\UniqueConstraint(name="name_UNIQUE", columns={"name"})})
 * @ORM\Entity
 */
class Company
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
     * @ORM\Column(name="name", type="string", length=200, nullable=false)
     */
    private $name;
    
    /**
     * @var Job[]|mixed
     * 
     * @ORM\OneToMany(targetEntity="Job", mappedBy="company", fetch="LAZY")
     */
    private $jobs;
    
    /**
     * Default constructor
     * @param string $name
     */
    public function __construct($name)
    {
        $this->jobs = new ArrayCollection();
        $this->name = $name;
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
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * @return Job[]
     */
    public function getJobs()
    {
        return $this->jobs;
    }
}