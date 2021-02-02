<?php

namespace App\Repository;

use App\Entity\Wish;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Wish|null find($id, $lockMode = null, $lockVersion = null)
 * @method Wish|null findOneBy(array $criteria, array $orderBy = null)
 * @method Wish[]    findAll()
 * @method Wish[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WishRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Wish::class);
    }

    public function findCategorizedWishes(): array
    {
        // REQUETE EN MODE CHAINE DQL
        // On sélectionne les wish et les categories
        // ON fait la jointure sur la propriété de la classe et thats it
        // On pense à préfixer le nom des colonnes par l'alias de la table
        /* $dql = "SELECT w, c
                FROM App\Entity\Wish w 
                JOIN w.category c 
                WHERE w.isPublished = 1 
                ORDER BY w.title
                ";

        $query = $this->getEntityManager()->createQuery($dql);
        */

        // REQUETE EN MODE QUERY BUILDER
        $queryBuilder = $this->createQueryBuilder('w');

        $queryBuilder->addOrderBy('w.title', 'DESC');
        $queryBuilder
            ->andWhere('w.isPublished = 1')
            ->join('w.category', 'c')
            ->addSelect('c');

        //if($categoryId){
            // $queryBuilder->andWhere();
        //}

        $query = $queryBuilder->getQuery();

        // limit
        $query->setMaxResults(30);

        //offset
        $query->setFirstResult(0);

        $wishes = $query->getResult();

        return $wishes;
    }

    // /**
    //  * @return Wish[] Returns an array of Wish objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Wish
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
