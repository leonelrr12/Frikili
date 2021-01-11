<?php

namespace App\Repository;

use App\Entity\Comentarios;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Comentarios|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comentarios|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comentarios[]    findAll()
 * @method Comentarios[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ComentariosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comentarios::class);
    }

    public function getComments($user_id){
        return $this->getEntityManager()
            ->createQuery('
                SELECT c.id, c.comentario, p.id
                FROM App:Comentarios c
                JOIN c.posts p
                WHERE c.user =:user_id
            ')
            ->setParameter('user_id', $user_id)
            ->setMaxResults(10)
            ->getResult();
    }

    public function getCommentsPost($post_id){
        return $this->getEntityManager()
            ->createQuery('
                SELECT c.id, c.comentario, u.nombre
                FROM App:Comentarios c
                JOIN c.user u
                WHERE c.posts =:post_id
            ')
            ->setParameter('post_id', $post_id);
    }

    // /**
    //  * @return Comentarios[] Returns an array of Comentarios objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Comentarios
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
