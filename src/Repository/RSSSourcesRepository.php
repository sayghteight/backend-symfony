<?php

namespace App\Repository;

use App\Entity\RSSSources;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RSSSources>
 *
 * @method RSSSources|null find($id, $lockMode = null, $lockVersion = null)
 * @method RSSSources|null findOneBy(array $criteria, array $orderBy = null)
 * @method RSSSources[]    findAll()
 * @method RSSSources[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RSSSourcesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RSSSources::class);
    }
}
