<?php
namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Feed
 *
 * @ORM\Table(name="job", uniqueConstraints={@ORM\UniqueConstraint(name="ext_id_UNIQUE", columns={"ext_id"})})
 * @ORM\Entity
 */
class Job
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
     * @ORM\Column(name="title", type="string", length=200, nullable=false)
     */
    private $title;
    
    /**
     * @var string
     *
     * @ORM\Column(name="ext_id", type="string", length=100, nullable=false)
     */
    private $extId;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $created;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    private $updated;
    
    /**
     * @var JobDescription
     *
     * @ORM\OneToOne(targetEntity="JobDescription", mappedBy="job", cascade={"persist"}, fetch="EAGER")
     */
    private $description;
    
    /**
     * @var Company
     *
     * @ORM\ManyToOne(targetEntity="Company", fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="company_id", referencedColumnName="id")
     * })
     */
    private $company;
    
    /**
     * @var Location
     *
     * @ORM\ManyToOne(targetEntity="Location", fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="location_id", referencedColumnName="id")
     * })
     */
    private $location;
    
    /**
     * Default constructor
     * 
     * @param string $title
     * @param string $extId
     * @param Company $company
     * @param Location $location
     * @param JobDescription $description
     */
    public function __construct(string $title, string $extId, 
        Company $company, Location $location, JobDescription $description)
    {
        $this->created = new \DateTime();
        $this->updated = new \DateTime();
        $this->title = $title;
        $this->extId = $extId;
        $this->company = $company;
        $this->location = $location;
        $this->description = $description;
        $this->description->setJob($this);
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
    public function getTitle()
    {
        return $this->title;
    }
    
    /**
     * @return string
     */
    public function getExtId()
    {
        return $this->extId;
    }
    
    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }
    
    /**
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }
    
    /**
     * @return JobDescription
     */
    public function getDescription()
    {
        return $this->description;
    }
    
    /**
     * @return Company
     */
    public function getCompany()
    {
        return $this->company;
    }
    
    /**
     * @return Location
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param \DateTime $created
     * @return self
     */
    public function setCreated($created): self
    {
        $this->created = $created;
        return $this;
    }
    
    /**
     * @param \DateTime $updated
     * @return self
     */
    public function setUpdated($updated): self
    {
        $this->updated = $updated;
        return $this;
    }
}