<?php
namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Feed
 *
 * @ORM\Table(name="job_description")
 * @ORM\Entity
 */
class JobDescription
{
    /**
     * @var Job
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Job")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="job_id", referencedColumnName="id")
     * })
     */
    private $job;
    
    /**
     * @var string
     *
     * @ORM\Column(name="ad", type="text", nullable=false)
     */
    private $ad;

    /**
     * Default constructor
     * 
     * @param string $ad
     */
    public function __construct($ad)
    {
        $this->ad = $ad;
    }
    
    /**
     * @return Job
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * @return string
     */
    public function getAd()
    {
        return $this->ad;
    }
    
    /**
     * @param Job $job
     * @return self
     */
    public function setJob($job): self
    {
        $this->job = $job;
        return $this;
    }
}