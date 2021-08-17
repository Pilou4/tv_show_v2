<?php

namespace App\Repository;

use App\Entity\Season;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Season|null find($id, $lockMode = null, $lockVersion = null)
 * @method Season|null findOneBy(array $criteria, array $orderBy = null)
 * @method Season[]    findAll()
 * @method Season[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SeasonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Season::class);
    }
    
    public function findAllEpisodesOrderedByNumber($id)
    {
        $queryBuilder = $this->createQueryBuilder('season');

        $queryBuilder->where(
            $queryBuilder->expr()->eq('season.id', $id)
        );

        $queryBuilder->leftjoin('season.episodes', 'episode');
        $queryBuilder->addSelect('episode');

        $queryBuilder->orderBy('episode.number', 'asc');

        $query = $queryBuilder->getQuery();

        return $query->getOneOrNullResult();
        // return $query->getResult();
    }
}
