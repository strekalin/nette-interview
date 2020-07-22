<?php
namespace App\Model\Repository;


use App\Model\Entity\Location;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method Location|null find($id, $lockMode = null, $lockVersion = null)
 * @method Location|null findOneBy(array $criteria, array $orderBy = null)
 * @method Location[]    findAll()
 * @method Location[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LocationRepository extends EntityRepository
{
    
    /**
     * Default constructor
     *
     * @param EntityManagerInterface $manager
     */
    public function __construct(EntityManagerInterface $manager)
    {
        parent::__construct($manager, $manager->getClassMetadata(Location::class));
    }
}