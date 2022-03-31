<?php

namespace App\Repository;

use App\Data\searchTeam;
use App\Entity\Team;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @method Team|null find($id, $lockMode = null, $lockVersion = null)
 * @method Team|null findOneBy(array $criteria, array $orderBy = null)
 * @method Team[]    findAll()
 * @method Team[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TeamRepository extends ServiceEntityRepository
{
    /**
     * @var PaginatorInterface
     */
    private $paginator;

    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Team::class);
        $this->paginator = $paginator;
    }

    /**
     * Récupère les teams en lien avec une recherche
     * @param searchTeam $data
     * @return \Knp\Component\Pager\Pagination\PaginationInterface
     */
    public function findTeam(searchTeam $searchTeam) : \Knp\Component\Pager\Pagination\PaginationInterface
    {

        $query = $this
            ->createQueryBuilder('team')
            ->join('team.tier', 'tiers')
            ->join('team.sets', 'set')
            ->join('set.pokemon', 'pokemon')
        ;

        if (!empty($searchTeam->q))
        {
            $query = $query
                ->andWhere('team.name LIKE :q')
                ->setParameter('q', "%{$searchTeam->q}%")
            ;
        }



        if (!empty($searchTeam->tiers))
        {
            $query = $query
                ->andWhere('tiers.id = :tier')
                ->setParameter('tier', $searchTeam->tiers->getId())
                ;
        }


        dump($searchTeam->pokemon);

        if (!empty($searchTeam->pokemon))
        {
            $query = $query
                ->andWhere('pokemon.id = :pokemon')
                ->setParameter('pokemon', $searchTeam->pokemon->getId() )
            ;
        }

        $query = $query->getQuery()->getResult();

        return $this->paginator->paginate(
          $query,
          1,
          4
        );
    }
}
