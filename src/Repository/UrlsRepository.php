<?php

namespace App\Repository;

use App\Entity\Urls;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Urls|null find($id, $lockMode = null, $lockVersion = null)
 * @method Urls|null findOneBy(array $criteria, array $orderBy = null)
 * @method Urls[]    findAll()
 * @method Urls[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UrlsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Urls::class);
    }

    public function getUrlsUser(){

        return $this->getEntityManager()
        ->createQuery('
        SELECT url.id, url.url, url.url_corta, url.clicks, url.fecha_creacion
        From App:Urls url  
        Order by url.fecha_creacion desc 
        ');

    }

    public function getUrls(){

        return $this->getEntityManager()
            ->createQuery('
        SELECT url.id, url.url, url.url_corta, url.clicks, url.fecha_creacion
        From App:Urls url  
        Order by url.clicks desc 
        ');

    }

    public function updateClicks($clicks, $id){

        return $this->getEntityManager()
            ->update(Project::class, 'u')

            ->set('u.clicks', ':clicks')
            ->setParameter('clicks', $clicks)
            ->where('u.id = :id')
            ->setParameter('id', $id)
            ->getQuery();

        $result = $query->execute();

        return $result;

    }

    // /**
    //  * @return Urls[] Returns an array of Urls objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Urls
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
