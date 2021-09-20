<?php

namespace App\Repository;

use App\Entity\Messaging;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Messaging|null find($id, $lockMode = null, $lockVersion = null)
 * @method Messaging|null findOneBy(array $criteria, array $orderBy = null)
 * @method Messaging[]    findAll()
 * @method Messaging[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessagingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Messaging::class);
    }

    public function findByAuthorOrParticipants($id)
    {
        return $this->createQueryBuilder('p')
            ->leftJoin('p.participants', 'Participants')
            ->leftJoin('p.messages', 'Messages')
            ->orderBy('Messages.id', 'DESC')
            ->where('p.author = :id')
            ->orWhere('Participants.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }

    public function findByAuthorAndParticipant($user, $currentUser)
    {
        return $this->createQueryBuilder('p')
            ->join('p.participants', 'Participants')
            ->where('p.author = :currentUser AND Participants.id = :user')
            ->orWhere('Participants.id = :currentUser AND p.author = :user')
            ->setParameters(['user' => $user, 'currentUser' => $currentUser])
            ->groupBy('p')
            ->andWhere('count(Participants) = 1')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    // public function findByAuthorAndParticipant($user, $currentUser)
    // {
    //     return $this->createQueryBuilder('d')
    //         ->leftJoin('d.participants', 'p')
    //         ->andWhere('p.id = :user1')
    //         ->andWhere('p.id = :user2')
    //         ->andWhere('count(p) = 2')
    //         ->setParameters(['user1' => $user, 'user2' => $currentUser])
    //         ->setMaxResults(1)
    //         ->getQuery()
    //         ->getOneOrNullResult();
    // }

    // public function findOneDiscussionByUser(array $users, $currentUser)
    // {
    //     $query = $this->createQueryBuilder('d')
    //         ->leftJoin('d.participants', 'p')
    //         ->setMaxResults(1);

    //     foreach ($users as $user) {
    //         $query
    //             ->where('d.author = :currentUser AND p.id = :user')
    //             ->orWhere('d.author = :user AND p.id = :currentUser')
    //             ->andWhere('p.user = :user')
    //             ->setParameters(['user' => $user, 'currentUser' => $currentUser]);
    //     }

    //     return $query
    //         ->getQuery()
    //         ->getOneOrNullResult();
    // }
}
