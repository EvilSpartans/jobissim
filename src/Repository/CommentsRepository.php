<?php

namespace App\Repository;

use App\Entity\Comments;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Comments|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comments|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comments[]    findAll()
 * @method Comments[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comments::class);
    }

    /**
     * Find comments by post
     *
     * @param [type] $id
     * @return void
     */
    public function findCommentByPost($id)
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.id', 'DESC')
            ->join('p.post', 'Post')
            ->andWhere('Post.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }
}
